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
    public function test_ensure_we_can_update_a_category(){
        $category = $this->createCategories()[0];
        $categoryData = 
        [
            'id' => (string)$category->getId(),
            'name' => (string)$category->getName().'updated',  
            'slug'=>(string)$category->getSlug().'updated',
        ];
        $response = $this->call('put','api/v1/categories',$categoryData);
        $this->assertEquals(200, $response->getStatusCode());
        $this->seeInDatabase('categories',$categoryData);
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[
                'id',
                'name',
                'slug'
            ],
            ]);
    }
    public function test_ensure_we_can_get_categories()
    {
        $this->createCategories(30);
        $pagesize = 4;
        $response = $this->call('get','api/v1/categories',
        [
        'page'=>1,
        'pagesize'=>$pagesize,
        ]);
        $data= json_decode($response->getContent(),true);
        $this->assertEquals($pagesize,count($data['data']));
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data',
        ]);
     
    }

    public function test_ensure_we_can_get_filtered_categories()
    {
       
        $pagesize = 5;
        $categorySlug = 'new-category';
        $response = $this->call('get','api/v1/categories',
        [
        'search'=>$categorySlug,
        'page'=>1,
        'pagesize'=>$pagesize,
        ]);
        $data= json_decode($response->getContent(),true);
        foreach($data['data'] as $user)
        {
            $this->assertEquals($user['slug'],$categorySlug);            
        }       
        $this->assertEquals(200,$response->status());
        $this->seeJsonStructure([
            'success' ,
            'message' ,
            'data'=>[],
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