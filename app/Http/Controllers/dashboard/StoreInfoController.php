<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class StoreInfoController extends Controller{


  public function default(Request $req){

    if($req->action == 'add_store'){
      return $this->add($req);

    // to update store of user from DataBase
    } elseif($req->action == 'update_store' ){
      return $this->update($req);


      // for getData from database
    } elseif($req->action == 'delete_store'){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'undifined in store controller']);
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
