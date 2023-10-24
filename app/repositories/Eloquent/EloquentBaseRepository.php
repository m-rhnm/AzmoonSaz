<?php

namespace App\repositories\Eloquent;

use App\Models\User;
use App\repositories\Contracts\RepositoryInterface;



class EloquentBaseRepository implements RepositoryInterface
{
    protected $model;
    public function create(array $data)
    {
       return User::create($data);
    }
    public function update(int $id,array $data)
    {
        return User::where('id',$id)->update($data);
    }
    public function all(array $where)
    {
       $query = $this->model::query();
       foreach($where as $key=>$value){
        $query->where($key,$value);
       }
       return $query->get();
    }
    public function delete(int $id) :bool
    {
        return User::where('id',$id)->delete();
    }
    public function find(int $id)
    {
       return User::find($id);
    }
    public function paginate(string $search =null,int $page,int $pagesize = 20):array
    {
        if(is_null($search))
        {
           return User::paginate($pagesize,['fullName','mobile','email'],null,$page)->toArray()['data'];
        }    
        return User::orWhere('fullName',$search)
        ->orWhere('mobile',$search)
        ->orWhere('email',$search)
        ->paginate($pagesize,['fullName','mobile','email'],null,$page)->toArray()['data'];

    }
}