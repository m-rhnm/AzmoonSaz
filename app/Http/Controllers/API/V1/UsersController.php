<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\repositories\Contracts\UserRepositoryInterface;

class UsersController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
        
    }
    public function store()
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'user created successfully',
                'data'=>
                [
                'fullName' => 'Mohamad Rahnama',
                'email' => 'Mohamad@gmail.com',
                'mobile' => '09165341019',
                'password' => '17691769'
                ]
            ]
        )->setStatusCode(201);
    }
}