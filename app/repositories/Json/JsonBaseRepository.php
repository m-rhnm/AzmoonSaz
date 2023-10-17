<?php 
namespace App\repositories\Json;


use App\repositories\Contracts\RepositoryInterface;

class JsonBaseRepository implements RepositoryInterface
{
    public function create(array $data){
        if(file_exists('user.json')){
            $users = json_decode(file_get_contents('user.json'),true);
            $data['id'] = rand(1,1000);
            array_push($users,$data);
            file_put_contents('user.json',json_encode($users));
        }else{
            $users = [];
            $data['id'] = rand(1,1000);
            array_push($users,$data);
            file_put_contents('user.json',json_encode($$users));
        }
    }
    public function update(int $id,array $data){

    }
    public function all(array $where){

    }
    public function delete(array $where){

    }
    public function find(int $id){

    }
}