<?php

namespace App\Services;

class FieldTypeHelper
{
    protected static array $imageFields = [
        'image',
        'image_url',
        'bg_image',
        'bg_image_url',
        'mascot_image',
        'mascot_image_url',
        'banner',
        'banner_url',
        'icon',
        'logo',
        'thumbnail',
        'avatar',
        'photo',
        'cover',
        'cover_image',
        'featured_image',
    ];

    protected static array $imageGalleryFields = [
        'image_gallery',
        'gallery',
        'images',
        'photos',
    ];

    protected static array $videoFields = [
        'video',
        'video_url',
        'bg_video',
        'bg_video_url',
    ];

    protected static array $videoGalleryFields = [
        'video_gallery',
        'videos',
    ];

    protected static array $embedFields = [
        'embed_code',
        'embed',
        'iframe',
    ];

    protected static array $fileFields = [
        'file',
        'document',
        'pdf',
        'attachment',
    ];

    protected static array $urlFields = [
        'url',
        'link',
        'action_link',
        'website',
        'external_url',
        'file_url',
    ];

    protected static array $richTextFields = [
        'content',
        'body',
        'description',
        'seo_text',
        'excerpt',
        'comment',
        'message',
    ];

    protected static array $textFields = [
        'title',
        'name',
        'subtitle',
        'meta_title',
        'meta_description',
        'client',
        'location',
        'action_text',
        'organization',
        'company',
        'username',
        'surname',
        'phone',
        'subject',
    ];

    protected static array $numericFields = [
        'price',
        'old_price',
        'order',
        'rating',
        'percentage',
    ];

    protected static array $booleanFields = [
        'status',
        'is_featured',
        'is_homepage',
        'menu_show',
        'footer_show',
    ];

    protected static array $systemFields = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'parent_id',
        'category_id',
        'ip_address',
        '_lft',
        '_rgt',
    ];

    protected static array $codeFields = [
        'slug',
        'sku',
        'product_code',
        'oem_no',
        'barcode',
        'blade_name',
        'menu_data_source',
    ];

    protected static array $dateFields = [
        'completion_date',
        'published_at',
        'start_date',
        'end_date',
        'received_at',
    ];

    public static function getFieldType(string $fieldName): string
    {
        $fieldName = strtolower($fieldName);

        if (in_array($fieldName, self::$imageFields) || self::matchesPattern($fieldName, ['_image', '_logo', '_avatar', '_photo', '_icon', '_thumbnail'])) {
            return 'image';
        }

        if (in_array($fieldName, self::$imageGalleryFields) || self::matchesPattern($fieldName, ['_gallery', '_images', '_photos'])) {
            return 'image_gallery';
        }

        if (in_array($fieldName, self::$videoFields) || self::matchesPattern($fieldName, ['_video'])) {
            return 'video';
        }

        if (in_array($fieldName, self::$videoGalleryFields) || self::matchesPattern($fieldName, ['_videos'])) {
            return 'video_gallery';
        }

        if (in_array($fieldName, self::$embedFields)) {
            return 'embed';
        }

        if (in_array($fieldName, self::$fileFields) || self::matchesPattern($fieldName, ['_file', '_document', '_attachment'])) {
            return 'file';
        }

        if (in_array($fieldName, self::$urlFields) || self::matchesPattern($fieldName, ['_url', '_link'])) {
            return 'url';
        }

        if (in_array($fieldName, self::$richTextFields)) {
            return 'rich_text';
        }

        if (in_array($fieldName, self::$textFields)) {
            return 'text';
        }

        if (in_array($fieldName, self::$numericFields) || self::matchesPattern($fieldName, ['_count', '_price', '_amount'])) {
            return 'numeric';
        }

        if (in_array($fieldName, self::$booleanFields) || self::matchesPattern($fieldName, ['is_', 'has_', '_show', '_enabled', '_active'])) {
            return 'boolean';
        }

        if (in_array($fieldName, self::$systemFields)) {
            return 'system';
        }

        if (in_array($fieldName, self::$codeFields) || self::matchesPattern($fieldName, ['_code', '_no', '_id', '_key'])) {
            return 'code';
        }

        if (in_array($fieldName, self::$dateFields) || self::matchesPattern($fieldName, ['_date', '_at'])) {
            return 'date';
        }

        return 'text';
    }

    protected static function matchesPattern(string $fieldName, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (str_starts_with($pattern, '_')) {
                if (str_ends_with($fieldName, $pattern)) {
                    return true;
                }
            } else {
                if (str_starts_with($fieldName, $pattern)) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function isVisualField(string $fieldName): bool
    {
        $type = self::getFieldType($fieldName);
        return in_array($type, ['image', 'image_gallery', 'video', 'video_gallery']);
    }

    public static function isFileField(string $fieldName): bool
    {
        return self::getFieldType($fieldName) === 'file';
    }

    public static function isMediaField(string $fieldName): bool
    {
        $type = self::getFieldType($fieldName);
        return in_array($type, ['image', 'image_gallery', 'video', 'video_gallery', 'file']);
    }

    public static function isSystemField(string $fieldName): bool
    {
        return self::getFieldType($fieldName) === 'system';
    }

    public static function resolveMediaUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if ($path === '[]' || $path === '{}' || $path === 'null') {
            return null;
        }

        if (str_starts_with($path, '[') || str_starts_with($path, '{')) {
            $decoded = json_decode($path, true);

            if (!is_array($decoded) || empty($decoded)) {
                return null;
            }

            $first = $decoded[0] ?? $decoded;
            $path = is_array($first) ? ($first['download_link'] ?? $first['path'] ?? '') : $first;

            if (empty($path)) {
                return null;
            }
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return \TCG\Voyager\Facades\Voyager::image($path);
    }

    public static function isEmptyValue($value): bool
    {
        if ($value === null || $value === '' || $value === 'null') {
            return true;
        }

        if ($value === '[]' || $value === '{}') {
            return true;
        }

        if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
            $decoded = json_decode($value, true);
            return empty($decoded);
        }

        return false;
    }

    public static function parseGallery(?string $json): array
    {
        if (empty($json) || $json === '[]' || $json === '{}') {
            return [];
        }

        $decoded = json_decode($json, true);

        if (!is_array($decoded) || empty($decoded)) {
            return [];
        }

        $urls = [];
        foreach ($decoded as $item) {
            if (is_string($item) && !empty($item)) {
                $url = self::resolveMediaUrl($item);
                if ($url) {
                    $urls[] = $url;
                }
            } elseif (is_array($item)) {
                $path = $item['download_link'] ?? $item['path'] ?? $item['url'] ?? null;
                if ($path) {
                    $url = self::resolveMediaUrl($path);
                    if ($url) {
                        $urls[] = $url;
                    }
                }
            }
        }

        return $urls;
    }

    public static function parseMediaForZip($value): array
    {
        if (self::isEmptyValue($value)) {
            return [];
        }

        $results = [];

        if (is_array($value)) {
            if (array_keys($value) !== range(0, count($value) - 1)) {
                $value = [$value];
            }

            foreach ($value as $item) {
                if (is_string($item)) {
                    $url = self::resolveMediaUrl($item);
                    if ($url) {
                        $results[] = [
                            'url' => $url,
                            'filename' => basename($item)
                        ];
                    }
                } elseif (is_array($item)) {
                    $path = $item['download_link'] ?? $item['path'] ?? $item['url'] ?? null;
                    if ($path) {
                        $url = self::resolveMediaUrl($path);
                        $originalName = $item['original_name'] ?? basename($path);

                        if ($url) {
                            $results[] = [
                                'url' => $url,
                                'filename' => $originalName
                            ];
                        }
                    }
                }
            }
            return $results;
        }

        if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
            $decoded = json_decode($value, true);

            if (is_array($decoded)) {
                return self::parseMediaForZip($decoded);
            }
        }

        if (is_string($value)) {
            $url = self::resolveMediaUrl($value);
            if ($url) {
                $results[] = [
                    'url' => $url,
                    'filename' => basename($value)
                ];
            }
        }

        return $results;
    }
}
