<?php

namespace App\Helpers;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{
    protected $userId;
    protected $file;
    protected $data = [];

    public function __construct(UploadedFile $file, $userId = null)
    {
        $this->userId = $userId ? $userId : auth()->id();
        $this->file = $file;
        $this->setData();
    }


    protected function setData(){
        $getid = new GetID3Helper($this->file);
        $info = $getid->getidData();
        if (!$this->file->getError()) {
            if (!isset($info['error'])) {
                $name = $this->file->getClientOriginalName();
                $this->file->store("uploads/{$this->userId}", 'public');
                $path = "uploads/{$this->userId}/{$this->file->hashName()}";
                $this->data = [
                    'user_id' => $this->userId,
                    'name' => $name,
                    'path' => $path,
                    'size' => $info['filesize'],
                    'mime' => $info['mime_type'],
                    'extension' => $info['fileformat'],
                    'additional_data' => $info['additional_data']
                ];
            }
        }
    }

    public function getData(){
        return $this->data;
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

    public static function extensionImagePath($extension){
        $default = "storage/extensions/default.png";
        $path = "storage/extensions/$extension.png";
        return asset(file_exists($path) ? $path : $default );
    }

}
