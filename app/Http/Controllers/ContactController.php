<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\FormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{

    // =========================================================================
    // reCAPTCHA
    // =========================================================================

    private function isRecaptchaEnabled(): bool
    {
        return setting('contact-information.recaptcha-status') == 'aktif';
    }

    private function verifyRecaptcha(Request $request): ?\Illuminate\Http\RedirectResponse
    {
        if (!$this->isRecaptchaEnabled()) {
            return null;
        }

        $recaptchaResponse = $request->input('g-recaptcha-response');

        if (empty($recaptchaResponse)) {
            return back()
                ->withInput()
                ->withErrors(['recaptcha' => __('ui.contact.recaptcha_required')]);
        }

        try {
            $response = Http::timeout(10)->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => setting('contact-information.recaptcha-secret-key'),
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip(),
            ]);

            $result = $response->json();

            if (!($result['success'] ?? false)) {
                return back()
                    ->withInput()
                    ->withErrors(['recaptcha' => __('ui.contact.recaptcha_failed')]);
            }
        } catch (\Exception $e) {
            Log::error('reCAPTCHA doğrulama hatası: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['recaptcha' => __('ui.contact.recaptcha_error')]);
        }

        return null;
    }

    // =========================================================================
    // Email Sending
    // =========================================================================

    private function sendFormEmail(
        string $subject,
        string $viewName,
        array $data = [],
        ?string $replyTo = null
    ): void {
        try {
            $email = setting('contact-information.form-email');

            if ($email) {
                Mail::to($email)->send(new FormMail(
                    subject: $subject,
                    viewName: $viewName,
                    data: $data,
                    replyTo: $replyTo,
                ));
            }
        } catch (\Exception $e) {
            Log::error("Form e-posta gönderim hatası: " . $e->getMessage());
        }
    }

    // =========================================================================
    // Contact Form
    // =========================================================================

    public function ContactForm($locale, Request $request)
    {
        $recaptchaError = $this->verifyRecaptcha($request);
        if ($recaptchaError) {
            return $recaptchaError;
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'surname' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'min:2', 'max:20'],
            'subject' => ['required', 'string', 'min:2', 'max:200'],
            'message' => ['required', 'string', 'min:2', 'max:10000'],
        ]);

        $contact = Contact::create($validatedData);

        $this->sendFormEmail(
            subject: setting('site.title') . " | Yeni İletişim Mesajı: {$contact->subject}",
            viewName: 'emails.contact-form',
            data: ['contact' => $contact],
            replyTo: $contact->email,
        );

        return back()->with([
            'message' => __('ui.contact.success_message'),
            'alert-type' => 'success',
        ]);
    }

}
