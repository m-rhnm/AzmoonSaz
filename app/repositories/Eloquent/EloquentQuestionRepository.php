<?php

namespace App\repositories\Eloquent;

use App\Models\Question;
use App\Entities\Question\QuestionEloquentEntity;
use App\repositories\Eloquent\EloquentBaseRepository;
use App\repositories\Contracts\QuestionRepositoryInterface;



class EloquentQuestionRepository extends EloquentBaseRepository implements QuestionRepositoryInterface
{
    protected $model = Question::class;
    public function create(array $data){
        $createQuestion = parent::create($data);
        return new QuestionEloquentEntity ($createQuestion);
    }
    public function update(int $id,array $data){
        if(!parent::update($id, $data)){
            throw new \RuntimeException("question dont update");
        }
       return new QuestionEloquentEntity(parent::find($id));
    }
    
}