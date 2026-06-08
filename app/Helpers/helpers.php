<?php

use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| RESOLVE VOYAGER FILE
|--------------------------------------------------------------------------
|
| Bu metod, Voyager'dan gelen karmaşık dosya verilerini (tekil veya çoğul)
| her zaman düzgün bir URL dizisine dönüştürür.
|
| src="{{ rvf('documents.intro_video') }}"
|
*/

if (!function_exists('rvf')) {
    function rvf($fileData)
    {
        if (is_string($fileData) && strpos($fileData, '.') !== false && strpos($fileData, ' ') === false) {
            $settingValue = setting($fileData);
            if ($settingValue !== null) {
                $fileData = $settingValue;
            }
        }

        if (empty($fileData) || $fileData === '[]' || $fileData === '[""]') {
            return null;
        }

        if (is_string($fileData) && (str_starts_with($fileData, 'http://') || str_starts_with($fileData, 'https://'))) {
            return $fileData;
        }

        $decoded = json_decode($fileData, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            if (isset($decoded[0]) && is_array($decoded[0]) && isset($decoded[0]['download_link'])) {
                $paths = array_column($decoded, 'download_link');
                return count($paths) === 1 ? Voyager::image($paths[0]) : array_map(function ($path) {
                    return Voyager::image($path);
                }, $paths);
            }

            if (isset($decoded[0]) && is_string($decoded[0])) {
                return count($decoded) === 1 ? Voyager::image($decoded[0]) : array_map(function ($path) {
                    return Voyager::image($path);
                }, $decoded);
            }
        }

        return Voyager::image($fileData);
    }
}

/*
|--------------------------------------------------------------------------
| RESOLVE VOYAGER FILE SINGLE
|--------------------------------------------------------------------------
|
| Bu metod, Voyager'dan gelen (tekil veya çoğul) dosya verilerinden
| her zaman tek bir URL dönmesini garanti eder.
|
| src="{{ rvfs('documents.intro_video') }}"
|
*/

if (!function_exists('rvfs')) {
    function rvfs($fileData)
    {
        $resolved = rvf($fileData);
        if (is_array($resolved)) {
            return $resolved[0] ?? null;
        }
        return $resolved;
    }
}
