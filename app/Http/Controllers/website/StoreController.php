<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Categorie;
use App\Models\Famille;
use App\Models\Order;
use App\Models\Product;

class StoreController extends Controller
{
  public function default(Request $req){

    $user = auth()->user();

    // return response()->json($user);
    // to getDat from  database
    if($req->action == 'getData' ){
      return response()->json( $this->getData($req) );

    // to help Info from  database
    }elseif($req->action == 'getHelpInfo' ){
      // return response()->json($user);
        return response()->json( $this->getHelpInfo($req) );

    }elseif($req->action == 'search'){
      return response()->json( $this->search($req) );


    }elseif($req->action == 'getOrder'){
      // return response()->json();
      return response()->json( $this->getOrder($user) );

      // to add group
    } elseif($req->action == 'addOrder'){
      return response()->json( $this->addOrder($user) );

      // to add group
    } elseif($req->action == 'addItem'){
      return response()->json( $this->addItem($req) );

        // to updat group
    } elseif($req->action == 'update' ){
      return response()->json( $this->update($req) );


      // to delet group
    } elseif($req->action == 'delete'){
        return response()->json( $this->delete($req) );

    } else {
      return response()->json(['status'=> 'permition']);
    }

  }



  public function getOrder($user){

    $order = Order::where('user_id', '=', $user->id)
                    ->where('status', '<=', 1 )->get();

    return $order;
  }



  // get order to store
  public function addOrder(){

    $order = new OrderController;
    return $order->add();
  }


  public function addItem($user){

  }


}
