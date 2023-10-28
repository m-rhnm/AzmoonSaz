<?php 

namespace App\Entities\Quiz;

use App\Models\Quiz;
use App\Entities\Quiz\QuizEntity;

class QuizEloquentEntity implements QuizEntity
{
   private $quiz ;
    public function __construct( Quiz $quiz )
    {
    $this->quiz = $quiz;
    }
    public function getId(): int
    {
        return $this->quiz->id;
    }
    public function getTitle(): string
    {
        return $this->quiz->title;
    }
    public function getCategoryId(): int
    {
        return $this->quiz->category_id;
    }
    public function getDescription(): string
    {
        return $this->quiz->description;
    }
    public function getStartDate() : string
    {
        return $this->quiz->start_date;
    }
    public function getDuration(): string 
    {
         return $this->quiz->duration;
    }
    public function getIsACtive(): bool 
    {
         return $this->quiz->is_active;
    }
}
