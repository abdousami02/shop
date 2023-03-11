<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Group;


class GroupController extends Controller
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
              $get= true; $update= false; $add= true; $delete= false;
              break;

        case 2 :
              $get= false; $update= false; $add= false; $delete= false;
              break;

        case 3 :
              $get= false; $update= false; $add= false; $delete= false;
              break;

        default: break;
      }

    }else{
      $get = false; $add= false; $update= false; $delete= false;
    }


    // return response()->json(['data'=> $id ]);



    // to getDat from  database
    if($req->action == 'getData' && $get ){
      // return response()->json(['status'=> $req->action]);
        return $this->getData($req);

      // to add group
    } elseif($req->action == 'add' && $add){
      // return response()->json(['action'=> $req->action]);
      return $this->add($req);

        // to updat group
    } elseif($req->action == 'update' && $update){
      // return response()->json(['action'=> $req->action]);
      return $this->update($req);


      // to delet group
    } elseif($req->action == 'delete' && $delete){
      // return response()->json(['status'=> $req->action]);
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  // **********
  //  function to get Group data
  // **********
  public function getData($data){

    $group = Group::paginate(20);    // ::get()



    return response()->json(['data'=> $group, 'action'=> $data]);
  }


  // ************
  // function to add Group
  // ************
  public function add($data) {

    $validator = Validator::make($data->all(), [
      'id' => 'integer|unique:group,id|required|max:20',
      'name' => 'required|unique:group,name|min:3|max:10|string',
      'status' => 'nullable|integer|max:1',
    ]);

    if($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=> $validator->errors()]);
    }

    $group = new Group();

    $group->id = $data->id;
    $group->name = $data->name;
    $group->status = $data->status;

    $group->save();

    return response()->json(['status'=>'done']);
  }


  // *********
  // function to update Group
  // *********
  public function update($data){

    $validator = Validator::make($data->all(), [
      'id'   => 'integer|exists:group,id',
      'name' => ['required', 'min:3', 'max:10', 'string',
                  Rule::unique('group', 'name')->ignore($data->id, 'id'),],
      'status' => 'integer|max:1',
    ]);


    if($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=> $validator->errors()]);
    }

    $group = Group::where('id', $data->id)
                    ->update(['name'=> $data->name, 'status'=> $data->status]);    //find element

    // $group->name = $data->name;
    // $group->status = $data->status;

    // $group->save();

    return response()->json(['status'=>'done']);
  }

  // ***********
  // function delete group
  // ***********
  public function delete($data){

    $validator = Validator::make($data->all(), [
      'id' => 'integer|required|exists:group,id|not_in:1,2,3',
    ]);

    if($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=> $validator->errors()]);
    }
    $group = Group::where('id', $data->id)->delete();

    if($group){
      return response()->json(['status'=> 'done']);

    }else{
      return response()->json(['status'=> 'error', 'data' => $data]);
    }


  }
}
