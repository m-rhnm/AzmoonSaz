<?php

namespace Tests\API\V1\Quizzes;

use Tests\TestCase;

use Carbon\Carbon;

class QuizzesTest extends TestCase
{
    public  function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    public function test_ensure_that_we_can_create_a_new_quiz()
    {
        $category = $this->createCategories()[0];
        $startDate = Carbon::now()->addDay();
        $newQuizzesData = [
            'title'=>'quiz 1',
            'description'=>'this is new quiz for test',
            'category_id'=>$category->getId(),
           'start_date'=>$startDate->format('Y-m-d'),
           'duration'=>$startDate->addRealMinutes(60)->format('Y-m-d'),
        ];
        $response = $this->call('POST','api/v1/quizzes', $newQuizzesData);
        $responseData = json_decode($response->getContent(), true)['data'];
        $this->assertEquals('201',$response->getStatusCode());
        $this->assertEquals($newQuizzesData['title'],$responseData['title']);
        $this->seeInDatabase('quizzes',$newQuizzesData);
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[
                'title',
                'description',
                'category_id',
                'start_date',
                'duration',
            ], 
        ]);
    }
    public function test_ensure_that_we_can_delete_a_quiz()
    {
        $quizzes = $this->createQuiz()[0];
        $response = $this->call('delete','api/v1/quizzes', [
            'id'=> $quizzes->getId(),
        ]);
        $this->assertEquals('200',$response->getStatusCode());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[], 
        ]);
        
    }
    public function test_ensure_that_we_can_get_quizzes(){
        $quiz=$this->createQuiz(20);
        $pageSize = 4;
        $response = $this->call('get','api/v1/quizzes', [
            'page'=>1,
            'pageSize'=>$pageSize,
        ]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($pageSize,count($data['data']));
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data',
        ]);
    }
    public function test_ensure_that_we_can_filtered_quizzes(){
        $pageSize = 4;
        $QuizTitle = 'quiz 1';
       $response= $this->call('get','api/v1/quizzes',[
            'search' => $QuizTitle,
            'page'  => 1,
            'pageSize'=>$pageSize,
        ]);
        $data = json_decode($response->getContent(), true);
        foreach($data['data'] as $value){
            $this->assertEquals($QuizTitle,$value['serach']);
        }
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success',
            'message',
            'data'=>[],
        ]);
    }
    public function test_ensure_that_we_can_update_quizzes(){
        $newQuiz = $this->createQuiz()[0];
        $newQuizData = [
            'id'=> (string)$newQuiz->getId(),
            'title'=>(string) $newQuiz->getTitle().'updated',
            'category_id'=>(int) $newQuiz->getCategoryId(),
            'description'=> (string)$newQuiz->getDescription().'updated',
            'start_date'=> (string)$newQuiz->getStartDate(),
            'duration'  =>(string) $newQuiz->getDuration(),
            'is_active'=>false,
        ];
        $response = $this->call('put','api/v1/quizzes',$newQuizData);
        $this->assertEquals(200,$response->status());
        $this->seeInDatabase('quizzes',$newQuizData);
        $this->seeJsonStructure([
            'success',
            'message',
            'data'=>[
                'title',
                'description',
                'category_id',
               'start_date',
               'duration',
               'is_active'
            ],

        ]);
    }
 
}