<?php

namespace Json\DB\Repository\File;

use Json\DB\Repository\QueryInterface;

class Query implements QueryInterface
{
    private $q = [];

    private $limit = 10;

    private $offset = 0;

    public function setQ($text)
    {
        $this->q = explode(" ", $text);
        return $this;
    }

    public function getQ()
    {
        return $this->q;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setOffset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset()
    {
        return $this->offset;
    }
}
