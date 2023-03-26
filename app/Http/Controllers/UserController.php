<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Users;
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

  public function setLogin($user){
    $date = date('Y-m-d H:i:s');
    $user = Users::where('id', '=', $user->id)
                  ->update(['last_login' => $date]);

  }


}
