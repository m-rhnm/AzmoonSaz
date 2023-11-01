<?php

namespace App\repositories\Eloquent;

use App\Models\AnswerSheet;
use App\repositories\Eloquent\EloquentBaseRepository;
use App\Entities\AnswerSheet\AnswerSheetEloquentEntity;
use App\repositories\Contracts\AnswerSheetRepositoryInterface;



class EloquentAnswerSheetRepository extends EloquentBaseRepository implements AnswerSheetRepositoryInterface
{
    protected $model = AnswerSheet::class;
    public function create(array $data){
        $createAnswerSheet = parent::create($data); 
         return new AnswerSheetEloquentEntity($createAnswerSheet);
    }
    
    // public function update(int $id,array $data){
    //     if(!parent::update($id, $data)){
    //         throw new \RuntimeException("question dont update");
    //     }
    //    return new QuestionEloquentEntity(parent::find($id));
    // }
    
}