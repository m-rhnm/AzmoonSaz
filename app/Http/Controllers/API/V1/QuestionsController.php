<?php 

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Contracts\APIController;
use App\repositories\Contracts\QuestionRepositoryInterface;


class QuestionsController extends APIController
{
    public function __construct(private QuestionRepositoryInterface $questionRepository)
    {  
    }    
    public function store(Request $request)
    {  
        $this->validate($request,
        [
            'title' => 'required|string',  
            'options'=>'required|json',
            'quiz_id'=>'required|numeric',
            'is_active'=>'required|numeric',
            'score'=>'required|numeric',
        ]); 
        $newQuestion = $this->questionRepository->create([
            'title' => $request->title,  
            'options'=>$request->options,
            'quiz_id'=>$request->quiz_id,
            'is_active'=>$request->is_active,
            'score'=>$request->score,
        ]);
        return $this->respondCreate('question created successfully',
        [
            'title' => $newQuestion->getTitle(),  
            'options'=>json_encode($newQuestion->getOption()),
            'quiz_id'=>$newQuestion->getQuizId(),
            'is_active'=>$newQuestion->getIsActive(),
            'score'=>$newQuestion->getScore(),
        ]);
    }
    public function remove(Request $request)
    {
        $this->validate($request,[
            'id'=>'required'
        ]);
        if(!$this->questionRepository->find($request->id)){
            return $this->respondNotFound('not found this quiz',[]);
        }
        if(!$this->questionRepository->delete($request->id)){
            return $this->respondInternalError('faild to remove question,please try again',[]);
        }
            return $this->respondSuccess('question removed successfully',[]);
    }
    public function updateInfo(Request $request){
        $this->validate($request,[
            'id'=>'required|numeric',
            'title' => 'required|string',  
            'options'=>'required|json',
            'quiz_id'=>'required|numeric',
            'is_active'=>'required|numeric',
            'score'=>'required|numeric'
        ]);
       //dd($request);
        if(!$this->questionRepository->find($request->id)){
            return $this->respondNotFound('not found this quiz',[]);
        }
        $newQuestion = $this->questionRepository->update($request->id,
        [
            'title' => $request->title,  
            'options'=>$request->options,
            'quiz_id'=>$request->quiz_id,
            'is_active'=>$request->is_active,
            'score'=>$request->score,
        ]);
            return $this->respondSuccess('quiz updated successfully',
        [
            'title' => $newQuestion->getTitle(),  
            'options'=>json_encode($newQuestion->getOption()),
            'quiz_id'=>$newQuestion->getQuizId(),
            'is_active'=>$newQuestion->getIsActive(),
            'score'=>$newQuestion->getScore(),
        ]);
    }

    public function index(Request $request){
        $this->validate($request,
        [
            'search'=>'nullable|string',
            'page'=>'required|numeric',
            'pageSize'=>'nullable|numeric',
        ]);
       $questions = $this->questionRepository->paginate($request->search,$request->page,$request->pageSize ?? 20,['title','quiz_id','options','score','is_active']);
        return $this->respondSuccess('questions', $questions);
    }
}