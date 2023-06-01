<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AnalController extends Controller
{
  public function default(Request $req){

    $user = auth()->user();

    // to getDat from  database
    if($req->action == 'getMontProduct' ){
      return response()->json( $this->getMontProduct($req, $user) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo'){
        return $this->getHelpInfo($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }
  }


  public function getMontProduct($req, $user) {

    if($user->permition == 1){
      $products = Product::where('qte_stock', '>', 0)->select('id', 'name', 'price_buy', 'qte_stock')->get();

      $mount = 0;
      $prod= [];
      foreach($products as $elem){
        $total = $elem->price_buy * $elem->qte_stock;
        $prod[$elem->id] = ["name"=> $elem->name, "price_buy"=> $elem->price_buy,
                            "qte_stock"=> $elem->qte_stock, "total"=>$total];
        $mount += $total;
      }

      return ["product"=>$prod, "mount"=>$mount];

    }else{
      return $user;
    }

  }

}
