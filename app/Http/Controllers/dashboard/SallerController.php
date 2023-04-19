<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\OrderDetailSaller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Saller;
use App\Models\Users;

class SallerController extends Controller
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
              $get= false; $update= false; $add= false; $delete= false;
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
        return response()->json( $this->getData($req));

      // to add group
    } elseif($req->action == 'add' && $add){
      return response()->json( $this->add($req));

        // to updat group
    } elseif($req->action == 'update' && $update){
      return response()->json( $this->update($req));

      // to updat group
    } elseif($req->action == 'updateStatus' && $update){
      return response()->json( $this->updateStatus($req));

      // to delet group
    } elseif($req->action == 'historyPrice' && $get){
        return response()->json( $this->history($req));

    } else {
      return response()->json(['status'=> 'permition7']);
    }
  }


  // **********
  //  function to get Group data
  // **********
  public function getData($data){

    if($data->id){
      $saller = Saller::where('id', '=', $data->id)->with(['user'])->first();

    }else{
      $saller = Saller::with(['user'])->paginate(20);    // ::get()
    }

    return ['data'=> $saller, 'status'=> 'done'];
  }


  // **********
  //  function to get Group data
  // **********
  public function add(){

    return ['status' => 'error', "message" => 'not set'];
  }



  // **********
  //  function to get Group data
  // **********
  public function update($data){


    $validator = Validator::make($data->all(), [
      'id'      => 'integer|exists:sallers,id',
      'name'    => 'required|unique:group,name|min:3|max:35|string',
      'mobile'  => ['required', 'digits:9', 'integer', 'regex: /^([0-9]+)$/',
                    Rule::unique('sallers', 'mobile')->ignore($data->id, 'id')],
      'type'    => 'required|string|max:20',
      'address' => 'required|string|min:5|max:50',
      'status'  => 'nullable|integer|in:0,1',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $saller = Saller::where('id', '=', $data->id)
                    ->update(['name' => $data->name,
                              'mobile'  => $data->mobile,
                              'type'    => $data->type,
                              'address' => $data->address,
                              'status'  => $data->status, ]);

    return ['status' => 'done' ];

  }

  // **********
  //  function to get Group data
  // **********
  public function updateStatus($data){

    $saller = Saller::where('id', '=', $data->id);

    $user = $saller->first();

    $count = $saller->update(['status' => $data->status]);

    Users::where('id', '=', $user->user_id)
        ->update(['status' => $data->status]);



    if($count > 0){
      return $this->getData($data);

    }else{
      return ['status' => 'null'];
    }
  }



  // **********
  //  function to get Group data
  // **********
  public function history($data){

    if($data->product_id){
      $price = OrderDetailSaller::where('product_id', '=', $data->product_id)
                                ->select('saller_id', 'order_id', 'price_buy', 'product_id')
                                ->with('saller', 'order')->get();


      if(count($price) > 0){
        return [ 'status' => 'done', 'data' => $price];

      }else{
        return ['status' => 'none', 'message' => 'not have history'];
      }
    }

  }

}
