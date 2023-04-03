<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SettingOrigin;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
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
              $get= true; $update= false; $add= false; $delete= false;
              break;

        case 3 :
              $get= true; $update= false; $add= false; $delete= false;
              break;

        default: break;
      }

    }else{
      $get = false; $add= false; $update= false; $delete= false;
    }


    // for get Dat from DataBase
      // to add Categorie
    if($req->action == 'getOrigin' && $add){
      return $this->getOrigin($req);

    }elseif($req->action == 'getSetting' && $get ){
        return $this->getSetting($req);

      // to add Categorie
    } elseif($req->action == 'setSetting' && $add){
      return $this->setSetting($req);

        // to updat Categorie
    } elseif($req->action == 'update' && $update){
      return $this->update($req);


      // to delete Categorie
    } elseif($req->action == 'delete' && $delete){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }

  }

  // get setting Origin
  public function getOrigin(){

    $setting = SettingOrigin::get();

    return ['status' => 'done', 'data'=> $setting];
  }

  public function getSetting(){

    $set = Setting::where('user_id', '=', 0)->get();
    return ['status' => 'done', 'data'=> $set];
  }


  // set Setting
  public function setSetting($data){

    // return $data->data;
    $opt = [['section', '=', $data->section]];

    foreach($data->data as $elem => $value){
      $opt[] = ['param', '=', $elem];
      $v = Setting::where($opt)->update(['value' => $value]);
      return [$v, $opt];
    }

  }
}
