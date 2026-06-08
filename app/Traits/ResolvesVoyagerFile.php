<?php

namespace App\Traits;

use TCG\Voyager\Facades\Voyager;

trait ResolvesVoyagerFile
{
    protected function resolveFileUrl($fileData)
    {
        if (empty($fileData) || $fileData === '[]' || $fileData === '[""]') {
            return null;
        }

        $decoded = json_decode($fileData, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $path = $decoded[0]['download_link'] ?? $decoded[0] ?? null;

            if (is_string($path) && !empty($path)) {
                return Voyager::image($path);
            }
        }

        return Voyager::image($fileData);
    }

    protected function resolveGalleryUrls($galleryJSON, ?int $index = null)
    {
        if (empty($galleryJSON)) {
            return $index !== null ? null : collect([]);
        }

        $items = json_decode($galleryJSON);
        if (!is_array($items)) {
            return $index !== null ? null : collect([]);
        }

        $collection = collect($items)->map(function ($item) {
            if (is_object($item) && isset($item->download_link)) {
                return Voyager::image($item->download_link);
            }
            return Voyager::image($item);
        });

        if ($index !== null) {
            return $collection->get($index);
        }

        return $collection;
    }
}
