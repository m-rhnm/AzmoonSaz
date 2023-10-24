<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Contracts\APIController;
use App\repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends APIController
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
        
    }
    public function index(Request $request)
    {
        $this->validate($request,[
            'search'=>'nullable|string',
            'page'=>'required|numeric',
            'pagesize'=>'nullable|numeric',
        ]);
       $users = $this->userRepository->paginate($request->search,$request->page, $request->pagesize ?? 20);
        return $this->respondSuccess('users',$users);
    }
    public function store(Request $request)
    {
       $this->validate($request,
        [
            'fullName' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|',
            'password' => 'required|'
        ]);

           $newUser = $this->userRepository->create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => app('hash')->make($request->password),
        ]);
        return $this->respondCreate('user created successfully',
        [
            'fullName' => $newUser->getfullName(),
            'email' => $newUser->getEmail(),
            'mobile' => $newUser->getMobile(),
            'password' => $newUser->getPassword()
        ]);
    }
    public function updateInfo(Request $request)
    {
      $this->validate($request,[
            'id'=>'required|string',
            'fullName' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string',
        ]);
            $user =  $this->userRepository->update($request->id,
        [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

            return $this->respondSuccess('user updated successfully',
        [
            'fullName' => $user->getfullName(),
            'email' => $user->getEmail(),
            'mobile' => $user->getMobile(),
        ]);
    }
    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'id'=>'required|string',
            'password'=>'min:6|required_with:password_repeat|same:password_repeat',
            'password_repeat'=>'min:6',
        ]);

        try{
            $user =  $this->userRepository->update($request->id,
            [
                'password' => app('hash')->make($request->password),
            ]);
    
           
        }catch(\Exception $e){
            return $this->respondInternalError('faild to update password ',[]);
        }
        return $this->respondSuccess('user updated_password successfully',
        [
            'fullName' => $user->getfullName(),
            'email' => $user->getEmail(),
            'mobile' => $user->getMobile(),
        ]);
    }
    public function remove(Request $request)
    {
        $this->validate($request,[
            'id'=>'required',
        ]);
        if( !$this->userRepository->find($request->id)){
            return $this->respondNotFound('not found this user',[]);
        }
           if($this->userRepository->delete($request->id)){
            return $this->respondInternalError('there is a error to delete,please try again',[]);
           }
            return $this->respondSuccess('user removed successfully',[]);
    }
  
}