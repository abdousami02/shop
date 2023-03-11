<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Order;

class OrderController extends Controller
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
              $get= true; $update= false; $add= false; $delete= false;
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
        return $this->getData($req);

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' && $get ){
        return $this->getHelpInfo($req);

      // to add group
    } elseif($req->action == 'add' && $add){
      return $this->add($req);

        // to updat group
    } elseif($req->action == 'update' && $update){
      return $this->update($req);


      // to delet group
    } elseif($req->action == 'delete' && $delete){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  // **********
  //  function to get Group data
  // **********
  public function getData($data){

    $order = Order::paginate();    // ::get()

    foreach($order as $elem){
      $elem->user;
      $elem->saller;
      $elem->store_info;
    }

    return response()->json(['data'=> $order, 'action'=> $data]);
  }


  // **********
  //  function to get info help for product
  // **********
  public function getHelpInfo($data){

    $cat     = '';//Categorie::get();
    $famille = '';//Famille::get();


    return response()->json(['categories'=> $cat, 'familles'=> $famille]);
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

    $group = new Order();

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

    $group = Order::where('id', $data->id)
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
    $group = Order::where('id', $data->id)->delete();

    if($group){
      return response()->json(['status'=> 'done']);

    }else{
      return response()->json(['status'=> 'error', 'data' => $data]);
    }


  }
}
