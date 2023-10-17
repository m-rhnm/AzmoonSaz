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
            file_put_contents('user.json',json_encode($users));
        }
    }
    public function update(int $id,array $data){
        $users = json_decode(file_get_contents('user.json'),true);
        foreach($users as $key=>$user)
        {
             if($user['id'] == $id){
                $user['fullName'] = $data['fullName'] ?? $user['fullName'];
                $user['email'] = $data['email']  ?? $user['email'];
                $user['mobile'] = $data['mobile']  ?? $user['mobile'];
                $user['password'] = $data['mobile']  ?? $user['password'];
                unset($users[$key]);
                array_push($users,$user);
                if(file_exists('user.json')){unlink('user.json');}
                file_put_contents('user.json',json_encode($users));
             }
             break;
        }
    }
    public function all(array $where){

    }
    public function delete(array $where){

    }
    public function find(int $id){

    }
}