<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


use App\Models\ProductGoute;

class ProductGouteController extends Controller
{

  public function default(Request $req){

    // if have permition
    $user = auth()->user();

    if($user['group_id'] <= 3 && $user['status'] != 0){

      switch($user['group_id']){
        case 0 :
              $get= true; $update= true; $add= true; $delete= true;
              break;

        case 1 :
              $get= true; $update= true; $add= true; $delete= false;
              break;

        case 2 :
              $get= true; $update= true; $add= true; $delete= false;
              break;

        case 3 :
              $get= false; $update= false; $add= false; $delete= false;
              break;

        default: break;
      }

    }else{
      $get = false; $add= false; $update= false; $delete= false;
    }


    // to getDat from  database
    if($req->action == 'getData' && $get ){
        return $this->getData($req);

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' && $get ){
        return $this->getHelpInfo($req);

      // to add group
    } elseif($req->action == 'add' && $add){
      // return $this->add($req);

        // to updat group
    } elseif($req->action == 'update' && $update){
      // return $this->update($req);


      // to delet group
    } elseif($req->action == 'delete' && $delete){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }





}
