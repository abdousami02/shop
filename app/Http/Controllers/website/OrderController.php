<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailGoute;

class OrderController extends Controller
{

  public function default(Request $req){

    // return response()->json( $req->action);
    $user = auth()->user();
    // to getDat from  database
    if($req->action == 'getData' ){
      return response()->json( $this->getData($req->order_id) );

    // }elseif($req->action == 'getDataPrint' ){
    // return response()->json( $this->getDataPrint($req) );

    // to help Info from  database
    }elseif($req->action == 'setOrderLocal' ){
      return response()->json( $this->setLocal($req) );

    // }elseif($req->action == 'search'){
    //   return response()->json( $this->search($req) );

    // to add Order
    } elseif($req->action == 'add'){
    return response()->json( $this->add($req, $user) );

      // to updat Order
    // } elseif($req->action == 'update'){
    // return response()->json( $this->update($req) );

    // to delet Order
    } elseif($req->action == 'delete'){
      return response()->json( $this->delete($req) );

    } else {
    return response()->json(['status'=> 'permition']);
    }

 }


  // **********
  //  function to get Order data
  // **********
  public function getData($id=''){
    $user = auth()->user();

    if($id){
      $order = Order::where('user_id', '=', $user->id)
                    ->where('id', $id)->get() ;

    }else{
      $order = Order::where('user_id', '=', $user->id)
                    ->orderby("id", "DESC")->paginate(30);    // ::get()
    }

    if(count($order) == 0){
      return ['status' => 'error'];
    }

    foreach($order as $elem){
      $elem->store_info->store_type ?? "none";
    }
    return $order;
  }



  // **********
  // add new order
  public function add(){
    $user = auth()->user();

    $order = new Order;
    $order->user_id = $user->id;
    $order->save();

    $order = Order::where('id', '=', $order->id)->get();

    return ['status' => 'done', 'data' => $order[0]];
  }



  // **********
  // set local order to DataBase
  public function setLocal($data){

    $order = $this->add();
    $order_id = $order['data']->id;

    foreach($data->data as $elem){

      $elemObj = (object) $elem;
      $elemObj->order_id = $order_id;

      $order_detail = new OrderDetailController;

      $order_detail->add($elemObj);

    }

    $data2 = (object) ["order_id" => $order_id ];
    $this->calc($data2, 'update');

    return ['status' => 'done' , 'data' => $this->getData($order_id)];

  }


  //*********
  //
  public function delete($data){

    if(!isset($data->id) || !isset($data->status)){
      return ["status" => "error", "message" => "set id and order_id"];
    }

    $goutes       = OrderDetailGoute::where('order_id' ,'=', $data->id)->forceDelete();
    $order_detail = OrderDetail::where('order_id', '=', $data->id)->forceDelete();
    $order        = Order::where('id', $data->id)->forceDelete();

    // if($data->status == 0){
    //   $order_detail ;
    //   $order ;

    // }else{
    //   $order_detail->delete() ;
    //   $order->delete();
    // }



    if($order){
      return ['status'=> 'done', $goutes, $order_detail];
              // 'message' => `deleted ($goutes) of goutes detail, ($order_detail) of order detail`];

    }else{
      return ['status'=> 'error'];
    }


  }



  // **********
  // calc order product
  public function calc($data, $action){
    if($data->order_id && $action == 'add_product'){

      $order = Order::where('id', '=', $data->order_id);

      $get = $order->first();
      // return $get->amount;
      $amount = $get->amount + $data->price_total;
      $weight = $get->weight + $data->weight;
      $num    = $get->num_cartone + $data->qte;

      $order->update([
        'amount' => $amount,
        'weight' => $weight,
        'num_cartone' => $num,
      ]);

    }elseif($data->order_id && $action == 'update'){

      $order_detail = OrderDetail::where('order_id', '=', $data->order_id)->get();

      $total_price   = 0;
      $total_buy     = 0;
      $total_weight  = 0;
      $total_cart    = 0;

      foreach($order_detail as $elem){
        if($elem['price_total'] == 0){
          return ['status' => 'error', 'message' => 'price_total not be 0'];
        }

        $method = $elem['product']['method_qte'];
        $buy = $elem['price_buy'] == 0 ? $elem['product']['price_buy'] : $elem['price_buy'];

        $total_price   += $elem['price_sell'] * $elem['qte'] * $method;
        $total_buy     += $buy * $elem['qte'] * $method;
        $total_weight  += $elem['weight'];
        $total_cart    +=  $elem['qte'];
      }

      Order::where('id' ,'=', $data->order_id)
            ->update(['amount'      => $total_price,
                      'amount_buy'  => $total_buy,
                      'num_cartone' => $total_cart,
                      'weight'      => $total_weight,
                    ]);
      return ['status' => 'done'];
    }elseif($data->order_id && $action == 'delete'){

      $order = Order::where('id', '=', $data->order_id);

      $get = ($order->get())[0];
      // return $get->amount;
      $amount = $get->amount - $data->price_total;
      $weight = $get->weight - $data->weight;
      $num    = $get->num_cartone - $data->qte;

      $order->update([
        'amount' => $amount,
        'weight' => $weight,
        'num_product' => $num,
      ]);

    }

  }

}
