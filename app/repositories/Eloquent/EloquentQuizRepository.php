<?php

namespace App\repositories\Eloquent;

use App\Models\Quiz;
use App\Entities\Quiz\QuizEloquentEntity;
use App\repositories\Eloquent\EloquentBaseRepository;
use App\repositories\Contracts\QuizRepositoryInterface;



class EloquentQuizRepository extends EloquentBaseRepository implements QuizRepositoryInterface
{
    protected $model = Quiz::class;

    public function create(array $data){
        $createQuiz = parent::create($data);
        return new QuizEloquentEntity ($createQuiz);
    }
 
    
}