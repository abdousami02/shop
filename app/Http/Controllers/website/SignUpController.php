<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\StoreInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\StoreType;
use App\Models\Users;

class SignUpController extends Controller
{
  public function default(Request $req){

    // return response()->json( $req->action);
    $user = auth()->user();
    // to getDat from  database
    if($req->action == 'getHelpInfo' ){
      return response()->json( $this->getHelpInfo() );

    // to add Order
    } elseif($req->action == 'checkData'){
    return response()->json( $this->check($req->info) );

      // to updat Order
    } elseif($req->action == 'register'){
    return response()->json( $this->register($req->info) );

    // to delet Order
    } elseif($req->action == 'delete'){
      return response()->json( $this->delete($req) );

    } else {
    return response()->json(['status'=> 'permition']);
    }
  }



  public function getHelpInfo(){

    $store = StoreType::where('status', '!=', 0)->orderby("rank", "DESC")->get();
    return $store;
  }


  public function check($data, $register=""){

    $data['mobile'] = (int) ($data['pre_mobile'].$data['mobile']);

    $verify = (array) $data;

    $valid = [
      'name'      => 'required|string|min:3|max:20',
      'store_name'=> 'required|string|min:3|max:20',
      'pre_mobile'=> 'required|integer|in:5,6,7',
      'mobile'    => 'required|integer|unique:users,mobile|digits:9|regex: /^([0-9]+())$/',
      'email'     => 'nullable|unique:users,email|regex:/^[\w\.]+@([\w-]+\.)+\w{2,4}$/',
      'store_type'=> 'required|integer|exists:store_type,id',
      'wilaya'    => 'nullable|string|min:4|max:20',
      'address'   => 'required|string|min:5|max:30',
    ];

    if($register == true){
      $valid['password'] = 'required|min:6|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])([a-zA-Z0-9.?!@#$%^&*\-+=_,.?;:\'\\"\/]+)$/';
    }
    $validator = Validator::make($verify, $valid);


    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    return ['status' => 'done'];
  }



  public function register($data){

    $valid = $this->check($data, true);


    if($valid['status'] != 'done'){
      return $valid;
    }
    $data['mobile'] = (int) ($data['pre_mobile'].$data['mobile']);
    // return $data;

    $data = (object) $data;

      $user = new Users();

      $user->name     = $data->name;
      $user->mobile   = $data->mobile;
      $user->email    = isset($data->email) ? $data->email : null;
      $user->password = bcrypt($data->password);

      $user->save();

      $store = new StoreInfo();

      $store->user_id = $user->id;
      $store->name    = $data->store_name;
      $store->store_type_id = $data->store_type;
      $store->wilaya  = isset($data->wilaya) ? $data->wilaya : '';
      $store->address = $data->address;
      $store->mobile  = $data->mobile;

      $store->save();

      return ["status" => 'done', 'data' => $user];

  }

}
