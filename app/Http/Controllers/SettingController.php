<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
  public function default(Request $req){

    $user = auth()->user();

    // to getDat from  database
    if($req->action == 'getSetting' ){
      return response()->json( $this->getSetting($req, $user) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo'){
        return $this->getHelpInfo($req);

    }elseif($req->action == 'search'){
      return $this->search($req);

      // to add group
    } elseif($req->action == 'add'){
      return $this->add($req);

        // to updat group
    } elseif($req->action == 'update'){
      return $this->update($req);


      // to delet group
    } elseif($req->action == 'delete'){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  public function getSetting($data, $user){

    if($user->id){

      $arg = [['user_id', '=', $user->id], ['param', '=', $data->page]];

      $setting = Setting::where($arg)->select('param', 'value')->get();

      $param = [];
      foreach($setting as $elem){

        $param[$elem['param']] = $elem['value'] == 1 ? true : false;
      }

      return $param;
    }

  }
}
