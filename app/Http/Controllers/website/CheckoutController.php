<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\StoreInfo;
use Illuminate\Support\Facades\Date;

class CheckoutController extends Controller
{
  public function default(Request $req){

    // return response()->json( $req->action);
    $user = auth()->user();
    // to getDat from  database
    if($req->action == 'getStoreInfo' ){
      return response()->json( $this->getStoreInfo($user) );

    }elseif($req->action == 'getDataPrint' ){
    return response()->json( $this->getDataPrint($req) );

    // to add Order
    } elseif($req->action == 'sendOrder'){
    return response()->json( $this->sendOrder($req, $user) );

      // to updat Order
    } elseif($req->action == 'update'){
    return response()->json( $this->update($req) );

    // to delet Order
    } elseif($req->action == 'delete'){
      return response()->json( $this->delete($req) );

    } else {
    return response()->json(['status'=> 'permition']);
    }

 }


 public function getStoreInfo($user){
  if($user->id){

    $store = StoreInfo::where('user_id', '=', $user->id)->get();

    if(count($store) <= 0){
      return ['status' => 'empty'];
    }
    return ['status' => 'done', 'data' => $store];

  }
 }


 public function sendOrder($data, $user){


  $store = StoreInfo::where([['id', '=', $data->store_id], ['user_id', '=', $user->id]])->get();

  if(count($store) == 0){
    return ['status' => 'error', 'message' => 'store info not found'];

  }else{
    $date = date("Y-m-d H:i:s");
    $order = Order::where([['id', '=', $data->order_id], ['user_id', '=', $user->id]])
                    ->update([
                      'store_id'    => $data->store_id,
                      'status'      => 2,
                      'show_admin'  => 0,
                      'created_at'  => $date ]);

  if($order > 0){
    return ['status' => 'done', 'data' => $date];

  }else{
    return ['status' => 'error', 'message' => 'order not found'];
  }

  }

 }

}
