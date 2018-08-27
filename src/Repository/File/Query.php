<?php

namespace Json\DB\Repository\File;

use Json\DB\Repository\QueryInterface;

class Query implements QueryInterface
{
    private $q = [];

    private $limit = 10;

    private $page = 1;

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

    public function getOffset()
    {
        return $this->limit * ($this->page - 1);
    }

    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }
}
