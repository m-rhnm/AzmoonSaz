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
    // public function remove(Request $request)
    // {
    //     $this->validate($request,[
    //         'id'=>'required'
    //     ]);
    //     if(!$this->quizRepository->find($request->id)){
    //         return $this->respondNotFound('not found this quiz',[]);
    //     }
    //     if(!$this->quizRepository->delete($request->id)){
    //         return $this->respondInternalError('faild to remove quiz,please try again',[]);
    //     }
    //         return $this->respondSuccess('quiz removed successfully',[]);
        
    // }
    // public function index(Request $request){
    //     $this->validate($request,
    //     [
    //         'search'=>'nullable|string',
    //         'page'=>'required|numeric',
    //         'pagesize'=>'nullable|numeric',
    //     ]);
    //    $quizzes = $this->quizRepository->paginate($request->search,$request->page, $request->pageSize ?? 20,['title','description','start_date','duration']);
    //     return $this->respondSuccess('quizzes',$quizzes);
    // }
    // public function updateInfo(Request $request){
    //     $this->validate($request,[
    //         'title' => 'required|string',  
    //         'description'=>'required|string',
    //         'category_id'=>'required|numeric',
    //         'start_date'=>'required|date',
    //         'duration'=>'required|date',
    //     ]);
    //     if(!$this->quizRepository->find($request->id)){
    //         return $this->respondNotFound('not found this quiz',[]);
    //     }
    //        $quizData =  $this->quizRepository->update($request->id,
    //     [
    //         'title'=>$request->title,
    //         'description'=>$request->description,
    //         'category_id'=>$request->category_id,
    //         'start_date'=>$request->start_date,
    //         'duration'=>Carbon::parse($request->duration),
    //         'is_active'=>$request->is_active
    //     ]);

    //         return $this->respondSuccess('quiz updated successfully',
    //     [
    //         'title'=>$quizData->getTitle(),
    //         'description'=>$quizData->getDescription(),
    //         'category_id'=>$quizData->getCategoryId(),
    //         'start_date'=>$quizData->getStartDate(),
    //         'duration'=>Carbon::parse($quizData->getDuration())->format('y-m-d'),
    //         'is_active'=>$quizData->getIsActive()
    //     ]);

    // }
        
    
}