<?php 

namespace App\Http\Controllers\API\Contracts;

use App\Http\Controllers\Controller;


class APIController extends Controller
{
    protected $statusCode;
    public function respondSuccess(string $message,array $data)
    {
        return $this->setStatusCode(200)->responsd($message,true,$data);
    }
    public function respondCreate(string $message,array $data)
    {
        return $this->setStatusCode(201)->responsd($message,true,$data);
    }
    public function respondNotFound(string $message,array $data)
    {
        return $this->setStatusCode(404)->responsd($message,true);
    }
    public function respondInternalError(string $message,array $data)
    {
        return $this->setStatusCode(500)->responsd($message);
    }
    private function responsd (string $message = '',bool $isSuccess = false ,array $data = null)
    {
        $responseData = [
            'success'=>$isSuccess,
            'message'=>$message,
            'data'=> $data
        ] ;
        return response()->json($responseData)->setStatusCode($this->getStatuscode());
    }
    private function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    public function getStatuscode()
    {
       return $this->statusCode;
    }
}