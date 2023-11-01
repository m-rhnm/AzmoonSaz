<?php 

namespace Tests\API\V1\AnswerSheets;

use Tests\TestCase;
use App\Consts\AnswerSheetStatus;
use Carbon\Carbon;

class AnswerSheetsTest extends TestCase{
    public  function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }
    public function test_ensure_we_can_create_a_new_answersheet(){
        $quiz = $this->createQuiz()[0];
        $answer_sheet_data =[
            'quiz_id'=>$quiz->getId(),
            'answers'=>json_encode([
                12=>1,
                13=>2,
                14=>3,
            ]),
            'status'=>AnswerSheetStatus::PASSED,
            'score'=>73,
            'finished_at'=>Carbon::now(),
        ];
        $response = $this->call('POST','api/v1/answer-sheets',$answer_sheet_data);
        $responseData=json_decode($response->getContent(),true)['data'];
        $responseData['finished_at']=Carbon::parse($responseData['finished_at'])->format('Y-m-d H:i:s');
        $answer_sheet_data['finished_at']=$answer_sheet_data['finished_at']->format('Y-m-d H:i:s');
        $this->assertEquals('201',$response->getStatusCode());
        $this->seeInDatabase('answer_sheets',$answer_sheet_data);
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[
                'quiz_id',
                'answers',
                'status',
                'score',
                'finished_at',
            ], 
        ]);
    }
}