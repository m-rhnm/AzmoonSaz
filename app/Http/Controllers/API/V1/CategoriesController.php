<?php
namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Contracts\APIController;
use App\repositories\Contracts\CategoryRepositoryInterface;



class CategoriesController extends APIController
{
    public function __construct(private CategoryRepositoryInterface $CategoryRepository)
    {  
    }    
    public function store(Request $request)
    {
       $this->validate($request,
        [
            'name' => 'required|string',  
            'slug'=>'required|string'
        ]);

           $newCategory = $this->CategoryRepository->create([
            'name' => $request->name,  
            'slug'=>$request->slug
        ]);
        return $this->respondCreate('category created successfully',
        [
            'name' => $newCategory->name,  
            'slug'=> $newCategory->slug
        ]);
    }
}