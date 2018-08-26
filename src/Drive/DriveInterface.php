<?php

namespace Json\DB\Drive;

interface DriveInterface
{
    public function load($fileName);

    public function persist($fileName, array $data);
}