<?php

namespace App\Http\Controllers\saller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Saller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
  public function default(Request $req){

    // if have permition
    $user = auth()->user();

    $saller = Saller::where('user_id', '=', $user->id)->first();

    if(!$saller){
      return ['status' => 'error'];
    }


    if($user['group_id'] > 4 && $user['status'] != 0){
      return response()->json(['status'=> 'permition']);
    }

    // to getDat from  database
    if($req->action == 'getData'){
      return response()->json( $this->getData($req, $saller) );

      // get Then new order
    } elseif($req->action == 'getNew'){
      return response()->json( $this->getNew($req, $saller) );


    }elseif($req->action == 'getDataPrint'){
      return response()->json( $this->getDataPrint($req) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' ){
        return response()->json( $this->getHelpInfo($req) );

      }elseif($req->action == 'search'){
        return response()->json( $this->search($req) );

      // to add Order
    } elseif($req->action == 'add'){
      return response()->json( $this->add($req) );

     // to updat Order
    } elseif($req->action == 'update'){
      return response()->json( $this->update($req) );


    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  public function getData($data, $saller){


    if($data->id){
      $order = Order::where([['saller_id', '=', $saller->id], ['id', '=', $data->id]])->first();

    }else{
      $order = Order::where([['saller_id', '=', $saller->id],['status', '>', 1]])
                      ->orderby("to_saller_at", "DESC")->paginate(20);
    }


    return $order;
  }


  public function getNew($data, $saller){

    $order = Order::where([['saller_id', '=', $saller->id],['status', '>', 1],['show_saller', '=', 0]])
                  ->where('updated_at', '>', $data->last)
                  ->orderby("to_saller_at", "DESC")->get();

    if(count($order) > 0){
      return ['status' => 'done', 'data' => $order];

    }else{
      return ['status' => 'none', $data->last ];
    }
  }


}
