<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Famille;
use App\Models\Product;
use Illuminate\Http\Request;


class GuestController extends Controller
{
  public function default(Request $req){


    // return response()->json($req->action);
    // to getDat from  database
    if($req->action == 'getProduct' ){
      return response()->json( $this->getProduct($req) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' ){
        return response()->json( $this->getHelpInfo($req) );

    }elseif($req->action == 'search'){
      return response()->json( $this->search($req) );

    } else {
      return response()->json(['status'=> 'permition']);
    }

  }


  // **********
  //  function to get product
  // **********
  public function getProduct(){
    $id = '';
    $product = Product::with(array('product_goute'=>function($query){
                        $query->select()->where('in_stock', '!=', 0); }))
                        ->where([['status','!=', 0],['in_stock', '!=', 0]])
                        ->orderby("rank", "DESC")->paginate(50);    // ::get()

  return ['data'=> $product, 'status'=> 'done'];
}



  // **********
  //  function to get Help info to store
  // **********
  public function getHelpInfo($data){

    $cat   = Categorie::where('status', '!=', 0)->orderby("rank", "DESC")->get();
    $famille = Famille::where('status', '!=', 0)->orderby("rank", "DESC")->get();

    return ['categories'=> $cat, 'familles'=> $famille];
  }



  public function search($data){
    $string = $data->str;
      // $method = $data->method;

      $opt = [["status", "!=", 0], ["in_stock", "!=", 0]];
      $data->categorie_id ? array_push($opt, ["categorie_id", "=", $data->categorie_id]): '';
      $data->famille_id ? array_push($opt, ["famille_id", "=", $data->famille_id]): '';

      $opt2 = $opt;

      if($string){
        array_push($opt, ["name", "like", "%{$string}%"]);
        array_push($opt2, ["name_ar", "like", "%{$string}%"]);
      }


      $resulte = Product::where($opt)
                        ->orWhere($opt2)
                        ->with(array('product_goute'=>function($query){
                          $query->select()->where('in_stock', '!=', 0); }))
                        ->orderby("rank", "DESC")
                        ->paginate(20);

    return $resulte;
  }

}
