<?php

namespace Json\DB\Drive\File;

use Json\DB\Drive\DriveInterface;
use Json\DB\Drive\Exception\OpenDataException;
use Json\DB\Drive\Exception\WriteException;

class Drive implements DriveInterface
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->setUp();
    }

    public function loadAll()
    {
        $data = [];
        foreach(glob($this->config->getPathIndex() .'/data/*') as $f) {
            $f = explode('/', $f);
            $f = $f[count($f) - 1];
            $f = explode('.', $f);
            $f = $f[0];
            $d = $this->load($f);
            if (empty($d) === false) {
                $data[] = $d;
            }
        }

        return $data;
    }

    public function load($fileName)
    {
        try {
            $ID = $fileName;
            $fileName = $this->config->getPathIndex() .'/data/'. $fileName . '.dt';

            $lines = $this->getLastLines($fileName);

            if (isset($lines[0]) === true) {
                $data = json_decode($lines[0], true);
                $data['@@ID'] = $ID;
                return $data;
            }

            return [];
        } catch (\Exception $e) {
            throw new OpenDataException("Error open: " . $this->config->getPathIndex() .'/data/'. $fileName . '.dt');
        }
    }

    public function loadIndex()
    {
        try {
            $fileName = $this->config->getPathIndex() .'/index.json';

            return json_decode(file_get_contents($fileName), true);
        } catch (\Exception $e) {
            throw new OpenDataException("Error open: " . $this->config->getPathIndex() .'/index.json');
        }
    }

    public function persist($fileName, array $data)
    {
        try {
            $f = fopen($this->config->getPathIndex() .'/data/'. $fileName . '.dt', 'a');
            fwrite($f, json_encode($data) . "\n");
            fclose($f);
        } catch (\Exception $e) {
            throw new OpenDataException("Error open: " . $this->config->getPathIndex() .'/data/'. $fileName . '.json');
        }
    }

    public function persistIndex(array $data)
    {
        try {
            $f = fopen($this->config->getPathIndex() .'/index.json', 'w');
            fwrite($f, json_encode($data));
            fclose($f);
        } catch (\Exception $e) {
            throw new OpenDataException("Error open: " . $this->config->getPath() .'/index.json');
        }
    }

    private function setUp()
    {
        if (file_exists($this->config->getPathIndex() . '/index.json') === true) {
            return;
        }

        if (is_writable($this->config->getPath()) === false) {
            throw new WriteException(sprintf("directory: %s don't have permission to write", $this->config->getPath()));
        }

        if (is_dir($this->config->getPathIndex() .'/data') === false) {
            if (mkdir($this->config->getPathIndex(). '/data', 0777, true) === false) {
                throw new \Exception("Problem when create the: " . $this->config->getIndex());
            }
        }

        if (touch($this->config->getPathIndex() . '/index.json') === false) {
            throw new \Exception("Problem when create the index");
        }
    }

    private function getLastLines($path, $totalLines = null)
    {
        $lines = array();
        if (is_null($totalLines) === true) {
            $totalLines = count(file($path));
        }
        
        $fp = fopen($path, 'r');
        fseek($fp, -1, SEEK_END);
        $pos = ftell($fp);
        $lastLine = "";

        while($pos > 0 && count($lines) < $totalLines) {
            $C = fgetc($fp);
            if($C == "\n") {
                if(trim($lastLine) != "") {
                    $lines[] = $lastLine;
                }
                $lastLine = '';
            } else {
                $lastLine = $C.$lastLine;
            }
            fseek($fp, $pos--);
        }
        return $lines;
      }
}
