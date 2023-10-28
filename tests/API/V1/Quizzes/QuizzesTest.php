<?php

namespace Tests\API\V1\Quizzes;

use Tests\TestCase;
use App\repositories\Contracts\CategoryRepositoryInterface;
use App\repositories\Contracts\QuizRepositoryInterface;
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
        $category = $this->createCategory()[0];
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

    private function createCategory(int $count = 1):array
    {
        $categoryRepository = $this->app->make(CategoryRepositoryInterface::class);
        $newCategory = [
            'name'=> 'new category',
            'slug'=>'new-category'
        ];
        $categories = [];
        foreach(range(0, $count) as $item){
           $categories[] = $categoryRepository->create($newCategory);

        }
        return $categories;   
    }
    private function createQuiz(int $count = 1):array{
        $quizRepository = $this->app->make(QuizRepositoryInterface::class);
        $category = $this->createCategory()[0];
        $startDate = Carbon::now()->addDay();
        $newQuizzesData = [
            'title'=>'quiz 1',
            'description'=>'this is new quiz for test',
            'category_id'=>$category->getId(),
           'start_date'=>$startDate->format('Y-m-d'),
           'duration'=>$startDate->addRealMinutes(60)->format('Y-m-d'),
        ];
        $quizzes=[];
        foreach(range(0, $count) as $item){
            $quizzes[]= $quizRepository->create($newQuizzesData);
        }
        return $quizzes;
    }
}