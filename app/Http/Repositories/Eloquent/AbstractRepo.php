<?php

namespace App\Http\Repositories\Eloquent;
use App\Http\Repositories\Interfaces\AbstractRepoInterface;

class AbstractRepo implements AbstractRepoInterface
{
    protected $model;

    public function __construct(string $model)
    {
        $this->model = $model;
    }

    public function findOrFail($id)
    {
        return $this->model::findOrfail($id);
    }

    public function getAll()
    {
        return $this->model::get();
    }

     public function all()
        {
            return $this->model::get();
        }

    public function findById($id)
    {
        return $this->model::where('id',$id)->first();
    }    
    public function findWhere($column, $value)
    {
        return $this->model::where($column, $value)->get();
    }
    public function findWhereIn($column, array $values)
    {
        return $this->model::whereIn($column, $values)->get();
    }
    public function bulkDelete(array $ids)
    {
        $allRows = $this->model::withTrashed()->find($ids);
        foreach ($allRows as $row) {

            if ($row->trashed()) {
                $row->forceDelete();
            } else {
                $row->delete();
            }
        }
        return true;
    }
    // public function delete($id)
    // {
    // $item=$this->model::where('id',$id)->delete();

    // }

    public function create($data)
    {
        return $this->model::create($data);
    }

    public function update($data, $item)
    {
        return $item->update($data);
    }

    public function whereFirst($column ,$value)
    {
        return $this->model::where($column,$value)->first();
    }
    public function generateRandomString($length = 20)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generateRandomUniqueString($model,$att,$len){
        do {
            $code = $this->generateRandomString($len);
        } while ($model::where($att, "=", $code)->first());
        return $code;
    }//end of generateRandomUniqueString


   

}
