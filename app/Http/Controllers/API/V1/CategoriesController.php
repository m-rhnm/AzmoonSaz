<?php
namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Contracts\APIController;
use App\repositories\Contracts\CategoryRepositoryInterface;



class CategoriesController extends APIController
{
   
        public function __construct(private CategoryRepositoryInterface $categoryRepository)
        {  
        }    
        public function store(Request $request)
        {
        $this->validate($request,
            [
                'name' => 'required|string|min:2|max:255',  
                'slug'=>'required|string|min:2|max:255'
            ]);

            $newCategory = $this->categoryRepository->create([
                'name' => $request->name,  
                'slug'=>$request->slug
            ]);
            return $this->respondCreate('category created successfully',
            [
                'name' => $newCategory->getName(),  
                'slug'=> $newCategory->getSlug()
            ]);
        }
        public function remove(Request $request)
        {
            $this->validate($request,[
                'id'=>'required|numeric',
            ]);
            if(!$this->categoryRepository->find($request->id)){
                return $this->respondNotFound('not found this category',[]);
            }
            if(!$this->categoryRepository->delete($request->id)){
                return $this->respondInternalError('faild to remove category,please try again',[]);
            }
                return $this->respondSuccess('category removed successfully',[]);
        }
        public function updateInfo(Request $request)
        {
        $this->validate($request,[
                'id'=>'required|string',
                'name' => 'required|string|min:2|max:255',  
                'slug'=>'required|string|min:2|max:255'
                
            ]);
            if(!$this->categoryRepository->find($request->id)){
                return $this->respondNotFound('not found this category',[]);
            }
                $user =  $this->categoryRepository->update($request->id,
            [
                'id'=>$request->id,
                'name' => $request->name,  
                'slug'=>$request->slug
            ]);

                return $this->respondSuccess('category updated successfully',
            [
                'id'=>$user->getId(),
                'name' => $user->getName(),  
                'slug'=>$user->getSlug()
            ]);
        }
        public function index(Request $request)
        {
            $this->validate($request,
            [
                'search'=>'nullable|string',
                'page'=>'required|numeric',
                'pagesize'=>'nullable|numeric',
            ]);
           $categories = $this->categoryRepository->paginate($request->search,$request->page, $request->pagesize ?? 20,['name','slug']);
            return $this->respondSuccess('ctegories',$categories);
        }
}