<?php

namespace App\Entities\Quiz;

interface QuizEntity
{
    public function getId(): int;
    public function getTitle(): string;
    public function getCategoryId(): int;
    public function getDescription(): string;
    public function getStartDate():string;
    public function getDuration():string;
    public function getIsACtive():bool;


}