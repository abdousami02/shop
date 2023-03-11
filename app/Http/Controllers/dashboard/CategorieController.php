<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Categorie;
use Illuminate\Validation\Rule;

class CategorieController extends Controller
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

      // to add Categorie
    } elseif($req->action == 'add' && $add){
      return $this->add($req);

        // to updat Categorie
    } elseif($req->action == 'update' && $update){
      return $this->update($req);


      // to delete Categorie
    } elseif($req->action == 'delete' && $delete){
        return $this->delete($req);

    } else {
      return response()->json(['status'=> 'permition']);
    }

  }


  // to get catigories from database
  public function getData(Request $data){

    $cat = Categorie::paginate(20);

    return response()->json(['data' => $cat]);
  }




  // to add Categorie
  public function add(Request $data){

    $validator = Validator::make($data->all(), [
      'name'    => 'required|string|unique:categories,name|min:3|max:30',
      'name_ar' => 'nullable|string|min:3|max:15',
      'status'  => 'nullable|integer|max:1',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    $cat = new Categorie();

    $cat->name = $data->name;
    $cat->name_ar = $data->name_ar;
    $cat->status = $data->status || 0;

    $cat->save();

    return response()->json(['status' => 'done']);

  }


  // to update Categorie
  public function update(Request $data){

    $validator = Validator::make($data->all(), [
      'id'      => 'required|exists:categories,id',
      'name'    => ['required', 'string', 'min:3','max:30',
                    Rule::unique('categories')->ignore($data->id, 'id'),],
      'name_ar' => 'nullable|string|min:3|max:15',
      'status'  => 'integer|max:1',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    Categorie::where('id', $data->id)
        ->update(['name'=> $data->name, 'name_ar'=> $data->name_ar, 'status'=> $data->status]);

    return response()->json(['status'=>'done']);

  }

  // to delete
  public function delete($data){

    $validator = Validator::make($data->all(), [
      'id'      => 'required|exists:categories,id',
    ]);

    if ($validator->fails()) {
      return response()->json(['status'=> 'error', 'errors'=>$validator->errors()]);
    }

    $cat = Categorie::where('id', $data->id)->delete();

    if($cat){
      return response()->json(['status'=> 'done']);

    }else{
      return response()->json(['status'=> 'error', 'data' => $data]);
    }

  }




}
