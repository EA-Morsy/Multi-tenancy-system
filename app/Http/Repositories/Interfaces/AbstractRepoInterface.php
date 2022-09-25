<?php

namespace App\Http\Repositories\Interfaces;


interface AbstractRepoInterface
{
    public function findOrFail($id);
    public function bulkDelete(Array $ids);
    public function getAll();
    public function findWhere($column,$value);
    public function findWhereIn($column,Array $values);
    public function create(Array $data);
    public function update(Array $data,$model);
    public function generateRandomString(int $length);
}
