<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Categorie;
use App\Models\Famille;
use App\Models\Product;
use App\Models\ProductGoute;
use Mockery\Undefined;

class ProductController extends Controller
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
              $get= true; $update= true; $add= true; $delete= false;
              break;

        case 3 :
              $get= true; $update= true; $add= false; $delete= false;
              break;

        default: break;
      }

    }else{
      $get = false; $add= false; $update= false; $delete= false;
    }


    // to getDat from  database
    if($req->action == 'getData' && $get ){
        return response()->json( $this->getData($req) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' && $get ){
        return response()->json( $this->getHelpInfo($req) );

    }elseif($req->action == 'search' && $get){
      return response()->json( $this->search($req) );

        // to add group
    } elseif($req->action == 'add' && $add){
      return response()->json( $this->add($req) );

    }elseif($req->action == 'update_stock' && $update){
      return response()->json( $this->update_stock($req) );

        // to updat group
    } elseif($req->action == 'update' && $update){
      return response()->json( $this->update($req) );


      // to delet group
    } elseif($req->action == 'delete' && $delete){
        return response()->json( $this->delete($req) );

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  // **********
  //  function to get Group data
  // **********
  public function getData($data){

    if($data->id){
      $product = Product::with(array('product_goute'))
                        ->where('id', $data->id)->get();

    }else{
      $product = Product::with(array('product_goute'))->paginate(50);    // ::get()
    }

    // foreach($product as $elem){
    //   $elem->product_goute ;
    // }

    return ['data'=> $product, 'status'=> 'done'];
  }


  // **********
  //  function to get info help for product
  // **********
  public function getHelpInfo($data){

    $cat     = Categorie::get();
    $famille = Famille::get();

    return ['categories'=> $cat, 'familles'=> $famille];
  }


  // ************
  // function to add Group
  // ************
  protected function add($data_old) {

    $data = json_decode($data_old->product);
    $data->image = $data_old->image;
    $data->action = $data_old->action;

    // return response()->json(($data->price_sell2 ? true : false));

    $valid = (array) $data;
    $valid['product_goute'] = [];
    foreach($data->product_goute as $elem => $value){
      $valid['product_goute'][$elem] = (array) $value;
    }

    $validator = Validator::make($valid, [

      'categorie_id'=> 'required|exists:categories,id',
      'famille_id'  => 'nullable|exists:familles,id',
      'name'        => 'required|unique:products,name|min:3|max:40|string',
      'name_ar'     => 'nullable|min:3|max:40|string',
      'code_bare'   => 'nullable|unique:products,code_bare|integer',
      'description' => 'nullable|string|max:150',
      'method_price'=> 'required|in:unite,cartone',
      'price_buy'   => 'required|regex:/^\d*\.?\d*$/',
      'qte_uc'      => 'required|integer',
      'price_sell1' => 'required|regex:/^\d*\.?\d*$/|max:9999',
      'price_sell2' => 'nullable|regex:/^\d*\.?\d*$/|max:9999',
      'price_sell3' => 'nullable|regex:/^\d*\.?\d*$/|max:9999',
      'qte_sell2'   => 'nullable|integer',
      'qte_sell3'   => 'nullable|integer',
      'in_stock'    => 'required|integer|in:0,1',
      'status'      => 'required|integer|in:0,1',
      'rank'        => 'nullable|integer|max:999',
      'weight'      => 'nullable|regex:/^\d*\.?\d*$/|max:999',
      'has_goute'   => 'nullable|integer',
      'has_discount' => 'nullable|integer|in:0,1',
      'product_goute.*.goute'   => 'required|string|max:15|min:2',
      'product_goute.*.in_stock'=> 'required|integer|in:0,1',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }

    // return response()->json(['data' => $data->image]);
    $prod = new Product();

    $prod->categorie_id = $data->categorie_id;
    $prod->famille_id   = isset($data->famille_id) ? $data->famille_id: null;
    $prod->name         = $data->name;
    $prod->name_ar      = isset($data->name_ar) ? $data->name_ar : null ;
    $prod->code_bare    = isset($data->code_bare) && $data->code_bare ? $data->code_bare : null;
    $prod->description  = isset($data->description) ? $data->description : null;
    $prod->method_price = $data->method_price;
    $prod->method_qte   = ( $data->method_price == 'unite') ? $data->qte_uc : 1 ;
    $prod->price_buy    = $data->price_buy;
    $prod->qte_uc       = $data->qte_uc;
    $prod->price_sell1  = $data->price_sell1;
    $prod->price_sell2  = isset($data->price_sell2) && $data->price_sell2 ? $data->price_sell2 : null;
    $prod->price_sell3  = isset($data->price_sell3) && $data->price_sell3 ? $data->price_sell3 : null;
    $prod->qte_sell2    = isset($data->qte_sell2) && $data->qte_sell2 ? $data->qte_sell2 : null;
    $prod->qte_sell3    = isset($data->qte_sell3) && $data->qte_sell3 ? $data->qte_sell3 : null;
    $prod->status       = $data->status;
    $prod->in_stock     = $data->in_stock;
    $prod->rank         = isset($data->rank) && $data->rank ? $data->rank : 0;
    $prod->weight       = isset($data->weight) && $data->weight ? $data->weight : 0;
    $prod->has_goute    = isset($data->product_goute) ? count($data->product_goute) : 0;
    $prod->has_discount = isset($data->has_discount) && $data->has_discount ? $data->has_discount : 0;


    // condition fo Image
    if(is_file($data->image)){
      $image_name = time().'_'.str_replace(' ', '-',$data->name).'.'.$data->image->extension();
      $path = 'img/product/';
      $data->image->move($path, $image_name);

      $prod->image  = $path.$image_name ;
    }


    $prod->save();


    if($prod->has_goute > 0){

      $this->addGoute($data->product_goute, $prod->id);

    }

    return $this->getData($prod);
  }


  // *********
  // function to update Group
  // *********
  protected function update($data_old){

    $data = json_decode($data_old->product);
    $data->image = $data_old->image;
    $data->action = $data_old->action;

    // foreach($data_prod as $elem => $val){
    //   $data[$elem] = $val;
    // }

    // return response()->json(($data->price_sell2 == ''));

    $valid = (array) $data;
    $valid['product_goute'] = [];

    // loop for product gout
    if(isset($data->product_goute)){
      foreach($data->product_goute as $elem => $value){
        $valid['product_goute'][$elem] = (array) $value;
      }
    }


    $validator = Validator::make($valid , [

      'id'          => 'required|integer|exists:products,id',
      'categorie_id'=> 'required|integer|exists:categories,id',
      'famille_id'  => 'nullable|integer|exists:familles,id|nullable',
      'name'        => ['required', 'min:3', 'max:40', 'string',
                        Rule::unique('products')->ignore($data->id),],
      'name_ar'     => 'nullable|min:3|max:40|string',
      'code_bare'   => ['nullable', 'integer', 'nullable',
                        Rule::unique('products')->ignore($data->id),],
      'description' => 'nullable|string|max:150',
      'image'       => 'nullable|sometimes',
      'method_price'=> 'required|in:unite,cartone',
      'price_buy'   => 'required|regex:/^\d*\.?\d*$/',
      'qte_uc'      => 'required|integer',
      'price_sell1' => 'required|regex:/^\d*\.?\d*$/|max:9999',
      'price_sell2' => 'nullable|regex:/^\d*\.?\d*$/|max:9999',
      'price_sell3' => 'nullable|regex:/^\d*\.?\d*$/|max:9999',
      'qte_sell2'   => 'nullable|integer',
      'qte_sell3'   => 'nullable|integer',
      'in_stock'    => 'required|integer|in:0,1',
      'status'      => 'required|integer|in:0,1',
      'rank'        => 'required|integer|max:999',
      'weight'      => 'required|regex:/^\d*\.?\d*$/|max:999',
      'has_goute'   => 'nullable|integer',
      'has_discount'=> 'nullable|integer|in:0,1',
      'product_goute.*.goute'   => 'required|string|max:15|min:2',
      'product_goute.*.in_stock'=> 'required|integer|in:0,1',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors(), 'action' => $data->name];
    }
    // $elem = $data->product_goute[0];
    // return response()->json( $elem->edite );

    $updated = [
      'categorie_id' => $data->categorie_id,
      'famille_id'   => isset($data->famille_id) ? $data->famille_id : null,
      'name'         => $data->name,
      'name_ar'      => isset($data->name_ar) ? $data->name_ar : null,
      'code_bare'    => isset($data->code_bare) && $data->code_bare ? $data->code_bare : null,
      'description'  => isset($data->description) ? $data->description : null,
      'method_price' => $data->method_price,
      'method_qte'   => ( $data->method_price == 'unite') ? $data->qte_uc : 1 ,
      'price_buy'    => $data->price_buy,
      'qte_uc'       => isset($data->qte_uc) && $data->qte_uc ? $data->qte_uc : null,
      'price_sell1'  => $data->price_sell1,
      'price_sell2'  => isset($data->price_sell2) && $data->price_sell2 ? $data->price_sell2 : null,
      'price_sell3'  => isset($data->price_sell3) && $data->price_sell3 ? $data->price_sell3 : null,
      'qte_sell2'    => isset($data->qte_sell2) && $data->qte_sell2 ? $data->qte_sell2 : null,
      'qte_sell3'    => isset($data->qte_sell3) && $data->qte_sell3 ? $data->qte_sell3 : null,
      'in_stock'     => $data->in_stock,
      'status'       => $data->status,
      'rank'         => isset($data->rank) && $data->rank ? $data->rank : 0,
      'weight'       => isset($data->weight) && $data->weight ? $data->weight : 0,
      'has_goute'    => isset($data->product_goute) ? count($data->product_goute) : 0,
      'has_discount' => isset($data->has_discount) && $data->has_discount  ? $data->has_discount : 0,
    ];

    $img = array('image' => $data->image);
    $img_validator = Validator::make($img, [
      'image' => 'image|mimes:jpeg,jpg,png,gif,webp|required',
    ]);

    if(!$img_validator->fails()){

      // move old image to deleted folder
      $img = Product::select('image')->where('id', $data->id)->get();

      if(file_exists($img[0]->image)){   // if image exists delete it
        $img_from = $img[0]->image;
        $img_to = str_replace('img/product', 'img/deleted',$img[0]->image);
        rename($img_from , $img_to );
      }

      // set current image to product folder
      $image_name = time().'_'.str_replace(' ', '-',$data->name).'.'.$data->image->extension();
      $path = 'img/product/';
      $data->image->move($path, $image_name);

      $updated['image'] = $path.$image_name;
    }

    Product::where('id', $data->id)
            ->update($updated);    //find element



    // send update to Goute Controller
    if(isset($data->product_goute)){
      $this->updateGoute($data->product_goute, $data->id);
    }

    return $this->getData($data);
  }


  // *********
  // update stock product
  public function update_stock($data){
    $data->stock;
    $new_stock = $data->stock == 1 ? 0 : 1;

    if($data->id){
      Product::where('id', '=', $data->id)
              ->update(['in_stock' => $new_stock]);
      return ['status' => $new_stock];

    }else{
      return ['status' => 'error'];
    }
  }



  // ***********
  // function delete group
  // ***********
  protected function delete($data){

    $validator = Validator::make($data->all(), [
      'id' => 'integer|required|exists:products,id',
    ]);

    if($validator->fails()) {
      return ['status'=> 'error', 'errors'=> $validator->errors()];
    }
    $product = Product::where('id', $data->id)->delete();

    if($product){
      return ['status'=> 'done'];

    }else{
      return ['status'=> 'error', 'data' => $data];
    }


  }


  // function for Gout Poroduct
  public function addGoute($goutes, $id) {

    foreach($goutes as $elem){
      $prod_goute = new ProductGoute();

      $prod_goute->product_id = $id;

      $prod_goute->goute = $elem->goute;
      $prod_goute->in_stock = $elem->in_stock;

      $prod_goute->save();
    }

  }

  public function updateGoute($goutes, $id){
    $i = 0;
    foreach($goutes as $elem){

      // if($i == 1){return response()->json( isset($elem->edite) ) ;};
      if(!isset($elem->id)){
        $this->addGoute([$elem], $id);

      }elseif($elem->id && isset($elem->edite) && $elem->edite == 'edite'){

        ProductGoute::where('id', $elem->id)
                  ->update(['goute' => $elem->goute,
                            'in_stock' => $elem->in_stock,
                            'discount' => $elem->discount ]);



      }elseif($elem->id && isset($elem->edite) && $elem->edite == 'delete'){
        ProductGoute::where('id', $elem->id)->delete();
      }
      $i++;
    }
  }

  // *******
  // search product
  public function search($data){
    $string = $data->str;
    $method = $data->method;

    $resulte = Product::where($method, "like", "%{$string}%")
                        ->orderby($method, "ASC")
                        ->paginate(20);

    foreach($resulte as $elem){
      $elem->product_goute ;
    }
    return $resulte;
  }

}
