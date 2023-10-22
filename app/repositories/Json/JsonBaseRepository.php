<?php 
namespace App\repositories\Json;

use App\Entities\User\UserEntity;
use App\Entities\User\UserJsonEntity;
use App\repositories\Contracts\RepositoryInterface;

class JsonBaseRepository implements RepositoryInterface
{
    protected $jsonModel;
    public function create(array $data){
        if(file_exists($this->jsonModel)){
            $users = json_decode(file_get_contents($this->jsonModel),true);
            $data['id'] = rand(1,1000);
            array_push($users,$data);
            file_put_contents($this->jsonModel,json_encode($users));
        }else{
            $users = [];
            $data['id'] = rand(1,1000);
            array_push($users,$data);
            file_put_contents($this->jsonModel,json_encode($users));
        }
        
    }
    public function update(int $id,array $data){
        $users = json_decode(file_get_contents('user.json'),true);
        foreach($users as $key=>$user)
        {   
             if($user['id'] == $id){
                //var_dump($user['id']);
                $user['fullName'] = $data['fullName'] ?? $user['fullName'];
                $user['email'] = $data['email']  ?? $user['email'];
                $user['mobile'] = $data['mobile']  ?? $user['mobile'];
                $user['password'] = $data['password']  ?? $user['password'];
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
    public function delete(int $id){
        $users = json_decode(file_get_contents('user.json'),true);
        //  var_dump($id);
        foreach($users as $key=>$user)
        {
             if($user['id'] == $id){
              //  var_dump($user['id']);
                unset($users[$key]);
                if(file_exists('user.json')){unlink('user.json');}
                file_put_contents('user.json',json_encode($users));
             }
             break;
        }
       // var_dump($users);
    }
    public function find(int $id)
    {
        $user = json_decode(file_get_contents( base_path() .'\user.json'),true);
        foreach($user as $user){
            if( $user['id'] == $id){
                return new UserJsonEntity($user);
             }
         }
        return new UserJsonEntity(null); 
    }
    public function paginate(string $search =null,int $page,int $pagesize = 20)
    {
       // dd(base_path().'\user.json');
        $users =json_decode(file_get_contents(base_path().'\user.json'),true);
        //dd($users,$search);
        if(!is_null($search))
        {
            foreach($users as $key => $user)
            {
                
                 if(array_search($search,$user))
                {
                   return dd($users[$key]);
                
                }  
            }
        }
        $totalRecords = count($users);
        $totalPage = ceil($totalRecords / $pagesize);
        if ($page > $totalPage)
            {$page = $totalPage;}
        if ($page < 1)
            { $page = 1; }
        $offset = ($page -1) * $pagesize;
        return array_slice($users, $offset, $pagesize);
    }
}