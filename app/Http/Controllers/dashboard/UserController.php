<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// tables
use App\Models\Group;
use App\Models\Sallers;
use App\Models\StoreInfo;
use App\Models\StoreType;
use App\Models\Users;


class UserController extends Controller
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

    }


    // to get data of all user from database
    if($req->action == 'getData' && $get){
      return response()->json( $this->getData() );

    // get help info for user
    }elseif($req->action == 'getHelpInfo'){
      return response()->json( $this->getHelpInfo($req) );

    // add data of user in database
    } elseif($req->action == 'add' && $add){
      return response()->json( $this->add($req) );

    // to update user
    } elseif($req->action == 'update' && $update){
      return response()->json( $this->update($req) );

        // to updat group
    } elseif($req->action == 'updateStatus' && $update){
      return response()->json( $this->updateStatus($req));

      // to delet user
    } elseif($req->action == 'delete' && $delete){
        return response()->json( $this->delete($req) );

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }

  // **********
  //  function to get User data
  // **********
  public function getData($method='',$id=''){

    if($method == 'all'){
      $user = Users::get();

    }elseif($method == 'id'){
      $user = Users::where('id', '=', $id)->get();

    }else{
      $user = Users::orderby("id", "DESC")->paginate(20);
      //join('group', 'group.id', '=', 'users.group_id')->get();
    }

    foreach($user as $elem){
      $elem->group;
      $elem->store_info;
    }

    return $user;
  }


  // **********
  //  function to get info help for User
  // **********
  public function getHelpInfo($data){

    $groups = Group::select('id', 'name')->get();
    $store_type = StoreType::get();


    return ['groups' => $groups, 'store_type' => $store_type];
  }



  // ************
  // function to add User
  // ************
  public function add($data) {

    $validator = Validator::make($data->all(), [
      'name'    => 'required|min:3|max:40|string',
      'password' => 'required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])([a-zA-Z0-9.?!@#$%^&*\-+=_,.?;:\'\\"\/]+)$/',
      'mobile'  => 'required|unique:users,mobile|integer|digits:9|regex: /^([0-9]+())$/',
      'email'   => 'nullable|unique:users,email|regex:/^[\w\.]+@([\w-]+\.)+\w{2,4}$/',
      'group_id'=> 'integer|exists:group,id|not_in:0,1',
      'rank'    => 'nullable|integer',
      'status'  => 'nullable|integer|max:1',
      'store_info.*.name'   => 'required|min:3|max:30|string',
      'store_info.*.store_type_id'=> 'required|integer|exists:store_type,id',
      'store_info.*.address'=> 'required|min:4|max:50|string',

    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }


    $user = new Users();

    $user->group_id = $data->group_id;
    $user->name = $data->name;
    $user->mobile = $data->mobile;
    if (!$data->email) {
      unset($data['email']);
    }else{
      $user->email = $data->email;
    }
    $user->password = bcrypt($data->password);
    $user->image = $data->image;
    $user->rank = $data->rank;
    $user->status= $data->status;

    $user->save();

    foreach($data['store_info'] as $store){
      $store_info = new StoreInfo();

      $store_info->user_id = $user->id;

      $store_info->name = $store['name'];
      $store_info->store_type_id = $store['store_type_id'];
      $store_info->address = $store['address'];

      $store_info->save();
    }

    return ['status'=>'done', 'data'=> $user];
  }



  // **********
  //  function to get Group data
  // **********
  public function updateStatus($data){

    $saller = Users::where('id', '=', $data->id)
                    ->update(['status' => $data->status]);

    if($saller > 0){
      return ['status' => 'done', 'data' => $this->getData($data)];

    }else{
      return ['status' => 'null'];
    }
  }



  // *********
  // function to update user
  // *********
  public function update($data){

    $validator = Validator::make($data->all(), [
      'id'      => 'integer|required|exists:users,id|max:20|not_in:0',
      'name'    => 'required|min:3|max:40|string',
      'password'=> 'nullable|min:6|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])([a-zA-Z0-9.?!@#$%^&*\-+=_,.?;:\'\\"\/]+)$/',
      'mobile'  => ['required', 'digits:9', 'integer', 'regex: /^([0-9]+)$/',
                    Rule::unique('users', 'mobile')->ignore($data->id, 'id'),],

      'email'   => ['nullable', 'regex:/^[\w\.]+@([\w-]+\.)+\w{2,4}$/',
                    Rule::unique('users', 'mobile')->ignore($data->id, 'id'),],

      'group_id'=> 'integer|exists:group,id|not_in:0,1',
      'rank'    => 'integer',
      'status'  => 'integer|required|max:1',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $inc = [
      'name' => $data->name,
      'mobile' => $data->mobile,
      'email'   => $data->email,
      'group_id'=> $data->group_id,
      'rank'    => $data->rank,
      'status'  => $data->status,
    ];
    if($data->password){
      $inc['password'] = bcrypt($data->password);
    }

    Users::where('id', $data->id)
              ->update($inc);

    return ['status'=>'done'];
  }



  // ***********
  // function delete User
  // ***********
  public function delete($data){

    $validator = Validator::make($data->all(), [
      'id' => 'required|integer|exists:users,id|not_in:1',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $user = Users::where('id', $data->id)->delete();

    if($user){
      return ['status'=> 'done'];

    }else{
      return ['status'=> 'error', 'data' => $data];
    }

  }

}
