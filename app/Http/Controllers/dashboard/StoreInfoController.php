<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class StoreInfoController extends Controller{




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
              $get= true; $update= false; $add= true; $delete= false;
              break;

        case 3 :
              $get= false; $update= false; $add= false; $delete= false;
              break;

        default: break;
      }
    }else{
      $get = false; $add= false; $update= false; $delete= false;
    }


    if($req->action == 'add_store' && $add){
      return $this->add($req);

    // to update store of user from DataBase
    } elseif($req->action == 'update_store' && $update){
      return $this->update($req);


      // for getData from database
    } elseif($req->action == 'delete_store' && $delete){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  // ************
  // function to add Store
  // ***************
  public function add(Request $data){

    $validator = Validator::make($data->all(), [
      'user_id'   => 'required|integer|exists:users,id',
      'name'      =>  'required|string|min:3',
      'type_id'   =>  'required|integer|exists:store_type,id',
      'address'   =>  'required|string|min:4',
    ]);

    if($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=> $validator->errors()]);
    }


    $info = new StoreInfo();

    $info->user_id =  $data->user_id;
    $info->name =     $data->name;
    $info->type_id =  $data->type_id;
    $info->address =  $data->address;

    $info->save();

    return response()->json(['status'=> 'done']);
  }

  // *********
  // function to update Store
  // *********
  public function update($data){

    $validator = Validator::make($data->all(), [
      'id'        => 'required|integer|exists:store_info,id',
      'user_id'   => 'required|integer|exists:users,id',
      'name'      =>  'required|string|min:3',
      'type_id'   =>  'required|integer|exists:store_type,id',
      'address'   =>  'required|string|min:4',
    ]);

    if($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=> $validator->errors()]);
    }

    StoreInfo::where('id', $data->id)
              ->update([
                'name'    => $data->name,
                'type_id' => $data->type_id,
                'address'  => $data->address,
              ]);    //find element

    return response()->json(['status'=>'done']);
  }


  // ****************
  // function to delete Store
  // **************
  public function delete($data){

    $validator = Validator::make($data->all(), [
      'id'        => 'required|integer|exists:store_info,id',
      'user_id'   => 'required|integer|exists:users,id',
    ]);

    if($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=> $validator->errors()]);
    }

    $store = StoreInfo::where('id', $data->id)->delete();

    if($store){
      return response()->json(['status'=> 'deleted']);

    }else{
      return response()->json(['status'=> 'error', 'data' => $data]);
    }


  }

}
