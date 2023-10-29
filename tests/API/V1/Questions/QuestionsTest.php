<?php
namespace Tests\API\V1\Questions;

use App\Consts\QuestionStatus;
use Tests\TestCase;

class QuestionsTest  extends TestCase {
    public  function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    public function test_ensure_we_can_create_a_new_question()
    {
        $newQuizzes =$this->createQuiz()[0];
        $newQuestionData = 
        [
            'quiz_id'=> $newQuizzes->getId(),
            'title'=>'How old is messi?',
            'options'=> json_encode(
                [
                1=>['text'=>'15','is_correct'=>0],
                2=>['text'=>'25','is_correct'=>0],
                3=>['text'=>'40','is_correct'=>0],
                4=>['text'=>'36','is_correct'=>1]
                ]),
            'is_active'=> QuestionStatus::ACTIVE,
            'score'=>15,
        ];
        $response= $this->call('POST','api/v1/questions',$newQuestionData);
        $responseData = json_decode($response->getContent(),true)['data'];
        $this->assertEquals('201',$response->getStatusCode());
        $this->seeInDatabase('questions',$newQuestionData);
        $this->assertEquals($newQuestionData,$responseData);
        $this->seeJsonStructure([
            'success',
            'message',
            'data'=>
            [
                'quiz_id',
                'title',
                'options',
                'is_active',
                'score',
            ]
        ]);
    }
    public function test_ensure_we_can_delete_a_question(){
       $question=$this->createQuestion()[0];
       $newQuestion=[
        'id'=> $question->getId(),
       ];
        $response = $this->call('delete','api/v1/questions',$newQuestion);
        $this->assertEquals('200',$response->getStatusCode());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[], 
        ]);
        
    }
  
}