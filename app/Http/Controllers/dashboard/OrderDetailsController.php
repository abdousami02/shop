<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Famille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\OrderDetail;
use App\Models\OrderDetailGoute;
use App\Models\Product;
use App\Models\Order;

class OrderDetailsController extends Controller
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

    }elseif($req->action == 'getDataPrint' && $get ){
      return response()->json( $this->getDataPrint($req) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' && $get ){
        return response()->json( $this->getHelpInfo($req) );

      }elseif($req->action == 'search' && $get){
        return response()->json( $this->search($req) );

      // to add Order
    } elseif($req->action == 'add' && $add){
      return response()->json( $this->add($req) );

        // to updat Order
    } elseif($req->action == 'update' && $update){
      return response()->json( $this->update($req) );

      // to updat Order
    } elseif($req->action == 'updateStock' && $update){
      return response()->json( $this->updateStock($req) );

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

    $user = auth()->user();

    if($data->id){
      $order_detail = OrderDetail::where('id', $data->id)->get();

    }elseif($data->order_id){
      Order::where('id', '=', $data->order_id)
          ->update(['show_admin' => $user->id]);

      $order_detail = OrderDetail::where('order_id', $data->order_id);    // ::get()

      $order_detail = $data->print == true ? $order_detail->get() : $order_detail->paginate(30);

      // with(array('product_goute'=>function($query){
      //   $query->select()->where('in_stock', '!=', 0); }))
      //   ->where('status','!=','0')->orderby("rank", "DESC")->paginate(10);

    }else{
      return ['status'=> 'permition'];
    }

    foreach($order_detail as $elem){
      $elem->product->product_goute;
      $elem->order_detail_saller;
      $goute = $elem->order_detail_goute ;

      foreach($goute as $el){
        $el->product_goute;
      }

    }

    return ['data' => $order_detail, 'status' => 'done'];
  }


  // **********
  //  function to get Order data
  // **********
  public function getDataPrint($data){


    if($data->order_id){
      $orderCon = new OrderController;
      $orderCon->calc($data, 'update');

      $data->id = $data->order_id;
      $order = ($orderCon->getData($data))['data'][0];

      $id = $data->order_id;
      $order_detail = OrderDetail::where('order_id', '=', $id)->get();    // ::get()

    }else{
      return ['status'=> 'permition', 'message' => 'not set Order id'];
    }


    foreach($order_detail as $elem){
      $elem->product->product_goute;
      $goute = $elem->order_detail_goute ;

      foreach($goute as $el){
        $el->product_goute;
      }

    }

    return ['order_detail' => $order_detail, 'order' => $order, 'status' => 'done'];
  }





  // **********
  //  function to get info help for product
  // **********
  public function getHelpInfo($data){

    $cat   = Categorie::get();
    $famille = Famille::get();


    return ['categories'=> $cat, 'familles'=> $famille];
  }




  // ************
  // function to add product to order
  // ************
  public function add($data) {

    //if product is already exists
    $order_det = OrderDetail::where('order_id', '=', $data->order_id)
                            ->where('product_id', '=', $data->product_id)->get();

    if(count($order_det) > 0){
      foreach($order_det as $elem){
        $data->id = $elem['id'];
        $this->delete($data);
      }
    }


    $validator = Validator::make($data->all(), [
      'order_id'   => 'required|integer|exists:order,id',
      'product_id' => 'required|integer|exists:products,id',
      'price_sell' => 'required|max:99999|regex:/^\d*\.?\d*$/',
      'qte'        => 'required|integer|max:999|min:1',
      'order_detail_goute.*.product_goute_id' => 'sometimes|integer|exists:product_goute,id',
      'order_detail_goute.*.qte' => 'sometimes|integer|max:999',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }
    if($data->price_sell < $data->product['price_buy']){
      return ['status'=> 'error', 'errors'=> ['price_sell' => false]];
    }

    $order_detail = new OrderDetail();

    $method = $data->product['method_qte'];

    $order_detail->order_id     = $data->order_id;
    $order_detail->product_id   = $data->product_id;
    $order_detail->price_sell   = $data->price_sell;
    $order_detail->price_total  = ($data->price_sell * $data->qte * $method);
    $order_detail->qte          = $data->qte;
    $order_detail->method_qte   = $method;
    $order_detail->weight       = ($data->weight * $data->qte * $method);

    $order_detail->save();

    // return $data->order_detail_goute;

    $this->addGoute($data->order_detail_goute, $order_detail);


    $calc = new OrderController();
    $calc->calc($order_detail, 'add_product');

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
      'price_sell' => 'required|max:99999|regex:/^\d*\.?\d*$/',
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
      'price_sell' => $data->price_sell,
      'qte'        => $data->qte,
      'price_total'=> ($data->price_sell * $data->qte),
      'weight'     => ($data->weight * $data->qte),
    ];

    OrderDetail::where('id', '=', $data->id)
              ->update($info);


    $this->updateGoute($data->order_detail_goute, $data->id);

    $calc = new OrderController();
    $calc->calc($data, 'update');

    return $this->getData($data);

  }


  public function updateStock($data){

    if($data->id){
      $order = OrderDetail::where('id', '=', $data->id)
                          ->update(['in_stock' => $data->in_stock]);

      if($order > 0){
        return ['status' => 'done', 'data' => $data->in_stock];
      }
    }

  }


  // search method
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


  // ***********
  // Add Goutes to order
  // ***********
  public function addGoute($goutes, $order_detail){
    foreach($goutes as $elem){
      $goute = new OrderDetailGoute();

      $goute->order_detail_id = $order_detail->id;
      $goute->order_id = $order_detail->order_id;
      $goute->product_goute_id = $elem['product_goute_id'];
      $goute->qte = $elem['qte'];

      $goute->save();
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
        OrderDetailGoute::where('id', $elem['id'])
                        ->update(['qte' => $elem['qte'] ]);

      }elseif($elem['id'] && isset($elem['edite']) && $elem['edite'] == 'delete'){
        OrderDetailGoute::where('id', '=', $elem['id'])->delete();
      }
    }
  }


  // ***********
  // Update Goutes to order
  // ***********
  protected function delete($data){

    $validator = Validator::make($data->all(), [
      'id' => 'integer|required|exists:order_details,id',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    $goutes = OrderDetailGoute::where('order_detail_id' ,'=', $data->id)->delete();

    $order = OrderDetail::where('id', '=', $data->id)->delete();

    if($order){
      $calc = new OrderController();
      $calc->calc($data, 'delete');

      return ['status' => 'done',
            'message' => `deleted ($goutes) of goutes detail, ($order) of order detail`];
    }
  }

}
