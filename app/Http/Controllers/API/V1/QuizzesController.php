<?php 

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Contracts\APIController;
use App\repositories\Contracts\QuizRepositoryInterface;
use Carbon\Carbon;

class QuizzesController extends APIController
{
    public function __construct(private QuizRepositoryInterface $quizRepository)
    {  
    }    
    public function store(Request $request)
    {    
        $this->validate($request,
        [
            'title' => 'required|string',  
            'description'=>'required|string',
            'category_id'=>'required|numeric',
            'start_date'=>'required|date',
            'duration'=>'required|date',
        ]); 
        if($request->start_date < $request->duration){
            return $this->respondInvalidValidation('StartDate should elder than duration');
        }
        $newQuiz = $this->quizRepository->create([
            'title'=>$request->title,
            'description'=>$request->description,
            'category_id'=>$request->category_id,
            'start_date'=>$request->start_date,
            'duration'=>Carbon::parse($request->duration),
        ]);
        return $this->respondCreate('quiz created successfully',
        [
            'title'=>$newQuiz->getTitle(),
            'description'=>$newQuiz->getDescription(),
            'category_id'=>$newQuiz->getCategoryId(),
            'start_date'=>$newQuiz->getStartDate(),
            'duration'=>Carbon::parse($newQuiz->getDuration())->format('y-m-d'),
        ]);
    }
}