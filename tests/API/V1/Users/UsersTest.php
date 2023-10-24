<?php
namespace Tests\API\V1\Users;

use App\repositories\Contracts\UserRepositoryInterface;
use Tests\TestCase;

class UsersTest extends TestCase
{
    public function test_should_create_a_new_user()
    {
       $response = $this->call('post','api/v1/users',[
            'fullName' => 'Mohamad Rahnama',
            'email' => 'Mohamad@gmail.com',
            'mobile' => '09165341019',
            'password' => '17691769'
        ]);
        $this->assertEquals(201, $response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[
            'fullName',
            'email' ,
            'mobile' ,
            'password' 
            ]
            ]);
    }
    public function test_it_must_throw_a_exception_if_we_dont_send_parameters()
    {
        $response = $this->call('post','api/v1/users',[]);
        $this->assertEquals(422, $response->status());
    }
    public function test_should_update_information_of_user()
    {
        $user = $this->createUser()[0];
        $response = $this->call('put','api/v1/users',
        [
            'id'=>(string)$user->getId(),
            'fullName' => 'Zahra Rahnama',
            'email' => 'Zahra@gmail.com',
            'mobile' => '09165330324'
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure(
            [
                'success' ,
                'message' ,
                'data'=>
                [
                    'fullName',
                    'email' ,
                    'mobile' 
                ]
            ]);
    }
    public function test_it_must_throw_a_exception_if_we_dont_send_parameters_to_updates_info()
    {
        $response = $this->call('put','api/v1/users',[]);
        $this->assertEquals(422, $response->status());
    }
    public function test_should_update_password()
    {
        $user = $this->createUser()[0];
        $response = $this->call('put','api/v1/users/change-password',
        [
            'id'=>(string)$user->getId(),
            'password'=>'176900',
            'password_repeat'=>'176900'
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure(
        [
            'success' ,
            'message' ,
            'data'=>
            [
                'fullName',
                'email' ,
                'mobile' 
            ]
        ]);
    }
    public function test_it_must_throw_a_exception_if_we_dont_send_parameters_to_updates_password()
    {
        $response = $this->call('put','api/v1/users/change-password',[]);
        $this->assertEquals(422, $response->status());
    }
    public function test_should_delete_users()
    {
        $user = $this->createUser()[0];
        $response = $this->call('delete','api/v1/users',
        [
            'id'=>(string)$user->getId(),
        ]);
        $this->assertEquals(200, $response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data',
        ]);
    }
    public function test_it_must_throw_a_exception_if_we_dont_send_parameters_to_delete_user()
    {
        $response = $this->call('put','api/v1/users',[]);
        $this->assertEquals(422, $response->status());
    }
    public function test_should_read_users()
    {
        $pagesize = 2;
        $response = $this->call('get','api/v1/users',
        [
        'page'=>1,
        'pagesize'=>$pagesize,
        ]);
        $data= json_decode($response->getContent(),true);
        $this->assertEquals($pagesize,count($data['data']));
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[]
        ]);
    }
    public function test_should_get_search_users()
    {   
        $pagesize = 5;
        $userName = 'mohamad';
        $response = $this->call('get','api/v1/users',
        [
        'search'=>$userName,
        'page'=>1,
        'pagesize'=>$pagesize,
        ]);
        $data= json_decode($response->getContent(),true);
        foreach($data['data'] as $user)
        {
            $this->assertEquals($user['fullName'],$userName);            
        }       
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[]
        ]);
    }

    private function createUser(int $count = 1 ):array{
        $userRepository= $this->app->make(UserRepositoryInterface::class);
        $userData = [
            'fullName' => 'Sara',
            'email' => 'sara@gmail.com',
            'mobile' =>'09364998010',
            'password'=>'156156'
        ];
        $users = [];
        foreach(range(0,$count) as $items){
            $users[] = $userRepository->create($userData);
        }
        return $users;
    }


}


