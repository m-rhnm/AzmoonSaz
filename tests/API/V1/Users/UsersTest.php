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
}


