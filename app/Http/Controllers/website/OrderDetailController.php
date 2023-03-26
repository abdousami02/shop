<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Models\OrderDetail;
use App\Models\OrderDetailGoute;
use App\Models\Product;

class OrderDetailController extends Controller
{

  public function default(Request $req){

    // return response()->json( $req->action);
    $user = auth()->user();
    // to getDat from  database
    if($req->action == 'getData' ){
      return response()->json( $this->getData($req) );

    }elseif($req->action == 'getDataPrint' ){
    return response()->json( $this->getDataPrint($req) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' ){
      return response()->json( $this->getHelpInfo($req) );

    }elseif($req->action == 'search'){
      return response()->json( $this->search($req) );

    // to add Order
    } elseif($req->action == 'add'){
    return response()->json( $this->add($req, $user) );

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



  // **********
  //  function to get Order data
  // **********
  public function getData($data){

    // return "now in get data";

    if($data->id){
      $order_detail = OrderDetail::where('id', $data->id)->get();

    }elseif($data->order_id){
      $order_detail = OrderDetail::where('order_id', $data->order_id);

      $order_detail = $data->all == true ? $order_detail->get() : $order_detail->paginate(30);

      // with(array('product_goute'=>function($query){
      //   $query->select()->where('in_stock', '!=', 0); }))
      //   ->where('status','!=','0')->orderby("rank", "DESC")->paginate(10);

    }else{
      return ['status'=> 'permition', 'message' => 'not set id or order_id'];
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


  // ************
  // function to add Order
  // ************
  public function add($data) {
    // return $data->order_id;

    //if product is already exists
    $order_det = OrderDetail::where('order_id', '=', $data->order_id)
                            ->where('product_id', '=', $data->product_id)->get();

    if(count($order_det) > 0){
      foreach($order_det as $elem){
        $data->id = $elem['id'];
        $this->delete($data);
      }
    }

    if(isset($data->action) && $data->action == 'add'){
      $valid = $data->all();

    }else{
      $valid = (array) $data;
      $valid['order_detail_goute'] = [];
      if(isset($data->order_detail_goute)){
        foreach($data->order_detail_goute as $elem => $value){
          $valid['order_detail_goute'][$elem] = (array) $value;
        }
      }
    }

    // return $valid;

    $validator = Validator::make($valid, [
      'order_id'   => 'required|integer|exists:order,id',
      'product_id' => 'required|integer|exists:products,id',
      'qte'        => 'required|integer|max:999|min:1',

      'order_detail_goute.*.product_goute_id' => 'sometimes|integer|exists:product_goute,id',
      'order_detail_goute.*.qte' => 'sometimes|integer|max:999',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $product = Product::where('id', '=', $data->product_id)->get();
    $product = $product[0];



    $order_detail = new OrderDetail();

    if($product->qte_sell3 && $data->qte > $product->qte_sell3){   //  set price sell with qte
      $price_sell = $product->price_sell3;
      // return $price_sell;

    }elseif($product->qte_sell2 && $data->qte > $product->qte_sell2){
      $price_sell = $product->price_sell2;

    }else{
      $price_sell = $product->price_sell1;
    }
    // return $price_sell;

    $method = $product->method_qte;

    $order_detail->order_id     = $data->order_id;
    $order_detail->product_id   = $data->product_id;
    $order_detail->price_sell   = $price_sell;
    $order_detail->price_total  = ($price_sell * $data->qte * $method);
    $order_detail->qte          = $data->qte;
    $order_detail->weight       = ($product->weight * $data->qte * $method);

    $order_detail->save();

    $calc = new OrderController();
    $calc->calc($order_detail, 'add_product');


    // return $data->order_detail_goute;
    if(isset($data->order_detail_goute) && count($data->order_detail_goute) > 0){
      $this->addGoute($data->order_detail_goute, $order_detail);
    }

    return $this->getData($order_detail);

  }



    // ************
  // function to add Order
  // ************
  public function update($data){

    $validator = Validator::make($data->all(), [
      'id'         => 'required|integer|exists:order_details,id',
      'order_id'   => 'required|integer|exists:order,id',
      'product_id' => 'required|integer|exists:products,id',
      'qte'        => 'required|integer|max:999|min:1',
      'order_detail_goute.*.id' => 'sometimes|integer',
      'order_detail_goute.*.product_goute_id' => 'sometimes|integer|exists:product_goute,id',
      'order_detail_goute.*.qte' => 'sometimes|integer|max:999',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }
    if($data->price_sell <= $data->product['price_buy']){
      return ['status'=> 'error', 'errors'=> ['price_sell' => true]];
    }

    $info = [
      'price_sell' => $data->product['price_sell1'],
      'qte'        => $data->qte,
      'price_total'=> ($data->price_sell * $data->qte),
      'weight'     => ($data->weight * $data->qte),
    ];

    OrderDetail::where('id', '=', $data->id)
              ->update($info);


    $calc = new OrderController();
    $calc->calc($data, 'update');

    $this->updateGoute($data->order_detail_goute, $data->id);

    return $this->getData($data);

  }




  // ***********
  // Add Goutes to order
  // ***********
  public function addGoute($goutes, $order_detail){
    foreach($goutes as $elem){

      if( !(isset($elem['edite']) && $elem['edite'] == 'delete') ){
        $goute = new OrderDetailGoute();

        $goute->order_id = $order_detail->order_id;
        $goute->order_detail_id = $order_detail->id;
        $goute->product_goute_id = $elem['product_goute_id'];
        $goute->qte = $elem['qte'];

        $goute->save();
      }
    }
  }

  // ***********
  // Update Goutes to order
  // ***********
  public function updateGoute($goutes, $id){

    foreach($goutes as $elem){
      if(!isset($elem['id'])){
        $this->addGoute([$elem], $id);

      }elseif($elem['id'] && isset($elem['edite']) && $elem['edite'] == 'edite'){
        OrderDetailGoute::where('id', $elem->id)
                        ->update(['qte', $elem->qte]);

      }elseif($elem['id'] && isset($elem['edite']) && $elem['edite'] == 'delete'){
        OrderDetailGoute::where('id', '=', $elem['id'])->delete();
      }
    }
  }


  // ***********
  // Update Goutes to order
  // ***********
  protected function delete($data){

    if(!($data->id && $data->order_id)){
      return ["status" => "error", "message" => "set id and order_id"];
    }



    $goutes = OrderDetailGoute::where('order_detail_id' ,'=', $data->id)->delete();

    $order = OrderDetail::where('id', '=', $data->id)->delete();



    if($order){
      $calc = new OrderController();
      $calc->calc($data, 'delete');

      return ['status' => 'done', 'message' => 'success delete order detail'];
    }else{
      return ['status' => 'error'];
    }
  }


}
