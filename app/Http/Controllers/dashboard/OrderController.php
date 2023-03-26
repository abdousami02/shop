<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailGoute;
use App\Models\Saller;
use App\Models\Sallers;
use App\Models\Users;

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
              $get= true; $update= true; $add= true; $delete= false;
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
        return response()->json( $this->getData($req) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' && $get ){
        return response()->json( $this->getHelpInfo($req) );

      // to add Order
    } elseif($req->action == 'add' && $add){
      return response()->json( $this->add($req) );

        // to updat Order
    } elseif($req->action == 'update' && $update){
      return response()->json( $this->update($req) );


    } elseif($req->action == 'calc' && $get){
      $del = $this->calc($req, 'hard_update');

      if( $del['status'] == 'done' ){
        $req->id = $req->order_id;
        $out = $this->getData($req);

      }else{
        $out = ["status" => "error"];
      }
      return response()->json( $out );


      // to delet Order
    } elseif($req->action == 'delete' && $delete){
        return response()->json( $this->delete($req) );

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  // **********
  //  function to get Order data
  // **********
  public function getData($data){

    if($data->id){
      $id = $data->id;
      $order = Order::where('id', $id)->get();

    }else{
      $order = Order::orderby("id", "DESC")->paginate(30);    // ::get()
    }

    foreach($order as $elem){
      $elem->user;
      $elem->saller->user ?? "none";
      $elem->store_info->store_type ?? "none";
    }

    return ['data' => $order, 'status' => 'done'];
  }


  // **********
  //  function to get info help for product
  // **********
  public function getHelpInfo($data){

    $user   = new UserController;
    $user   = $user->getData('all');

    $saller = Saller::get();


    return ['users'=> $user, 'sallers'=> $saller];
  }


  // ************
  // function to add Order
  // ************
  public function add($data) {

    $validator = Validator::make($data->all(), [
      'user_id'   => 'required|integer|exists:users,id',
      'store_id'  => 'nullable|integer|exists:store_info,id',
      'saller_id' => 'nullable|integer|exists:sallers,id',
      'status'    => 'nullable|integer|max:5',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $order = new Order();

    $order->user_id = $data->user_id;
    $order->store_id = $data->store_id;
    isset($data->saller_id) ? $order->saller_id = $data->saller_id : null;
    isset($data->status)    ? $order->status    = $data->status : null;

    $order->save();

    return $this->getData($order);
  }


  // *********
  // function to update Group
  // *********
  public function update($data){

    $validator = Validator::make($data->all(), [
      'id'        => 'required|integer|exists:order,id',
      'saller_id' => 'nullable|integer|exists:sallers,id',
      'store_id'  => 'nullable|integer|exists:store_info,id',
      'status'    => 'nullable|integer|max:5',
    ]);


    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    Order::where('id', $data->id)
                    ->update(['saller_id'=> $data->saller_id, 'store_id' => $data->store_id , 'status'=> $data->status]);    //find element


    return $this->getData($data);
  }

  // ***********
  // function delete group
  // ***********
  public function delete($data){

    if(!$data->id ){
      return ["status" => "error", "message" => "set id and order_id"];
    }

    $goutes = OrderDetailGoute::where('order_id' ,'=', $data->id)->delete();

    $order_detail = OrderDetail::where('order_id', '=', $data->id)->delete();

    $order = Order::where('id', $data->id)->delete();


    if($order){
      return ['status'=> 'done', '
              message' => `deleted ($goutes) of goutes detail, ($order_detail) of order detail`];

    }else{
      return ['status'=> 'error'];
    }
  }



  // *************
  // Function to Calculate Order Product
  // *************
  public function calc($data, $action){
    $id = $data->order_id;

    if(!$id){
      return false;

    }elseif($action == 'add_product'){

      $order = Order::where('id', '=', $id);

      $get = ($order->get())[0];
      // return $get->amount;
      $amount = $get->amount + $data->price_total;
      $weight = $get->weight + $data->weight;
      $num    = $get->num_product + 1;

      $order->update([
        'amount' => $amount,
        'weight' => $weight,
        'num_product' => $num,
      ]);

      // Update Order product
    }elseif($action == 'update'){

      $order_detail = OrderDetail::where('order_id', '=', $id)->get();

      $total_price   = 0;
      $total_product = 0;
      $total_weight  = 0;

      foreach($order_detail as $elem){
        $total_price   += $elem['price_total'];
        $total_product += 1;
        $total_weight  += $elem['weight'];
      }

      Order::where('id' ,'=', $id)
            ->update(['amount' => $total_price,
                      'num_product' => $total_product,
                      'weight' => $total_weight,
                    ]);
      return ['status' => 'done'];


     // Harde Update Calc Order
    }elseif($action == 'hard_update'){

      $order_detail = OrderDetail::where('order_id', '=', $id)->get();

      $total_price   = 0;
      $total_product = 0;
      $total_weight  = 0;

      foreach($order_detail as $elem){
        $elem->product;

        if($elem['product']['qte_sell3'] && $elem['qte'] > $elem['product']['qte_sell3']){   //  set price sell with qte
          $price_sell = $elem['product']['price_sell3'];

        }elseif($elem['product']['qte_sell3'] && $elem['qte'] > $elem['product']['qte_sell3']){
          $price_sell = $elem['product']['price_sell2'];

        }else{
          $price_sell = $elem['product']['price_sell1'];
        }

        // return $elem['product'];
        $method = $elem['product']['method_qte'];

        $total_price   += ($price_sell * $elem['qte'] * $method);;
        $total_product += 1;
        $total_weight  += ($elem['product']['weight'] * $elem['qte'] * $method);

        OrderDetail::where('id', '=', $elem['id'])
                    ->update([
                      'price_sell'=> ($price_sell * $data->qte * $method),
                      'weight'    => ($elem['product']['weight'] * $data->qte * $method)
                    ]);
      }

      Order::where('id' ,'=', $id)
            ->update(['amount' => $total_price,
                      'num_product' => $total_product,
                      'weight' => $total_weight,
                    ]);
      return ['status' => 'done'];



      // delete product from Order
    }elseif($action == 'delete'){


      $order = Order::where('id', '=', $id);

      $get = ($order->get())[0];
      // return ['order' => $get->amount, 'detail' => $data->price_total];
      $price_prod = $data->price_total;
      $weight_prod = $data->weight;

      $amount = $get->amount - $price_prod;
      $weight = $get->weight - $weight_prod;
      $num    = $get->num_product - 1;

      // return [$amount, $weight, $num];

      $order->update([
        'amount' => $amount,
        'weight' => $weight,
        'num_product' => $num,
      ]);

    }
  }


}
