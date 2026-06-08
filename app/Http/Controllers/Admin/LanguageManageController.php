<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class LanguageManageController extends Controller
{
    protected array $languageFiles = [
        'auth.php',
        'pagination.php',
        'passwords.php',
        'routes.php',
        'ui.php',
        'validation.php',
        'admin.php'
    ];

    protected function createLanguageFiles(string $locale): void
    {
        $langPath = lang_path($locale);

        if (!is_dir($langPath)) {
            mkdir($langPath, 0755, true);
        }

        $templatePath = lang_path('en');

        foreach ($this->languageFiles as $file) {
            $targetFile = $langPath . DIRECTORY_SEPARATOR . $file;
            $sourceFile = $templatePath . DIRECTORY_SEPARATOR . $file;

            if (!file_exists($targetFile) && file_exists($sourceFile)) {
                copy($sourceFile, $targetFile);
            }
        }

        $jsonFile = lang_path($locale . '.json');
        if (!file_exists($jsonFile)) {
            $enJson = lang_path('en.json');
            if (file_exists($enJson)) {
                copy($enJson, $jsonFile);
            } else {
                file_put_contents($jsonFile, '{}');
            }
        }
    }

    public function listFiles()
    {
        $config = config('voyager.multilingual');
        $locales = $config['locales'] ?? [];

        if (!empty($locales) && is_array($locales[0] ?? null)) {
            $locales = $locales[0];
        }

        $languages = [];

        foreach ($locales as $locale) {
            $langPath = lang_path($locale);
            $files = [];

            foreach ($this->languageFiles as $file) {
                $filePath = $langPath . DIRECTORY_SEPARATOR . $file;
                $files[] = [
                    'name' => $file,
                    'exists' => file_exists($filePath),
                    'size' => file_exists($filePath) ? filesize($filePath) : 0,
                ];
            }

            $jsonPath = lang_path($locale . '.json');
            $files[] = [
                'name' => $locale . '.json',
                'exists' => file_exists($jsonPath),
                'size' => file_exists($jsonPath) ? filesize($jsonPath) : 0,
                'isJson' => true,
            ];

            $languages[$locale] = $files;
        }

        return view('admin.language-files', [
            'languages' => $languages,
            'default' => $config['default']
        ]);
    }

    public function editFile(string $locale, string $file)
    {
        if (!preg_match('/^[a-z]{2}$/', $locale)) {
            return back()->with(['message' => 'Geçersiz dil kodu!', 'alert-type' => 'error']);
        }

        $isJson = str_ends_with($file, '.json');

        if ($isJson) {
            $filePath = lang_path($file);
        } else {
            if (!in_array($file, $this->languageFiles)) {
                return back()->with(['message' => 'Geçersiz dosya!', 'alert-type' => 'error']);
            }
            $filePath = lang_path($locale . DIRECTORY_SEPARATOR . $file);
        }

        if (!file_exists($filePath)) {
            return back()->with(['message' => 'Dosya bulunamadı!', 'alert-type' => 'error']);
        }

        if ($isJson) {
            $content = json_decode(file_get_contents($filePath), true) ?? [];
        } else {
            $content = include $filePath;
            if (!is_array($content)) {
                $content = [];
            }
        }

        $flatContent = $this->flattenArray($content);

        return view('admin.language-file-edit', [
            'locale' => $locale,
            'file' => $file,
            'content' => $flatContent,
            'isJson' => $isJson,
        ]);
    }

    public function updateFile(Request $request, string $locale, string $file)
    {
        if (!preg_match('/^[a-z]{2}$/', $locale)) {
            return back()->with(['message' => 'Geçersiz dil kodu!', 'alert-type' => 'error']);
        }

        $isJson = str_ends_with($file, '.json');

        if ($isJson) {
            $filePath = lang_path($file);
        } else {
            if (!in_array($file, $this->languageFiles)) {
                return back()->with(['message' => 'Geçersiz dosya!', 'alert-type' => 'error']);
            }
            $filePath = lang_path($locale . DIRECTORY_SEPARATOR . $file);
        }

        $keys = $request->input('keys', []);
        $values = $request->input('values', []);

        $translations = [];
        foreach ($keys as $index => $key) {
            if (!empty($key)) {
                $translations[$key] = $values[$index] ?? '';
            }
        }

        $nestedTranslations = $this->unflattenArray($translations);

        try {
            if ($isJson) {
                $jsonContent = json_encode($nestedTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                file_put_contents($filePath, $jsonContent);
            } else {
                $phpContent = "<?php\n\nreturn " . $this->arrayToPhpString($nestedTranslations) . ";\n";
                file_put_contents($filePath, $phpContent);
            }

            return back()->with([
                'message' => 'Dosya başarıyla kaydedildi!',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Dosya yazma hatası: ' . $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    protected function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value) && !empty($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    protected function unflattenArray(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $keys = explode('.', $key);
            $current = &$result;

            foreach ($keys as $i => $k) {
                if ($i === count($keys) - 1) {
                    $current[$k] = $value;
                } else {
                    if (!isset($current[$k]) || !is_array($current[$k])) {
                        $current[$k] = [];
                    }
                    $current = &$current[$k];
                }
            }
        }

        return $result;
    }

    protected function arrayToPhpString(array $array, int $indent = 1): string
    {
        $spaces = str_repeat('    ', $indent);
        $result = "[\n";

        foreach ($array as $key => $value) {
            $escapedKey = is_numeric($key) ? $key : "'" . addslashes($key) . "'";

            if (is_array($value)) {
                $result .= $spaces . $escapedKey . " => " . $this->arrayToPhpString($value, $indent + 1) . ",\n";
            } else {
                $escapedValue = "'" . addslashes($value ?? '') . "'";
                $result .= $spaces . $escapedKey . " => " . $escapedValue . ",\n";
            }
        }

        $result .= str_repeat('    ', $indent - 1) . "]";

        return $result;
    }
}
