<?php


namespace App\Helpers;


class GetID3Helper
{
    protected $name;
    protected $getid3Data;
    protected $errors = [];

    public function __construct($name)
    {
        $this->name = $name;
        $this->extract();
    }

    protected function extract()
    {
        if ($fpRemote = fopen($this->name, 'rb')) {
            $localTempFileName = tempnam('/tmp', 'getID3');
            if ($fpLocal = fopen($localTempFileName, 'wb')) {
                while ($buffer = fread($fpRemote, 8192)) {
                    fwrite($fpLocal, $buffer);
                }
                fclose($fpLocal);
                // Initialize getID3 engine
                $getID3 = new \getID3;
                $this->getid3Data = $getID3->analyze($localTempFileName);
                $this->setAdditionalData();
                // Delete temporary file
                unlink($localTempFileName);
            } else {
                $this->errors[] = 'git3id cant load localTemp file';
            }
            fclose($fpRemote);
        } else {
            $this->errors[] = 'gitid3 cant load file';
        }
    }

    protected function setAdditionalData()
    {
        $data = $this->getid3Data;
        dd($data);
        $type = explode('/', $data['mime_type'], -1)[0];
        if (method_exists($this, $type)) {
            $data['additional_data'] = $this->$type($data);
        } else {
            $data['additional_data'] = null;
        }
        $this->getid3Data = $data;
    }

    public function getidData()
    {
        $this->getid3Data['errors'] = $this->errors;
        return $this->getid3Data;
    }

    protected static function image($data)
    {
        $resolution = self::resolution($data);
        return [
            'resolution' => $resolution,
        ];
    }

    protected static function audio($data)
    {
        $time = self::playTime($data['playtime_seconds']);
        return [
            'playtime' => $time
        ];
    }

    protected static function video($data)
    {
        $time = self::playTime($data['playtime_seconds']);
        $resolution = self::resolution($data);
        return [
            'playtime' => $time,
            'resolution' => $resolution,
        ];
    }


    protected static function playTime($playtime)
    {
        $playtime = floor($playtime);
        $sec = $playtime % 60;
        $sec = $sec < 10 ? '0' . $sec : $sec;
        $min = ($playtime - $sec) / 60;
        return $min . ':' . $sec;
    }

    protected static function resolution($data)
    {
        return $resolution = $data['video']['resolution_x'] . ' x ' . $data['video']['resolution_y'];
    }

}
