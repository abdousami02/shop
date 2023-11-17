<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailGoute;
use App\Models\OrderDetailSaller;
use App\Models\Saller;
use App\Models\Setting;
use App\Models\Users;
use PhpParser\Node\Expr\FuncCall;

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
              $get= true; $update= true; $add= true; $delete= true;
              break;

        case 2 :
              $get= true; $update= true; $add= true; $delete= false;
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

      // to help Info from  database
    }elseif($req->action == 'getNew' && $get ){
        return response()->json( $this->getNew($req) );

      // to add Order
    } elseif($req->action == 'add' && $add){
      return response()->json( $this->add($req) );

      // to updat Order
    } elseif($req->action == 'updateSaller' && $update){
      return response()->json( $this->updateSaller($req) );

      // to updat Order
    } elseif($req->action == 'update' && $update){
      return response()->json( $this->update($req) );


    } elseif($req->action == 'calc' && $get){
      $del = $this->calc($req, 'update');

      if( $del['status'] == 'done' ){
        $req->id = $req->order_id;
        $out = $this->getData($req);

      }else{
        $out = $del;
      }
      return response()->json( $out );


      // to delet Order
    } elseif($req->action == 'delete' && $delete){
        return response()->json( $this->delete($req) );

    } elseif($req->action == 'close_order'){
      return response()->json($this->close($req));

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

    }elseif(isset($_GET['status'])){
      $status = $_GET['status'];
      $order = Order::where('status', '=', $status)->orderby("created_at", "DESC")->paginate(30);

    }else{
      $order = Order::where('status', '!=', 0)->orderby("created_at", "DESC")->paginate(30);    // ::get()
    }

    foreach($order as $elem){
      $elem->user;
      $elem->saller->user ?? "none";
      $elem->store_info->store_type ?? "none";
    }

    $draft    = Order::where('status', '=', 0)->select('id')->get();
    $commande = Order::where([['status', '>=', 2],['status', '<=', 5]])->select('id')->get();
    $canccel  = Order::where('status', '=', 9)->select('id')->get();

    $info = ['draft' => count($draft), 'commande' => count($commande), 'canccel' => count($canccel)];

    return ['data' => $order, 'status' => 'done', 'info' => $info];
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



  // **********
  //  function to get info help for product
  // **********
  public function getNew($data){

    $order = Order::where([['show_admin', '=', 0],['status', '>', 0]])
                  ->where('updated_at', '>', $data->last)
                  ->orderby("updated_at", "DESC")->get();

    if(count($order) > 0){
      $out = [];
      foreach($order as $elem){
        $out[] = ($this->getData($elem))['data'][0];
      }
      return ['status' => 'done', 'data' => $out];
      // return $this->getData((object)$order);

    }else{
      return ['status' => 'none', $data->last ];
    }
  }



  // ************
  // function to add Order
  // ************
  public function add($data) {

    $validator = Validator::make($data->all(), [
      'user_id'   => 'required|integer|exists:users,id',
      'store_id'  => 'nullable|integer|exists:store_info,id',
      'note'      => 'nullable|string',
      'status'    => 'nullable|integer|max:5',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $order = new Order();

    $order->user_id   = $data->user_id;
    $order->store_id  = $data->store_id;
    $order->note      = isset($data->note)   ? $data->note   : null;
    $order->status    = isset($data->status) ? $data->status : 1;
    $order->show_admin= 1;

    $order->save();

    return $this->getData($order);
  }


  // *********
  // function to update Group
  // *********
  public function update($data){

    $validator = Validator::make($data->all(), [
      'id'        => 'required|integer|exists:order,id',
      // 'saller_id' => 'nullable|integer|exists:sallers,id',
      'store_id'  => 'nullable|integer|exists:store_info,id',
      'note'      => 'nullable|string',
      'status'    => 'nullable|integer|max:10',
    ]);


    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    Order::where('id', $data->id)
          ->update(['saller_id' => $data->saller_id,
                    'store_id'  => $data->store_id ,
                    'note'      => $data->note,
                    'status'    => $data->status]);    //find element


    return $this->getData($data);
  }


  //************ */
  // update Saller
  public function updateSaller($data){

    $param = $this->setting($data->user_id);

    $validator = Validator::make($data->all(), [
      'id'        => 'required|integer|exists:order,id',
      'saller_id' => 'nullable|integer|exists:sallers,id',
    ]);
    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $date = date("Y-m-d H:i:s");

    $order = Order::where('id', '=', $data->id);
    $order->update(['saller_id'   => $data->saller_id,
                    'status'      => 2,
                    'show_saller' => 0,
                    'show_admin'  => 1,
                    'to_saller_at'=> $date]);

    $order_saller = OrderDetailSaller::where('order_id', '=', $data->id)->delete();

    // if(count($order_saller) > 0){
    //   OrderDetailSaller::where('order_id', '=', $data->id)
    // }


    $order_detail = OrderDetail::where('order_id', '=', $data->id)
                                ->select('id', 'product_id', 'qte','method_qte', 'weight')
                                ->with('product')->get();


    // return $order_detail;
    isset($param->set_price_sell) ? '': $param->set_price_sell = 10;

    foreach($order_detail as $elem){

      if($param->set_price_sell == 1){    // last of price selling
        $price = OrderDetailSaller::where([['product_id', '=', $elem['product']['id']],
                                          ['saller_id', '=', $data->saller_id]])
                                    // ->orwhere('product_id', '=', $elem['product']['id'])
                                    ->orderBy('id', 'desc')->first();


      }elseif($param->set_price_sell == -1){  // first price selling
        $price = OrderDetailSaller::where([['product_id', '=', $elem['product']['id']],
                                          ['saller_id', '=', $data->saller_id]])
                                    // ->orwhere('product_id', '=', $elem['product']['id'])
                                    ->first();

      }elseif($param->set_price_sell == 0){     // price of priduct
        $price = '';
      }
      $price ? $price_buy = $price->price_buy : $price_buy = $elem['product']['price_buy'];



      $order_sell = new OrderDetailSaller();

      $order_sell->saller_id        = $data->saller_id;
      $order_sell->order_id         = $data->id;
      $order_sell->order_detail_id  = $elem['id'];
      $order_sell->product_id       = $elem['product']['id'];
      $order_sell->price_buy        = $price_buy;
      $order_sell->qte              = $elem['qte'];
      $order_sell->method_qte       = $elem['method_qte'];
      $order_sell->price_total      = $elem['qte'] * $price_buy * $elem['method_qte'];
      $order_sell->save();
    }


    return $this->getData($data);

  }


  public function close($data){

    $out = Order::where('id', '=', $data->order_id)
        ->update(['status' => 7]);

    if($out > 0){
      return ['status' => 'done'];

    }else{
      return ['status' => 'error'];
    }

  }


  public function setting($user_id){

    $param = Setting::where([['section', '=', 'order_saller'],['user_id', '=', $user_id]])
                    ->orwhere([['section', '=', 'order_saller'],['user_id', '=', 0] ])
                    ->get();
    // return $param;
    $out = [];
    foreach($param as $elem){
      $out[$elem['param']] = $elem['value'];
    }
    return (object) $out;
  }

  // ***********
  // function delete group
  // ***********
  public function delete($data){

    if(!$data->id ){
      return ["status" => "error", "message" => "set id and order_id"];
    }

    $saller = OrderDetailSaller::where('order_id' ,'=', $data->id)->delete();

    $goutes = OrderDetailGoute::where('order_id' ,'=', $data->id)->delete();

    $order_detail = OrderDetail::where('order_id', '=', $data->id)->delete();

    $order = Order::where('id', $data->id)->forceDelete();


    if($order){
      return ['status'=> 'done',
              'message' => `deleted ($goutes) of goutes detail, ($order_detail) of order detail`];

    }else{
      return ['status'=> 'error', 'message' => 'not delete any order'];
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

      $order = Order::where('id', '=', $id)->first();

      $amount     = $order->amount + $data->price_total;
      $amount_buy = $order->amount_buy + ( $data->price_buy * $data->qte * $data->method_qte );
      $weight     = $order->weight + $data->weight;
      $num        = $order->num_cartone + $data->qte;

      $order->update([
        'amount' => $amount,
        'amount_buy'  => $amount_buy,
        'weight' => $weight,
        'num_cartone' => $num,
      ]);

      // Update Order product
    }elseif($action == 'update'){

      $order_detail = OrderDetail::where('order_id', '=', $id)->get();

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

      Order::where('id' ,'=', $id)
            ->update(['amount'      => $total_price,
                      'amount_buy'  => $total_buy,
                      'num_cartone' => $total_cart,
                      'weight'      => $total_weight,
                    ]);
      return ['status' => 'done'];


     // Harde Update Calc Order

    }elseif($action == 'delete'){


      $order = Order::where('id', '=', $id)->first();

      $amount     = $order->amount - $data->price_total;
      $amount_buy = $order->amount_buy - ($data->price_buy * $data->qte * $data->method_qte);
      $weight     = $order->weight - $data->weight;
      $num        = $order->num_cartone - $data->qte;

      // return [$amount, $weight, $num];

      $order->update([
        'amount' => $amount,
        'amount' => $amount_buy,
        'weight' => $weight,
        'num_cartone' => $num,
      ]);

    }
  }


}
