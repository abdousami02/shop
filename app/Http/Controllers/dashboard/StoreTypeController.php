<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\StoreType;

class StoreTypeController extends Controller
{

  public function default(Request $req){

    // if have permition
    $user = auth()->user();

    if($user['group_id'] <= 3 && $user['status'] != 0){

      switch($user['group_id']){
        case 0 :
          $get= true; $update= true; $add= true; $delete= false;
          break;

        case 1 :
              $get= true; $update= false; $add= true; $delete= false;
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
    if($req->action == 'getData' && $get ){
        return $this->getData($req);

      // to add Store Type
    } elseif($req->action == 'add' && $add){
      return $this->add($req);

        // to updat Store Type
    } elseif($req->action == 'update' && $update){
      return $this->update($req);


      // to delete Store Type
    } elseif($req->action == 'delete' && $delete){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }

  }


  // to get Store Types from database
  public function getData(Request $data){

    $store = StoreType::paginate(20);

    return response()->json(['data' => $store]);
  }


  // to add Store Type
  public function add(Request $data){

    $validator = Validator::make($data->all(), [
      'name'    => 'required|string|unique:store_type,name|min:3|max:15',
      'status'  => 'nullable|integer|max:1',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    $store = new StoreType();

    $store->name = $data->name;
    $store->status = $data->status || 0;

    $store->save();

    return response()->json(['status' => 'done']);

  }


  // to update Store Type
  public function update(Request $data){

    $validator = Validator::make($data->all(), [
      'id'      => 'required|exists:store_type,id',
      'name'    => ['required', 'string', 'min:3','max:30',
                    Rule::unique('store_type')->ignore($data->id, 'id'),],

      'status'  => 'integer|max:1',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    StoreType::where('id', $data->id)
        ->update(['name'=> $data->name, 'status'=> $data->status]);

    return response()->json(['status'=>'done']);

  }

  // to delete
  public function delete($data){

    $validator = Validator::make($data->all(), [
      'id'      => 'required|exists:store_type,id',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    $cat = StoreType::where('id', $data->id)->delete();

    if($cat){
      return response()->json(['status'=> 'done']);

    }else{
      return response()->json(['status'=> 'error', 'data' => $data]);
    }

  }

}
