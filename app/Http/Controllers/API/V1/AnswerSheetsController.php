<?php 

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Contracts\APIController;
use App\repositories\Contracts\AnswerSheetRepositoryInterface;
use App\repositories\Contracts\QuizRepositoryInterface;

class AnswerSheetsController extends APIController
{
    public function __construct(private AnswerSheetRepositoryInterface $answerSheetRepository,
                                private QuizRepositoryInterface        $quizRepository)
    {  
    }    
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'quiz_id' => 'required|numeric',  
            'answers'=>'required|json',
            'status'=>'required|numeric',
            'score'=>'required|numeric',
            'finished_at'=>'required|date',
        ]); 
        if(! $this->quizRepository->find($request->quiz_id)){
                return $this->respondNotFound('quiz not found!!',[]);
                
              }
        $newAnswerSheet= $this->answerSheetRepository->create([
            'status' => $request->status,  
            'answers'=>$request->answers,
            'quiz_id'=>$request->quiz_id,
            'finished_at'=>$request->finished_at,
            'score'=>$request->score,
        ]);
        return $this->respondCreate('answer-Sheet created successfully',
        [
            'status' => $newAnswerSheet->getStatus(),  
            'answers'=>$newAnswerSheet->getAnswers(),
            'quiz_id'=>$newAnswerSheet->getQuizId(),
            'finished_at'=>$newAnswerSheet->getFinishedAt(),
            'score'=>$newAnswerSheet->getScore(),
        ]);
    }
    public function remove(Request $request)
    {
        $this->validate($request,[
            'id'=>'required'
        ]);
        if(!$this->answerSheetRepository->find($request->id)){
            return $this->respondNotFound('not found this answer_sheet',[]);
        }
        if(!$this->answerSheetRepository->delete($request->id)){
            return $this->respondInternalError('faild to remove answer_sheet,please try again',[]);
        }
            return $this->respondSuccess('answer_sheet removed successfully',[]);
    }
     public function index(Request $request){
        $this->validate($request,
        [
            'search'=>'nullable|string',
            'page'=>'required|numeric',
            'pageSize'=>'nullable|numeric',
        ]);
       $answerSheet = $this->answerSheetRepository->paginate($request->search,$request->page,$request->pageSize ?? 20,['score','quiz_id','answers','status','finished_at']);
        return $this->respondSuccess('answer_sheet', $answerSheet);
    }
}
 
