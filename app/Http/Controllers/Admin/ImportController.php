<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\FieldTypeHelper;
use App\Services\RelationshipValidator;

class ImportController extends Controller
{
    private array $importedFiles = [];

    public function generateTemplate(Request $request, $slug, $format = 'csv')
    {
        $dataType = Voyager::model('DataType')->where('slug', $slug)->firstOrFail();
        $this->authorize('browse', app($dataType->model_name));

        $model = app($dataType->model_name);
        $headers = $this->buildTemplateHeaders($model);

        if ($request->get('include_media')) {
            return $this->generateZipTemplate($dataType, $headers, $format);
        }

        return $this->generateSimpleTemplate($dataType, $headers, $format);
    }

    private function buildTemplateHeaders($model): array
    {
        $columns = Schema::getColumnListing($model->getTable());
        $translatableFields = $this->getTranslatableFields($model);

        $defaultLocale = config('voyager.multilingual.default');
        $locales = config('voyager.multilingual.locales', [$defaultLocale]);

        $headers = [];
        foreach ($columns as $col) {
            $headers[] = $col;
            if (in_array($col, $translatableFields)) {
                foreach ($locales as $lang) {
                    if ($lang !== $defaultLocale) {
                        $headers[] = "{$col} ({$lang})";
                    }
                }
            }
        }

        return $headers;
    }

    private function getTranslatableFields($model): array
    {
        if (!in_array('TCG\Voyager\Traits\Translatable', class_uses_recursive($model))) {
            return [];
        }

        if (method_exists($model, 'getTranslatableAttributes')) {
            $fields = $model->getTranslatableAttributes();
            if (!empty($fields)) {
                return $fields;
            }
        }

        try {
            $reflection = new \ReflectionClass($model);
            if ($reflection->hasProperty('translatable')) {
                $property = $reflection->getProperty('translatable');
                $property->setAccessible(true);
                return $property->getValue($model);
            }
        } catch (\Exception $e) {
        }

        return [];
    }

    private function generateZipTemplate($dataType, array $headers, string $format)
    {
        $zipPath = storage_path('app/temp/template_' . Str::random(10) . '.zip');

        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
            return response()->json(['message' => 'ZIP oluşturulamadı.'], 500);
        }

        $this->addDataFileToZip($zip, $headers, $format);
        $zip->addEmptyDir('files');
        $zip->close();

        return response()->download($zipPath, $dataType->display_name_plural . '_Import_Template.zip')
            ->deleteFileAfterSend(true);
    }

    private function addDataFileToZip(\ZipArchive $zip, array $headers, string $format): void
    {
        $sample = array_fill_keys($headers, '');

        if ($format === 'json') {
            $zip->addFromString('data.json', json_encode([$sample], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else {
            $fp = fopen('php://memory', 'r+');
            fputs($fp, "\xEF\xBB\xBF");
            fputcsv($fp, $headers, ';');
            rewind($fp);
            $zip->addFromString('data.csv', stream_get_contents($fp));
            fclose($fp);
        }
    }

    private function generateSimpleTemplate($dataType, array $headers, string $format)
    {
        $filename = $dataType->display_name_plural . '_Import_Template.' . $format;

        if ($format === 'json') {
            $sample = array_fill_keys($headers, '');
            return response()->streamDownload(function () use ($sample) {
                echo json_encode([$sample], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }, $filename);
        }

        return response()->streamDownload(function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $headers, ';');
            fclose($file);
        }, $filename);
    }

    public function process(Request $request, $slug)
    {
        $this->importedFiles = [];

        try {
            Log::info("Import başlatıldı: {$slug}");

            $dataType = Voyager::model('DataType')->where('slug', $slug)->firstOrFail();
            $this->authorize('add', app($dataType->model_name));

            if (!$request->hasFile('file')) {
                return response()->json(['message' => 'Dosya yüklenmedi.'], 400);
            }

            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension());

            Log::info("Dosya yüklendi: {$file->getClientOriginalName()} ({$ext})");

            DB::beginTransaction();

            $data = match ($ext) {
                'zip' => $this->processZipFile($file),
                'json' => $this->parseJsonFile($file->getRealPath()),
                'csv', 'txt' => $this->parseCsvFile($file->getRealPath()),
                default => throw new \Exception("Desteklenmeyen format: {$ext}"),
            };

            $this->importData($data['rows'], $dataType, $data['mediaPath']);

            DB::commit();

            if (!empty($data['mediaPath'])) {
                File::deleteDirectory($data['mediaPath']);
            }

            return response()->json(['message' => 'İçe aktarma başarıyla tamamlandı.']);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->rollbackImportedFiles();

            Log::error("Import hatası ({$slug}): {$e->getMessage()}");
            return response()->json(['message' => 'Hata: ' . $e->getMessage()], 200);
        }
    }

    private function rollbackImportedFiles(): void
    {
        foreach ($this->importedFiles as $path) {
            Storage::disk(config('voyager.storage.disk'))->delete($path);
        }
    }

    private function processZipFile($file): array
    {
        $zip = new \ZipArchive();
        if ($zip->open($file->getRealPath()) !== true) {
            throw new \Exception("ZIP dosyası açılamadı.");
        }

        $extractPath = storage_path('app/temp/import_' . uniqid());
        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0755, true);
        }

        $zip->extractTo($extractPath);
        $zip->close();

        $jsonFiles = glob($extractPath . '/*.json');
        $csvFiles = glob($extractPath . '/*.csv');

        if (!empty($jsonFiles)) {
            $rows = $this->parseJsonFile($jsonFiles[0]);
        } elseif (!empty($csvFiles)) {
            $rows = $this->parseCsvFile($csvFiles[0]);
        } else {
            throw new \Exception("ZIP içinde .json veya .csv veri dosyası bulunamadı.");
        }

        return ['rows' => $rows, 'mediaPath' => $extractPath];
    }

    private function parseJsonFile(string $path): array
    {
        $content = file_get_contents($path);
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("JSON Hatası: " . json_last_error_msg());
        }

        if (!is_array($data)) {
            throw new \Exception("JSON verisi geçerli bir dizi değil.");
        }

        return $data;
    }

    private function parseCsvFile(string $path): array
    {
        $data = [];
        $handle = fopen($path, 'r');
        if ($handle === false) {
            throw new \Exception("CSV dosyası okunamadı.");
        }

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $headers = fgetcsv($handle, 1000, ';') ?: fgetcsv($handle, 1000, ',');
        if (!$headers) {
            fclose($handle);
            throw new \Exception("CSV başlıkları okunamadı.");
        }

        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            if (count($headers) === count($row)) {
                $data[] = array_combine($headers, $row);
            }
        }

        fclose($handle);
        return $data;
    }

    private function importData(array $rows, $dataType, ?string $mediaBasePath): void
    {
        $modelClass = app($dataType->model_name);
        $table = $modelClass->getTable();
        $validColumns = Schema::getColumnListing($table);
        $translatableFields = $this->getTranslatableFields($modelClass);
        $defaultLocale = config('voyager.multilingual.default');
        $dataRows = $dataType->rows->keyBy('field');

        $relationValidator = new RelationshipValidator();

        foreach ($rows as $index => $row) {
            try {
                [$attributes, $translations] = $this->parseRowData($row, $validColumns, $defaultLocale);
                $attributes = $this->processMediaAttributes($attributes, $row, $validColumns, $mediaBasePath, $dataRows);

                $attributes = $this->validateRelationalFields($attributes, $table, $relationValidator);

                $record = new $modelClass();
                $record->forceFill($attributes);
                $record->save();

                $this->saveTranslations($record, $translations, $translatableFields, $table);

            } catch (\Exception $e) {
                throw new \Exception("Satır " . ($index + 1) . " kayıt hatası: " . $e->getMessage());
            }
        }
    }

    private function validateRelationalFields(array $attributes, string $table, RelationshipValidator $validator): array
    {
        foreach ($attributes as $field => $value) {
            if ($validator->isRelationalField($field)) {
                $attributes[$field] = $validator->sanitizeValue($field, $value, $table);
            }
        }

        return $attributes;
    }

    private function parseRowData(array $row, array $validColumns, string $defaultLocale): array
    {
        $attributes = [];
        $translations = [];

        foreach ($row as $key => $value) {
            if (preg_match('/^(.*)\s\(([a-z]{2})\)$/', $key, $matches)) {
                $field = $matches[1];
                $lang = $matches[2];

                if ($lang === $defaultLocale) {
                    $attributes[$field] = $value;
                } elseif (!empty($value)) {
                    $translations[$field][$lang] = $value;
                }
            } else {
                $attributes[$key] = $value;
            }
        }

        $filtered = [];

        foreach ($attributes as $key => $val) {
            if (!in_array($key, $validColumns) || $key === 'id') {
                continue;
            }

            if (in_array($key, ['created_at', 'updated_at']) && ($val === '' || $val === null)) {
                continue;
            }

            if ($val === '' || $val === null) {
                $filtered[$key] = null;
            } elseif ((str_ends_with($key, '_at') || $key === 'date') && is_string($val) && strtotime($val) === false) {
                $filtered[$key] = null;
            } elseif (is_array($val)) {
                $filtered[$key] = json_encode($val, JSON_UNESCAPED_UNICODE);
            } else {
                $filtered[$key] = $val;
            }
        }

        return [$filtered, $translations];
    }

    private function processMediaAttributes(array $attributes, array $row, array $validColumns, ?string $mediaBasePath, $dataRows): array
    {
        if (!$mediaBasePath) {
            return $attributes;
        }

        foreach ($row as $key => $val) {
            if (!in_array($key, $validColumns) || empty($val)) {
                continue;
            }

            $val = $this->normalizeMediaValue($val, $mediaBasePath);
            $fieldRow = $dataRows[$key] ?? null;
            $isFileType = $fieldRow && $fieldRow->type === 'file';

            if (is_string($val)) {
                $processed = $this->processSingleMediaFile($val, $mediaBasePath, $isFileType);
                if ($processed !== null) {
                    $attributes[$key] = $processed;
                }
            } elseif (is_array($val)) {
                $processed = $this->processMultipleMediaFiles($val, $mediaBasePath, $isFileType);
                if (!empty($processed)) {
                    $attributes[$key] = json_encode($processed);
                }
            }
        }

        return $attributes;
    }

    private function normalizeMediaValue($val, string $mediaBasePath)
    {
        if (is_string($val) && str_starts_with(trim($val), '[') && !file_exists($mediaBasePath . '/' . $val)) {
            $decoded = json_decode($val, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }
        return $val;
    }

    private function processSingleMediaFile(string $val, string $mediaBasePath, bool $isFileType): ?string
    {
        $possiblePath = $mediaBasePath . '/' . $val;
        if (!file_exists($possiblePath) || is_dir($possiblePath)) {
            return null;
        }

        $newPath = 'imported/' . date('Ym') . '/' . Str::random(10) . '_' . basename($val);
        Storage::disk(config('voyager.storage.disk'))->put($newPath, file_get_contents($possiblePath));
        $this->importedFiles[] = $newPath;

        if ($isFileType) {
            return json_encode([['download_link' => $newPath, 'original_name' => basename($val)]]);
        }

        return $newPath;
    }

    private function processMultipleMediaFiles(array $items, string $mediaBasePath, bool $isFileType): array
    {
        $processed = [];

        foreach ($items as $item) {
            if (!is_string($item) || empty($item)) {
                continue;
            }

            $possiblePath = $mediaBasePath . '/' . $item;
            if (!file_exists($possiblePath) || is_dir($possiblePath)) {
                continue;
            }

            $newPath = 'imported/' . date('Ym') . '/' . Str::random(10) . '_' . basename($item);
            Storage::disk(config('voyager.storage.disk'))->put($newPath, file_get_contents($possiblePath));
            $this->importedFiles[] = $newPath;

            $processed[] = $isFileType
                ? ['download_link' => $newPath, 'original_name' => basename($item)]
                : $newPath;
        }

        return $processed;
    }

    private function saveTranslations($record, array $translations, array $translatableFields, string $table): void
    {
        if (empty($translations)) {
            return;
        }

        foreach ($translations as $field => $langs) {
            if (!in_array($field, $translatableFields)) {
                continue;
            }

            foreach ($langs as $lang => $value) {
                if (method_exists($record, 'translateOrNew')) {
                    $record->translateOrNew($lang)->$field = $value;
                    $record->save();
                } else {
                    $this->saveTranslationManually($table, $field, $record->id, $lang, $value);
                }
            }
        }
    }

    private function saveTranslationManually(string $table, string $field, int $foreignKey, string $lang, string $value): void
    {
        $existing = DB::table('translations')
            ->where('table_name', $table)
            ->where('column_name', $field)
            ->where('foreign_key', $foreignKey)
            ->where('locale', $lang)
            ->first();

        if ($existing) {
            DB::table('translations')->where('id', $existing->id)->update(['value' => $value]);
        } else {
            DB::table('translations')->insert([
                'table_name' => $table,
                'column_name' => $field,
                'foreign_key' => $foreignKey,
                'locale' => $lang,
                'value' => $value,
            ]);
        }
    }
}
