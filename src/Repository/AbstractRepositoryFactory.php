<?php

namespace Json\DB\Repository;

use Json\DB\Drive\DriveInterface;

abstract class AbstractRepositoryFactory
{
    /**
     * @param DriveInterface $drive
     * @return RepositoryInterface
     */
    abstract public function factory(DriveInterface $drive);
}