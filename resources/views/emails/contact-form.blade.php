<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Yeni İletişim Mesajı</title>
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }

            .fluid-column {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            .mobile-padding {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
        }
    </style>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="background-color: #f4f6f8;">
        <tr>
            <td align="center" style="padding: 40px 0;">

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600"
                    class="email-container"
                    style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">

                    <tr>
                        <td bgcolor="#2d3748" style="padding: 30px 40px; text-align: center;">
                            <h1
                                style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 24px; line-height: 30px; color: #ffffff; font-weight: bold;">
                                {{ setting('site.title') }}
                            </h1>
                            <p style="margin: 5px 0 0; font-size: 16px; line-height: 24px; color: #a0aec0;">
                                <a href="{{ url('/') }}"
                                    style="color: #a0aec0; text-decoration: none;">{{ url('/') }}</a> - Sitesinden
                                Yeni Mesaj
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td class="mobile-padding" style="padding: 40px 40px 20px 40px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding-bottom: 20px; border-bottom: 1px solid #e2e8f0;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                            width="100%">

                                            <tr>
                                                <td width="30%"
                                                    style="padding: 8px 0; font-size: 14px; color: #718096; font-weight: bold;">
                                                    Ad Soyad:</td>
                                                <td width="70%"
                                                    style="padding: 8px 0; font-size: 15px; color: #2d3748;">
                                                    {{ $contact->name . " " . $contact->surname }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td
                                                    style="padding: 8px 0; font-size: 14px; color: #718096; font-weight: bold;">
                                                    E-Posta:</td>
                                                <td style="padding: 8px 0; font-size: 15px; color: #2d3748;">
                                                    <a href="mailto:{{ $contact->email }}"
                                                        style="color: #3182ce; text-decoration: none;">{{ $contact->email }}</a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td
                                                    style="padding: 8px 0; font-size: 14px; color: #718096; font-weight: bold;">
                                                    Telefon:</td>
                                                <td style="padding: 8px 0; font-size: 15px; color: #2d3748;">
                                                    {{ $contact->phone ?? '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td
                                                    style="padding: 8px 0; font-size: 14px; color: #718096; font-weight: bold;">
                                                    Konu:</td>
                                                <td style="padding: 8px 0; font-size: 15px; color: #2d3748;">
                                                    {{ $contact->subject ?? '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td
                                                    style="padding: 8px 0; font-size: 14px; color: #718096; font-weight: bold;">
                                                    Tarih:</td>
                                                <td style="padding: 8px 0; font-size: 15px; color: #2d3748;">
                                                    {{ $contact->created_at->format('d.m.Y H:i') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="mobile-padding" style="padding: 0 40px 40px 40px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding-top: 20px;">
                                        <p
                                            style="margin: 0 0 10px 0; font-size: 14px; font-weight: bold; color: #4a5568; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Mesaj İçeriği</p>

                                        <div
                                            style="background-color: #f7fafc; border-left: 4px solid #3182ce; padding: 20px; border-radius: 4px;">
                                            <p
                                                style="margin: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px; color: #2d3748;">
                                                {!! nl2br(e($contact->message)) !!}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>