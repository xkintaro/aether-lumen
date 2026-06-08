<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProductController;
use TCG\Voyager\Facades\Voyager;

// Redirect to default locale
Route::get('/', function () {
    $defaultLocale = config('voyager.multilingual.default');
    return redirect($defaultLocale);
});

// Dynamic Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Locale Routes
Route::prefix('/{locale}')
    ->where(['locale' => '[a-z]{2}'])
    ->middleware(['web', 'set.locale'])

    ->group(function () {

        // Home Page
        Route::get('/', [SiteController::class, 'index'])->name('index');

        // Products Page Ajax Search
        $locales = config('voyager.multilingual.locales');
        $productSlugs = [];
        foreach ($locales as $lang) {
            $slug = __('routes.products', [], $lang);
            if (!empty($slug) && !in_array($slug, $productSlugs)) {
                $productSlugs[] = $slug;
                Route::get('/' . $slug, [ProductController::class, 'index'])
                    ->name('products.index.' . $lang);
            }
        }

        // Contact Form
        Route::post('/contact-form', [\App\Http\Controllers\ContactController::class, 'ContactForm'])
            ->name('contact.ContactForm');

        // Global Search
        Route::get('/api/global-search', [\App\Http\Controllers\GlobalSearchController::class, 'search'])
            ->name('global.search');

        // Resolver
        Route::get('/{slug}', [SiteController::class, 'resolve'])
            ->where('slug', '.*')
            ->name('resolver');
    });

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => 'admin.user'], function () {

    // Cache Clear
    Route::get('/clear-cache', function () {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');

        return redirect()->back()->with([
            'message' => 'Sistem önbelleği temizlendi!',
            'alert-type' => 'success',
        ]);
    })->name('admin.clear-cache');

    // Language Files
    Route::get('/language-files', [\App\Http\Controllers\Admin\LanguageManageController::class, 'listFiles'])
        ->name('admin.language-files.index');

    Route::get('/language-files/{locale}/{file}', [\App\Http\Controllers\Admin\LanguageManageController::class, 'editFile'])
        ->name('admin.language-files.edit');

    Route::post('/language-files/{locale}/{file}', [\App\Http\Controllers\Admin\LanguageManageController::class, 'updateFile'])
        ->name('admin.language-files.update');

    // Translations
    Route::get('/translations', [\App\Http\Controllers\Admin\TranslationController::class, 'index'])
        ->name('admin.translations.index');

    Route::post('/translations/scan', [\App\Http\Controllers\Admin\TranslationController::class, 'scan'])
        ->name('admin.translations.scan');

    Route::post('/translations/update', [\App\Http\Controllers\Admin\TranslationController::class, 'update'])
        ->name('admin.translations.update');

    Route::delete('/translations/delete', [\App\Http\Controllers\Admin\TranslationController::class, 'delete'])
        ->name('admin.translations.delete');

    Route::delete('/translations/bulk-delete', [\App\Http\Controllers\Admin\TranslationController::class, 'bulkDelete'])
        ->name('admin.translations.bulkDelete');

    // Export
    Route::get('/export/{slug}/{format?}', [\App\Http\Controllers\Admin\ExportController::class, 'export'])
        ->name('voyager.export');

    // Import
    Route::get('/import-template/{slug}/{format?}', [\App\Http\Controllers\Admin\ImportController::class, 'generateTemplate'])
        ->name('voyager.import_template');

    Route::get('/import-params', [\App\Http\Controllers\Admin\ImportController::class, 'params'])
        ->name('voyager.import_params');

    Route::post('/import/{slug}', [\App\Http\Controllers\Admin\ImportController::class, 'process'])
        ->name('voyager.import');

    // Icons Page
    Route::get('/icons', function () {
        return view('admin.icons');
    })->name('admin.icons');
});

// Voyager Routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
