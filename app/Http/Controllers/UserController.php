<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

  public function register(Request $req){

    $user = new User();

    $user->name = $req->name;
    $user->email = $req->email;
    $user->password = bcrypt($req->passowrd);

    $user->save();
  }


}
