<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
      $this->userRepository  = new UserRepository();
    }
  
    public function create(Request $request)
    {
      $data     = $request->all();
      $user     = $this->userRepository->insertUser($data);
      $response = new UserResource($user);
  
      return $response;
    } 
}
