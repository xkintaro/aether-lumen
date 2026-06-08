<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\FieldTypeHelper;

class ExportController extends Controller
{
    private array $usedFilenames = [];
    private $storageDisk;
    private string $storageBasePath = '';

    public function export(Request $request, $slug, $format = 'csv')
    {
        $dataType = Voyager::model('DataType')->where('slug', $slug)->firstOrFail();
        $this->authorize('browse', app($dataType->model_name));

        $model = app($dataType->model_name);
        $context = $this->prepareExportContext($model);
        $selectedIds = $this->parseSelectedIds($request);

        $data = $this->prepareData($model, $context, $selectedIds);
        $headers = $this->prepareHeaders($context);

        if (empty($data)) {
            return redirect()->back()->with([
                'message' => 'Export edilecek veri bulunamadı.',
                'alert-type' => 'error',
            ]);
        }

        $token = $request->input('download_token');
        $isSelected = !empty($selectedIds);

        if ($request->input('include_media')) {
            return $this->exportZip($dataType, $data, $headers, $format, $isSelected, $token);
        }

        return match (strtolower($format)) {
            'json' => $this->exportJson($dataType, $data, $headers, $isSelected, $token),
            default => $this->exportCsv($dataType, $data, $headers, $isSelected, $token),
        };
    }

    private function prepareExportContext($model): array
    {
        $dbColumns = Schema::getColumnListing($model->getTable());
        $defaultLocale = config('voyager.multilingual.default');
        $locales = config('voyager.multilingual.locales', [$defaultLocale]);
        $translatableFields = $this->getTranslatableFields($model);

        return compact('dbColumns', 'locales', 'translatableFields');
    }

    private function getTranslatableFields($model): array
    {
        if (!in_array('TCG\Voyager\Traits\Translatable', class_uses_recursive($model))) {
            return [];
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

    private function parseSelectedIds(Request $request): array
    {
        $param = $request->input('selected_ids') ?? $request->input('ids');

        if (empty($param)) {
            return [];
        }

        $ids = is_string($param) ? explode(',', $param) : (array) $param;
        return array_map('intval', array_filter($ids, 'is_numeric'));
    }

    private function prepareHeaders(array $context): array
    {
        $headers = [];
        $defaultLocale = config('voyager.multilingual.default');

        foreach ($context['dbColumns'] as $col) {
            if (in_array($col, $context['translatableFields'])) {
                foreach ($context['locales'] as $lang) {
                    $headers[] = $lang === $defaultLocale ? $col : "{$col} ({$lang})";
                }
            } else {
                $headers[] = $col;
            }
        }

        return $headers;
    }

    private function prepareData($model, array $context, array $selectedIds = []): array
    {
        $query = $model->query();

        if (!empty($selectedIds)) {
            $query->whereIn($model->getKeyName(), $selectedIds);
        }

        $result = [];
        foreach ($query->cursor() as $item) {
            $result[] = $this->extractRowData($item, $context);
        }

        return $result;
    }

    private function extractRowData($item, array $context): array
    {
        $row = [];

        foreach ($context['dbColumns'] as $col) {
            if (in_array($col, $context['translatableFields'])) {
                foreach ($context['locales'] as $lang) {
                    $val = method_exists($item, 'translate')
                        ? ($item->translate($lang, false)->{$col} ?? '')
                        : '';
                    $row[] = $val;
                }
            } else {
                $row[] = $this->normalizeValue($item->{$col});
            }
        }

        return $row;
    }

    private function normalizeValue($val)
    {
        if (is_string($val) && (str_starts_with($val, '[') || str_starts_with($val, '{'))) {
            $decoded = json_decode($val, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }
        return $val;
    }

    private function exportZip($dataType, array $data, array $headers, $format, bool $isSelected, $token = null)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $suffix = $isSelected ? '_Selected_' . count($data) : '';
        $zipFilename = $dataType->display_name_plural . $suffix . '_Export_' . date('Y-m-d_H-i') . '.zip';

        $zipPath = tempnam(sys_get_temp_dir(), 'voyager_export_');
        $zip = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new \Exception("ZIP dosyası oluşturulamadı.");
        }

        $zip->addEmptyDir('files');
        $this->usedFilenames = [];

        $this->storageDisk = Storage::disk(config('voyager.storage.disk'));
        $this->storageBasePath = $this->storageDisk->path('');

        $exportData = $this->processMediaForZip($data, $headers, $zip);
        $this->addDataFileToZip($zip, $exportData, $headers, $format);

        $zip->close();

        return $this->createDownloadResponse($zipPath, $zipFilename, $token);
    }


    private function processMediaForZip(array $data, array $headers, \ZipArchive $zip): array
    {
        $exportData = [];
        $idIndex = array_search('id', array_map('strtolower', $headers));

        foreach ($data as $rowIndex => $row) {
            $rowId = ($idIndex !== false) ? ($row[$idIndex] ?? $rowIndex) : $rowIndex;
            $exportData[] = $this->processRowMedia($row, $headers, $rowId, $zip);
        }

        return $exportData;
    }

    private function processRowMedia(array $row, array $headers, $rowId, \ZipArchive $zip): array
    {
        $newRow = $row;

        foreach ($headers as $colIndex => $fieldName) {
            if (!FieldTypeHelper::isMediaField($fieldName)) {
                continue;
            }

            $value = $row[$colIndex] ?? null;
            if (FieldTypeHelper::isEmptyValue($value)) {
                continue;
            }

            $newPaths = $this->addMediaFilesToZip($value, $rowId, $zip);
            if (!empty($newPaths)) {
                $isArray = is_array($value) || (is_string($value) && str_starts_with(trim($value), '['));
                $newRow[$colIndex] = $isArray ? $newPaths : ($newPaths[0] ?? '');
            }
        }

        return $newRow;
    }

    private function addMediaFilesToZip($value, $rowId, \ZipArchive $zip): array
    {
        $files = FieldTypeHelper::parseMediaForZip($value);
        $newPaths = [];

        foreach ($files as $mediaItem) {
            try {
                $zipEntryName = $this->generateUniqueFilename($mediaItem, $rowId);
                $this->addFileToZip($zip, $mediaItem['url'], $zipEntryName);
                $newPaths[] = $zipEntryName;
            } catch (\Exception $e) {
            }
        }

        return $newPaths;
    }

    private function generateUniqueFilename(array $mediaItem, $rowId): string
    {
        $originalName = $mediaItem['filename'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $baseName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $filename = "files/{$rowId}_{$baseName}.{$ext}";

        $counter = 1;
        while (isset($this->usedFilenames[$filename])) {
            $filename = "files/{$rowId}_{$baseName}-{$counter}.{$ext}";
            $counter++;
        }

        $this->usedFilenames[$filename] = true;
        return $filename;
    }

    private function addFileToZip(\ZipArchive $zip, string $fileUrl, string $zipEntryName): void
    {
        $localPath = str_replace(url('/storage') . '/', '', $fileUrl);

        $fullPath = $this->storageBasePath . $localPath;

        if (file_exists($fullPath)) {
            $zip->addFile($fullPath, $zipEntryName);
        }
    }

    private function addDataFileToZip(\ZipArchive $zip, array $data, array $headers, string $format): void
    {
        if ($format === 'json') {
            $records = array_map(fn($row) => array_combine($headers, $row), $data);
            $zip->addFromString('data.json', json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else {
            $csv = fopen('php://temp', 'r+');
            fputcsv($csv, $headers, ';');
            foreach ($data as $row) {
                fputcsv($csv, array_map([$this, 'formatCsvValue'], $row), ';');
            }
            rewind($csv);
            $zip->addFromString('data.csv', stream_get_contents($csv));
            fclose($csv);
        }
    }

    private function formatCsvValue($value): string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return (string) $value;
    }

    private function createDownloadResponse(string $filePath, string $filename, $token = null)
    {
        $response = response()->streamDownload(function () use ($filePath) {
            echo file_get_contents($filePath);
            unlink($filePath);
        }, $filename);

        if ($token) {
            $response->headers->setCookie(cookie('download_token', $token, 1, '/', null, false, false));
        }

        return $response;
    }

    private function exportCsv($dataType, array $data, array $headers, bool $isSelected, $token = null)
    {
        $suffix = $isSelected ? '_Selected_' . count($data) : '';
        $filename = $dataType->display_name_plural . $suffix . '_Export_' . date('Y-m-d_H-i') . '.csv';

        $callback = function () use ($data, $headers) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $headers, ';');

            foreach ($data as $row) {
                fputcsv($file, array_map(fn($v, $i) => $this->processExportValue($v, $headers[$i] ?? ''), $row, array_keys($row)), ';');
            }
            fclose($file);
        };

        $response = response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);

        if ($token) {
            $response->headers->setCookie(cookie('download_token', $token, 1, '/', null, false, false));
        }

        return $response;
    }

    private function exportJson($dataType, array $data, array $headers, bool $isSelected, $token = null)
    {
        $suffix = $isSelected ? '_Selected_' . count($data) : '';
        $filename = $dataType->display_name_plural . $suffix . '_Export_' . date('Y-m-d_H-i') . '.json';

        $result = [];
        foreach ($data as $row) {
            $assoc = [];
            foreach ($headers as $i => $header) {
                $assoc[$header] = $this->processExportValue($row[$i] ?? null, $header);
            }
            $result[] = $assoc;
        }

        $response = response(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);

        if ($token) {
            $response->headers->setCookie(cookie('download_token', $token, 1, '/', null, false, false));
        }

        return $response;
    }

    private function processExportValue($value, string $header)
    {
        if (FieldTypeHelper::isMediaField($header) && !FieldTypeHelper::isEmptyValue($value)) {
            $mediaItems = FieldTypeHelper::parseMediaForZip($value);
            $paths = array_column($mediaItems, 'url');

            if (!empty($paths)) {
                $isArray = is_array($value) || (is_string($value) && str_starts_with(trim($value), '['));
                return (count($paths) > 1 || $isArray) ? $paths : $paths[0];
            }
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return $value;
    }
}