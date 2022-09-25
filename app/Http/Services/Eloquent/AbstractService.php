<?php

namespace App\Http\Services\Eloquent;

use App\Http\Repositories\Eloquent\AbstractRepo;
use App\Http\Services\Interfaces\AbstractServiceInterface;



class AbstractService implements AbstractServiceInterface
{

    protected $repo;

    public function __construct(AbstractRepo $repo)
    {
        $this->repo = $repo;
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }
    public function update(array $data, $item)
    {
        return $this->repo->update($data, $item);
    }
    public function destroy(int $resource_id)
    {
        return $this->repo->deleteById($resource_id);
    }
    public function all(array $columns = ['*'], array $relations = [])
    {
        return $this->repo->all($columns, $relations);
    }
    public function getAll()
    {
        return $this->repo->getAll();
    }
    public function findOrFail($id)
    {
        return $this->repo->findOrFail($id);
    }


    /**
     * @param int $resource_id
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return mixed
     */

    public function generateRandomString($length = 20)
    {
        return $this->repo->generateRandomString($length = 20);

    }
}
