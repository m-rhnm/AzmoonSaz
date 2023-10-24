<?php
namespace App\Entities\User;

interface CategoryEntity
{
    public function getId(): int;
    public function getName(): string;
    public function getSlug(): string;
}