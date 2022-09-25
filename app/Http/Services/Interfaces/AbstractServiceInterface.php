<?php

namespace App\Http\Services\Interfaces;

interface AbstractServiceInterface
{
    public function store(array $data);
    public function update(array $data, $item);
    public function destroy(int $resource_id);
    public function all(array $columns = ['*'], array $relations = []);
 
}
