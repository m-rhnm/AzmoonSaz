<?php

namespace App\Entities\Question;

interface QuestionEntity
{
    public function getId(): int;
    public function getTitle(): string;
    public function getQuizId(): int;
    public function getOption(): array;
    public function getScore(): float;
    public function getIsActive(): int;


}