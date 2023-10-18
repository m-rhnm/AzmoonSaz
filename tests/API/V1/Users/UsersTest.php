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
            'id'=>'200',
            'fullName' => 'Zahra Rahnama',
            'email' => 'Zahra@gmail.com',
            'mobile' => '09165341019'
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
            'id'=>'200',
            'password'=>'15161516',
            'password_repeat'=>'15161516'
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
            'id'=>'200',
        ]);
        $this->assertEquals(202, $response->status());
        $this->seeJsonStructure(
        [
          
        ]);
    }
}


