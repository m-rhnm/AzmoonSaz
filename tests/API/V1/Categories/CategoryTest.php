<?php

namespace Tests\API\V1\Categories;

use App\repositories\Contracts\CategoryRepositoryInterface;
use Tests\TestCase;



class CategoryTest extends TestCase
{
    public function setUp(): void{
        parent::setUp();
        $this->artisan('migrate:refresh');
    }
    
    
    public function test_ensure_we_can_create_a_new_category(){
        $newCategoryData = 
        [
            'name' => 'category 75',  
            'slug'=>'category 75'
        ];
        $response = $this->call('POST','api/v1/categories',$newCategoryData);
        $this->assertEquals(201, $response->getStatusCode());
        $this->seeInDatabase('categories',$newCategoryData);
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[
                'name',
                'slug'
            ],
            ]);
    } 

    public function test_ensure_we_can_delete_a_category(){
        $category = $this->createCategories()[0];
        $response = $this->call('delete','api/v1/categories',[
            'id'=>(string)$category->getId(),
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data',
        ]);
    }

    private function createCategories(int $count=1):array{
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
}