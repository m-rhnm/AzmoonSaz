<?php

namespace Tests;

use Carbon\Carbon;
use App\Consts\QuestionStatus;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use App\repositories\Contracts\QuizRepositoryInterface;
use App\repositories\Contracts\CategoryRepositoryInterface;
use App\repositories\Contracts\QuestionRepositoryInterface;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
    protected function createCategories(int $count=1):array{
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
    protected function createQuiz(int $count = 1):array{
        $quizRepository = $this->app->make(QuizRepositoryInterface::class);
        $category = $this->createCategories()[0];
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
    protected function createQuestion(int $count=1)
    {
        $questionRepository = $this->app->make(QuestionRepositoryInterface::class);
        $quiz = $this->createQuiz()[0];

        $newQuestionData = [
            'quiz_id'=> $quiz->getId(),
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
        $questions=[];
        foreach(range(0, $count) as $item){
            $questions[]= $questionRepository->create($newQuestionData);
        }
        return $questions;
    }
}
