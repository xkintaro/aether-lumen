<?php

namespace App\Listeners;

use TCG\Voyager\Events\BreadDataUpdated;

class ReorderBreadMedia
{
    public function handle(BreadDataUpdated $event)
    {
        $request = request();
        $dataType = $event->dataType;
        $data = $event->data;
        $needsSave = false;

        $rows = $dataType->editRows;

        foreach ($rows as $row) {
            if (!in_array($row->type, ['multiple_images', 'file'])) {
                continue;
            }

            $sortKey = $row->field . '_sort_order';

            if (!$request->has($sortKey)) {
                continue;
            }

            $sortOrder = json_decode($request->input($sortKey), true);

            if (!is_array($sortOrder) || empty($sortOrder)) {
                continue;
            }

            $currentValue = $data->{$row->field};
            $currentItems = json_decode($currentValue, true);

            if (!is_array($currentItems) || empty($currentItems)) {
                continue;
            }

            if ($row->type === 'multiple_images') {
                $existingInSort = array_filter($sortOrder, fn($item) => $item !== '__new__');
                $newFiles = array_values(array_diff($currentItems, $existingInSort));
                $newIndex = 0;

                $ordered = [];
                foreach ($sortOrder as $item) {
                    if ($item === '__new__') {
                        if (isset($newFiles[$newIndex])) {
                            $ordered[] = $newFiles[$newIndex];
                            $newIndex++;
                        }
                    } elseif (in_array($item, $currentItems)) {
                        $ordered[] = $item;
                    }
                }

                while ($newIndex < count($newFiles)) {
                    $ordered[] = $newFiles[$newIndex];
                    $newIndex++;
                }

                foreach ($currentItems as $item) {
                    if (!in_array($item, $ordered)) {
                        $ordered[] = $item;
                    }
                }

                $data->{$row->field} = json_encode($ordered);
                $needsSave = true;

            } elseif ($row->type === 'file') {
                $indexed = [];
                foreach ($currentItems as $fileObj) {
                    $key = is_array($fileObj)
                        ? ($fileObj['original_name'] ?? $fileObj['download_link'] ?? '')
                        : $fileObj;
                    $indexed[$key] = $fileObj;
                }

                $newFiles = [];
                $existingKeys = [];
                foreach ($sortOrder as $item) {
                    if ($item !== '__new__') {
                        $existingKeys[] = $item;
                    }
                }
                foreach ($indexed as $key => $fileObj) {
                    if (!in_array($key, $existingKeys)) {
                        $newFiles[] = $fileObj;
                    }
                }
                $newIndex = 0;

                $ordered = [];
                foreach ($sortOrder as $name) {
                    if ($name === '__new__') {
                        if (isset($newFiles[$newIndex])) {
                            $ordered[] = $newFiles[$newIndex];
                            $newIndex++;
                        }
                    } elseif (isset($indexed[$name])) {
                        $ordered[] = $indexed[$name];
                        unset($indexed[$name]);
                    }
                }

                while ($newIndex < count($newFiles)) {
                    $ordered[] = $newFiles[$newIndex];
                    $newIndex++;
                }

                foreach ($indexed as $fileObj) {
                    if (!in_array($fileObj, $ordered, true)) {
                        $ordered[] = $fileObj;
                    }
                }

                $data->{$row->field} = json_encode($ordered);
                $needsSave = true;
            }
        }

        if ($needsSave) {
            $data->save();
        }
    }
}
