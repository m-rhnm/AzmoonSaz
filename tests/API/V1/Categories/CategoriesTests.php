<?php

namespace Tests\API\V1\Categories;

use Tests\TestCase;



class CtegoriesTests extends TestCase
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
            ]
            ]);
    } 
}