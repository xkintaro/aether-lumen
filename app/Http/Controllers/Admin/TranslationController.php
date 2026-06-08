<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TranslationScannerService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use TCG\Voyager\Facades\Voyager;

class TranslationController extends Controller
{
    protected $scanner;

    public function __construct(TranslationScannerService $scanner)
    {
        $this->scanner = $scanner;
    }

    public function index(Request $request)
    {
        $this->authorize('browse_admin');

        $allTranslations = $this->scanner->getAllTranslations();
        $locales = config('voyager.multilingual.locales');

        $search = $request->input('s');
        $perPage = $request->input('per_page', 10);

        if ($search) {
            $allTranslations = array_filter($allTranslations, function ($item, $key) use ($search) {
                if (stripos($key, $search) !== false)
                    return true;
                foreach ($item as $val) {
                    if (stripos($val, $search) !== false)
                        return true;
                }
                return false;
            }, ARRAY_FILTER_USE_BOTH);
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($allTranslations, ($currentPage - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator($currentItems, count($allTranslations), $perPage);
        $paginator->setPath($request->url());

        $paginator->appends(['s' => $search, 'per_page' => $perPage]);

        return view('admin.scanner', [
            'translations' => $paginator,
            'locales' => $locales,
            'search' => $search,
            'perPage' => $perPage
        ]);
    }

    public function scan()
    {
        $this->authorize('browse_admin');

        try {
            $count = $this->scanner->scanAndSync();
            return redirect()->back()->with([
                'message' => "Tarama Başarılı! Toplam {$count} anahtar senkronize edildi.",
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => "Hata oluştu: " . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function update(Request $request)
    {
        $this->authorize('browse_admin');

        $data = $request->input('translations');

        if ($data) {
            $this->scanner->updateTranslations($data);
        }

        return redirect()->back()->with([
            'message' => "Çeviriler başarıyla güncellendi.",
            'alert-type' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        $this->authorize('browse_admin');

        $key = base64_decode($request->input('key'));
        $this->scanner->deleteKey($key);

        return redirect()->back()->with([
            'message' => "Çeviri anahtarı silindi: {$key}",
            'alert-type' => 'info'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $this->authorize('browse_admin');

        $ids = json_decode($request->input('ids'), true);

        if ($ids && is_array($ids)) {
            foreach ($ids as $encodedKey) {
                $key = base64_decode($encodedKey);
                $this->scanner->deleteKey($key);
            }

            return redirect()->back()->with([
                'message' => count($ids) . " adet çeviri anahtarı başarıyla silindi.",
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => "Silinecek öğe seçilmedi.",
            'alert-type' => 'warning'
        ]);
    }
}