<?php

namespace App\Http\Controllers\saller;

use App\Http\Controllers\Controller;
use App\Http\Controllers\website\OrderDetailController as WebsiteOrderDetailController;
use App\Models\Categorie;
use App\Models\Famille;
use Illuminate\Http\Request;

use App\Models\OrderDetailSaller;
use App\Models\Saller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class OrderDetailController extends Controller
{
  public function default(Request $req){

    // return response()->json( $req->action);

    $user = auth()->user();
    $saller = Saller::where('user_id', '=', $user->id)->first();

    if(!$saller){ return ['status' => 'error']; }

    // to getDat from  database
    if($req->action == 'getData' ){
      return response()->json( $this->getData($req, $saller) );

    }elseif($req->action == 'getDataPrint' ){
    return response()->json( $this->getDataPrint($req, $saller) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' ){
      return response()->json( $this->getHelpInfo($req) );

    }elseif($req->action == 'search'){
      return response()->json( $this->search($req) );

    // to add Order
    } elseif($req->action == 'add'){
    return response()->json( $this->add($req, $saller) );

      // to updat Order
    } elseif($req->action == 'update'){
    return response()->json( $this->update($req, $saller) );

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
  public function getData($data, $saller){


    if($data->id){
      $order_detail = OrderDetailSaller::where('id', $data->id)->get();


    }elseif($data->order_id){
      Order::where('id', '=', $data->order_id)
            ->update(['show_saller' => $saller->id]);

      $order_detail = OrderDetailSaller::where('order_id', $data->order_id);

      $order_detail = $data->all == true ? $order_detail->get() : $order_detail->get();

      // return $order_detail;
      // with(array('product_goute'=>function($query){
      //   $query->select()->where('in_stock', '!=', 0); }))
      //   ->where('status','!=','0')->orderby("rank", "DESC")->paginate(10);

    }else{
      return ['status'=> 'error', 'message' => 'not set id or order_id'];
    }

    if(count($order_detail) == 0){
      return ['message' => 'not have order_detail', 'status' => 'error'];
    }

    foreach($order_detail as $elem){
      $elem->product->product_goute;
      $goute = $elem->order_detail_goute ;

      foreach($goute as $el){
        $el->product_goute;
      }

    }

    return ['data' => $order_detail, 'status' => 'done'];
  }


  // **********
  //  function to get info help for product
  // **********
  public function getHelpInfo(){

    $cat   = Categorie::get();
    $famille = Famille::get();

    return ['categories'=> $cat, 'familles'=> $famille];
  }


  // Add order detail
  public function add($data, $saller){

    $order = Order::where([['id', '=', $data->order_id],['saller_id', '=', $saller->id]])->get();
    if(count($order) <= 0){
      return ['status' => 'error', 'message' => 'order_id or saller not set'];
    }

    // add order detail
    $order_detail = new WebsiteOrderDetailController;

    $rt = $order_detail->add($data, $saller);

    $order_detail = $rt['data'][0];


    // add order detail Saller
    $order_detail_saller = new OrderDetailSaller();

    $order_detail_saller->order_detail_id = $order_detail->id;
    $order_detail_saller->saller_id  = $saller->id;
    $order_detail_saller->order_id   = $data->order_id;
    $order_detail_saller->product_id = $data->product_id;
    $order_detail_saller->price_buy  = $data->price_buy;
    $order_detail_saller->qte        = $data->qte;
    $order_detail_saller->method_qte = $data->method_qte;
    $order_detail_saller->price_total= ( $data->price_buy * $data->qte * $data->method_qte );

    $order_detail_saller->save();

    Order::where([['saller_id', '=', $saller->id],['id', '=', $data->order_id ]])
          ->update(['amount_buy' => 0,
                    'status'     => 2]);


    return $this->getData($order_detail_saller, $saller);


  }

  // update order
  public function update($data, $saller){

    $order = $data->data;
    $error_id = [];

    foreach($order as $elem){
      if($elem['price_buy'] <= 0 || ( $elem['qte'] <= 0 && $elem['in_stock'] > 0 )){
        $error_id[] = $elem['id'];
      }
    }
    if(count($error_id) > 0){
      return ['status' => 'error_info', 'id' => $error_id,
              'message' => 'info error in product:'.$elem['product']['name'] ];
    }

    $amount_buy = 0;

    foreach($order as $elem){
      $elem['method_qte'] == 0 ? $elem['method_qte'] = 1 :'';

      OrderDetailSaller::where([['saller_id', '=', $saller->id],['id', '=', $elem['id']]])
                      ->update(['price_buy'   => $elem['price_buy'],
                                'qte'         => $elem['qte'],
                                'in_stock'    => $elem['in_stock'],
                                'price_total' => ( $elem['price_buy'] * $elem['qte'] * $elem['method_qte'] ) ]);

      $amount_buy += $elem['price_buy'] * $elem['qte'] * $elem['method_qte'];
    }

    Order::where([['saller_id', '=', $saller->id],['id', '=', $order[0]['order_id'] ]])
          ->update(['amount_buy' => $amount_buy,
                    'status'     => 3,
                    'show_admin' => 0]);

    return ['status' => 'done'];

  }


  // **********
  //  function to get Order data
  // **********
  public function getDataPrint($data, $saller){

    if(!$data->order_id){
      return ['status'=> 'error', 'message' => 'not set Order id'];
    }

    $saller = Saller::where('id', '=', $saller->id)->first();
    $order = Order::where([['saller_id', '=', $saller->id], ['id', '=', $data->order_id]])->first();

    $id = $data->order_id;
    $order_detail = OrderDetailSaller::where([['saller_id', '=', $saller->id], ['order_id', '=', $id]])->get();    // ::get()


    foreach($order_detail as $elem){
      $elem->product->product_goute;
      $goute = $elem->order_detail_goute ;

      foreach($goute as $el){
        $el->product_goute;
      }

    }

    return ['status'      => 'done',
            'saller'      => $saller,
            'order'       => $order,
            'order_detail'=> $order_detail];
  }


  /*
  | search method
  */
  public function search($data){

    if($data->id){

      $resulte = Product::with(array('product_goute'=>function($query){
                    $query->select()->where('in_stock', '!=', 0); }))
                    ->where('id', $data->id)->get();

    }else{
      $string = $data->str;
      // $method = $data->method;

      $opt = [["name", "like", "%{$string}%"], ["status", "!=", 0], ["in_stock", "!=", 0]];

      $data->categorie_id ? array_push($opt, ["categorie_id", "=", $data->categorie_id]): '';
      $data->famille_id ? array_push($opt, ["famille_id", "=", $data->famille_id]): '';

      $resulte = Product::where($opt)
                        ->select('id', 'name','image', 'price_sell1')
                        ->orderby("name", "ASC")
                        ->limit(10)->get();
    }

    // foreach($resulte as $elem){
    //   $elem->product_goute ;
    // }
    return $resulte;
  }
}
