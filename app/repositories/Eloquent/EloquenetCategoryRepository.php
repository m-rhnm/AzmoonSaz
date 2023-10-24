<?php
namespace App\repositories\Eloquent;


use App\Models\Category;
use App\Entities\Category\CategoryEloquentEntity;
use App\repositories\Eloquent\EloquentBaseRepository;
use App\repositories\Contracts\CategoryRepositoryInterface;


class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;

    public function create(array $data){
        $createCategory = parent::create($data);
        return new CategoryEloquentEntity($createCategory);
    }
    
}