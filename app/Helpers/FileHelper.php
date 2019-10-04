<?php

namespace App\Helpers;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{

    public static function getFileData(UploadedFile $file)
    {
        if ($file->isValid()) {
            $userId = auth()->id();
            $mime = $file->getClientMimeType();
            $name = $file->getClientOriginalName();
            $size = $file->getClientSize();
            $extension = $file->extension();
            $file->store("uploads/{$userId}", 'public');
            $path = "uploads/{$userId}/{$file->hashName()}";
            return [
                'user_id' => $userId,
                'name' => $name,
                'path' => $path,
                'size' => $size,
                'mime' => $mime,
                'extension' => $extension
            ];
        }
        return [
            'error' => $file->getError()
        ];
    }

    public static function getFormatSize($size)
    {
        $bytes = $size;
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $i = 0;
        while ($bytes >= 1024) {
            $bytes /= 1024;
            $i++;
        }
        $i = (count($units) < $i) ? 4 : $i;
        $formatSize = round($bytes, 2) . ' ' . $units[$i];
        return $formatSize;
    }

    public static function getLd()
    {
        $getID3 = new \getID3();
    }

}
