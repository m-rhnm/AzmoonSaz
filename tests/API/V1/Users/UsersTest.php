<?php
namespace Tests\API\V1\Users;

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
        $response = $this->call('put','api/v1/users',
        [
            'id'=>'782',
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
        $response = $this->call('put','api/v1/users/change-password',
        [
            'id'=>'194',
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
        $response = $this->call('delete','api/v1/users',
        [
            'id'=>'194',
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
        $pagesize = 3;
        $userEmail = 'Mohamad@gmail.com';
        $response = $this->call('get','api/v1/users',
        [
        'search'=>$userEmail,
        'page'=>1,
        'pagesize'=>$pagesize,
        ]);
        $data= json_decode($response->getContent(),true);
        $this->assertEquals($data['data']['email'],$userEmail);
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[]
        ]);
    }


}


