<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Famille;

class FamillesController extends Controller
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
              $get= true; $update= false; $add= true; $delete= false;
              break;

        case 3 :
              $get= true; $update= false; $add= false; $delete= false;
              break;

        default: break;
      }

    }else{
      $get = false; $add= false; $update= false; $delete= false;
    }


    // for get Dat from DataBase
    if($req->action == 'getData' && $get ){
        return $this->getData($req);

      // to add Famille
    } elseif($req->action == 'add' && $add){
      return $this->add($req);

        // to updat Famille
    } elseif($req->action == 'update' && $update){
      return $this->update($req);


      // to delete Famille
    } elseif($req->action == 'delete' && $delete){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }

  }


  // to get Familles from database
  public function getData(Request $data){

    if($data->id){
      $famille = Famille::where('categorie_id', $data->id)->paginate(20);

    }else{
      $famille = Famille::paginate(20);
    }
                  // ->join('categories','categories.id', '=', 'familles.categorie_id')->get();

    // foreach($famille as $elem){
    //   $elem->categorie;
    // }

    return response()->json(['data' => $famille]);
  }




  // to add Famille
  public function add(Request $data){

    $validator = Validator::make($data->all(), [
      'name'    => 'required|string|unique:familles,name|min:3|max:30',
      'categorie_id' => 'required|integer|exists:categories,id',
      'status'  => 'nullable|integer|max:1',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    $famille = new Famille();

    $famille->name         = $data->name;
    $famille->name_ar      = $data->name_ar;
    $famille->categorie_id = $data->categorie_id;
    $famille->status       = $data->status || 0;

    $famille->save();

    return response()->json(['status' => 'done']);

  }


  // to update Famille
  public function update(Request $data){

    $validator = Validator::make($data->all(), [
      'id'      => 'required|exists:familles,id',
      'name'    => ['required', 'string', 'min:3','max:"30"',
                    Rule::unique('familles')->ignore($data),],
      'categorie_id' => 'required|integer|exists:categories,id',
      'status'  => 'integer|max:1',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    Famille::where('id', $data->id)
        ->update(['name'=> $data->name, 'name_ar'=> $data->name_ar, 'status'=> $data->status]);

    return response()->json(['status'=>'done']);

  }

  // to delete
  public function delete($data){

    $validator = Validator::make($data->all(), [
      'id'      => 'required|exists:familles,id',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    $cat = Famille::where('id', $data->id)->delete();

    if($cat){
      return response()->json(['status'=> 'done']);

    }else{
      return response()->json(['status'=> 'error', 'data' => $data]);
    }

  }


}
