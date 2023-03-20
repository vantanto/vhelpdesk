<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    public static $PageItemShows = [10, 20, 30];

    public static function fileStore($file, $filePath, $fileName = null, $disk = 'public')
    {
        if (!is_null($file)) {
            $fileName = ($fileName ?? date('YmdHis')) . '.' . $file->extension();
            $fullPath = $filePath . $fileName;
            Storage::disk($disk)->put($fullPath, file_get_contents($file));
            return $fullPath;
        } else {
            return $file;
        }
    }

    public static function fileDelete($fullPath, $disk = 'public')
    {
        if (!is_null($fullPath)) {
            Storage::disk($disk)->delete($fullPath);
        }
    }

    public static function fileUpdate($oldFullPath, $file, $filePath, $filename = null, $disk = 'public')
    {
        if (!is_null($file)) {
            self::fileDelete($oldFullPath);
            return self::fileStore($file, $filePath, $filename, $disk);
        } else {
            return $oldFullPath;
        }
    }

    public static function fileStoreMultiple($files, $filePath, $fileName = null, $disk = 'public')
    {
        if (is_array($files) && count($files) > 0) {
            $arrFullPath = [];
            foreach ($files as $idx => $file) {
                $arrFullPath[] = self::fileStore($file, $filePath, ($fileName ?? date('YmdHis')) . '_' . $idx , $disk);
            }
            return $arrFullPath;
        } else {
            return $files;
        }
    }

    public static function fileUpdateMultiple($oldFiles, $deletedFiles, $files, $filePath, $filename= null, $disk = 'public')
    {
        if (is_array($deletedFiles) && count($deletedFiles) > 0 ) {
            foreach ($deletedFiles as $deletedFile) {
                self::fileDelete($oldFiles[$deletedFile]);
                unset($oldFiles[$deletedFile]);
            }
        }

        $arrFullPath = array_values($oldFiles ?? []);

        if ((is_array($files) && count($files) > 0)) {
            foreach ((array) $files as $idx => $file) {
                $arrFullPath[] = self::fileStore($file, $filePath, ($fileName ?? date('YmdHis')) . '_' . $idx , $disk);
            }
        }
        
        return $arrFullPath;
    }
}