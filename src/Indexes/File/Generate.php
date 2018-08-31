<?php

namespace Json\DB\Indexes\File;

use Json\DB\Drive\File\Drive;
use Json\DB\Helper\StringHelper;

class Generate
{
    private $drive;

    private $index = [];

    public function __construct(Drive $drive)
    {
        $this->drive = $drive;
    }

    public function generate()
    {
        $all = $this->drive->loadAll();

        $index = [];
        foreach($all as $data) {
            $this->checkArray($data);
        }

        $this->drive->persistIndex($this->index);
    }

    private function checkArray(array $data)
    {
        foreach($data as $key => $value) {
            if ($key === '@@ID') {
                continue;
            }
            if (is_array($value)) {
                $value['@@ID'] = $data['@@ID'];
                $this->checkArray($value);
            } else {
                $this->addIndex($value, $data);
            }
        }
    }

    private function addIndex($value, $data)
    {
        $v = explode(" ", $value);
        foreach($v as $v1) {
            $v1 = StringHelper::stripAccents($v1);
            if (isset($this->index[$v1]) === false) {
                $this->index[$v1] = [];
            }
            $this->index[$v1][$data['@@ID']] = $data['@@ID'];
        }
    }
}
