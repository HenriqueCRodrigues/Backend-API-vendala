<?php 

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
  public function insertUser($input)
  {
    $user = User::create([
      'email'    => $input['email'],
      'name'     => $input['name'],
      'password' => Hash::make($input['password'])
    ]);

    return $user;
  }
}