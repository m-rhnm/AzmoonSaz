<?php 

namespace App\Entities\Category;

use App\Entities\User\CategoryEntity;
use App\Models\Category;

class CategoryEloquentEntity implements CategoryEntity
{
    private $category;
    public function __construct(Category|null $category )
    {
        $this->category = $category;
    }
    public function getId(): int
    {
        return $this->category->id;
    }
    public function getName(): string
    {
        return $this->category->name;
    }
    public function getSlug(): string
    {
        return $this->category->slug;
    }
}
