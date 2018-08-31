<?php

namespace Json\DB\Repository\File;

use Json\DB\Repository\RepositoryInterface;
use Json\DB\Drive\File\Drive;
use Json\Db\Query;

class Repository implements RepositoryInterface
{
    private $drive;
    private $index;

    public function __construct(Drive $drive)
    {
        $this->drive = $drive;
        $this->index = $drive->loadIndex();
    }

    public function fetchAll(Query $query)
    {
        $documents = [];
        $q = $query->getQ();

        if (count($q) > 0) {
            foreach($query->getQ() as $term) {
                if (isset($this->index[$term]) === true) {
                    foreach($this->index[$term] as $d) {
                        if (isset($documents[$d]) === false) {
                            $documents[$d] = 1;
                        }
    
                        $documents[$d] += 1;
                    }
                }
            }
        } else {
            foreach($this->index as $index) {
                foreach($index as $d) {
                    if (isset($documents[$d]) === false) {
                        $documents[$d] = 1;
                    }
    
                    $documents[$d] += 1;
                }
            }
        }

        $data = [];
        $cont = 0;
        $contItens = 0;
        arsort($documents);
        foreach($documents as $ID => $score) {
            if ($cont < $query->getOffset()) {
                $cont += 1;
                continue;
            }

            if ($contItens >= $query->getLimit()) {
                break;
            }

            $d = $this->drive->load($ID);
            $d['@@SCORE'] = $score;
            $data[] = $d;
            $contItens += 1;
        }

        return [
            'total' => count($documents),
            'per_page' => $query->getLimit(),
            'current_page' => $query->getPage(),
            'data' => $data
        ];
    }

    public function update($id, array $data)
    {
        $this->validation($data);
        $this->drive->persist($id, $data);
    }

    public function create(array $data)
    {
        $id = uniqid();
        $this->validation($data);
        $this->drive->persist($id, $data);
        return $id;
    }

    private function validation(&$data)
    {
        if (isset($data[@@ID]) === true) {
            unset($data[@@ID]);
        }
    }
}
