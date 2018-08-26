<?php

namespace Json\DB\Drive\File;

class Config
{
    private $path;
    private $index;

    public function __construct($path, $index)
    {
        $this->path = $path;
        $this->index = $index;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getPathIndex()
    {
        return $this->path . '/' . $this->index;
    }
}
