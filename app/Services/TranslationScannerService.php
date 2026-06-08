<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class TranslationScannerService
{
    protected $scanPaths = [
        'app',
        'resources/views',
    ];

    protected $ignoredFolders = [
        'vendor',
        'pagination',
        'node_modules',
        'storage',
        'tests',
        'nova',
        'voyager',
        'admin',
    ];

    protected $ignoredKeys = [
        '...',
        'pagination.previous',
        'pagination.next',
        '&laquo; Previous',
        'Next &raquo;',
    ];

    protected $locales;

    public function __construct()
    {
        $this->locales = config('voyager.multilingual.locales');
    }

    public function scanAndSync()
    {
        $keys = $this->findTranslationKeys();

        foreach ($this->locales as $locale) {
            $this->syncLocaleFile($locale, $keys);
        }

        return count($keys);
    }

    protected function findTranslationKeys()
    {
        $keys = [];
        $pattern = '/(?:@lang|__)\(\s*[\'"](.+?)[\'"]\s*\)/';

        foreach ($this->scanPaths as $path) {
            $files = File::allFiles(base_path($path));

            foreach ($files as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $filePath = $file->getPathname();

                foreach ($this->ignoredFolders as $ignore) {
                    if (str_contains($filePath, $ignore)) {
                        continue 2;
                    }
                }

                $content = File::get($file);

                if (preg_match_all($pattern, $content, $matches)) {
                    foreach ($matches[1] as $key) {
                        if (!empty($key)) {
                            $key = str_replace(["\'", '\"'], ["'", '"'], $key);
                            $key = trim($key);

                            if (
                                str_starts_with($key, 'ui.') ||
                                str_starts_with($key, 'routes.') ||
                                str_starts_with($key, 'validation.') ||
                                str_starts_with($key, 'auth.') ||
                                str_starts_with($key, 'passwords.') ||
                                str_starts_with($key, 'pagination.') ||
                                str_starts_with($key, 'voyager.')
                            ) {
                                continue;
                            }

                            if (in_array($key, $this->ignoredKeys)) {
                                continue;
                            }

                            $keys[$key] = $key;
                        }
                    }
                }
            }
        }

        return $keys;
    }

    protected function syncLocaleFile($locale, $newKeys)
    {
        $path = lang_path("{$locale}.json");

        if (!File::isDirectory(lang_path())) {
            File::makeDirectory(lang_path());
        }

        $currentTranslations = [];
        if (File::exists($path)) {
            $currentTranslations = json_decode(File::get($path), true) ?? [];
        }

        foreach ($newKeys as $key) {
            if (!array_key_exists($key, $currentTranslations)) {
                if ($locale === config('voyager.multilingual.default', 'tr')) {
                    $currentTranslations[$key] = $key;
                } else {
                    $currentTranslations[$key] = "";
                }
            }
        }

        ksort($currentTranslations);
        File::put($path, json_encode($currentTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    public function getAllTranslations()
    {
        $allKeys = [];
        $mergedData = [];

        foreach ($this->locales as $locale) {
            $path = lang_path("{$locale}.json");
            if (File::exists($path)) {
                $json = json_decode(File::get($path), true) ?? [];
                $allKeys = array_merge($allKeys, array_keys($json));
            }
        }
        $allKeys = array_unique($allKeys);
        sort($allKeys);

        foreach ($allKeys as $key) {
            $mergedData[$key] = [];
            foreach ($this->locales as $locale) {
                $path = lang_path("{$locale}.json");
                $json = File::exists($path) ? (json_decode(File::get($path), true) ?? []) : [];
                $mergedData[$key][$locale] = $json[$key] ?? '';
            }
        }

        return $mergedData;
    }

    public function updateTranslations(array $translations)
    {
        foreach ($this->locales as $locale) {
            $path = lang_path("{$locale}.json");

            $currentContent = [];
            if (File::exists($path)) {
                $currentContent = json_decode(File::get($path), true) ?? [];
            }

            foreach ($translations as $encodedKey => $localesData) {
                if (empty($encodedKey))
                    continue;

                $originalKey = base64_decode($encodedKey);

                if (isset($localesData[$locale])) {
                    $currentContent[$originalKey] = $localesData[$locale];
                }
            }

            ksort($currentContent);
            File::put($path, json_encode($currentContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
    public function deleteKey($key)
    {
        foreach ($this->locales as $locale) {
            $path = lang_path("{$locale}.json");
            if (File::exists($path)) {
                $json = json_decode(File::get($path), true) ?? [];

                if (isset($json[$key])) {
                    unset($json[$key]);
                    File::put($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                }
            }
        }
    }
}
