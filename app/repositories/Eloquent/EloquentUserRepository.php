<?php 

namespace App\repositories\Eloquent;

use App\repositories\Contracts\UserRepositoryInterface;
use App\repositories\Eloquent\EloquentBaseRepository;



class EloquentUserRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    protected $model = User::class;

}
