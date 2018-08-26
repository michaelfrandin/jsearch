<?php

namespace Json\DB\Repository;

interface RepositoryInterface
{
    public function update($id, array $data);

    public function create(array $data);
}