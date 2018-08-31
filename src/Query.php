<?php

namespace Json\DB;

use Json\DB\Drive\DriveInterface;
use Json\DB\Helper\StringHelper;

class Query
{
    private $q = [];

    private $limit = 10;

    private $page = 1;

    public function __construct(DriveInterface $drive)
    {
        $this->drive = $drive;
    }

    /**
     * @param string $text
     * @return Query
     */
    public function setQ($text)
    {
        $q = explode(" ", $text);
        foreach($q as $v) {
            $this->q[] = StringHelper::stripAccents($v);
        }

        return $this;
    }

    /**
     * @return array[string]
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * @param int $limit
     * @return Query
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->limit * ($this->page - 1);
    }

    /**
     * @param int $page
     * @return Query
     */
    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }


    /**
     * @return Result
     */
    public function getResult()
    {
        return new Result($this);
    }
}
