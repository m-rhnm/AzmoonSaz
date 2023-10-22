<?php
namespace App\Entities\User;

use App\Entities\User\UserEntity;

class UserJsonEntity implements UserEntity
{
    private $user;
    public function __construct(array|null $user){
        $this->user = $user;
    }
    public function getId(): int
    {
        return $this->user['id'];
    }
    public function getfullName(): string
    {
        return $this->user['fullName'];
    }
    public function getEmail(): string
    {
        return $this->user['email'];
    }
    public function getmMobile(): string{
        return $this->user['Mobile'];
    }
    public function getPassword(): string{
        return $this->user['password'];
    }
}