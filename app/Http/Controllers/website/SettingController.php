<?php

namespace App\Http\Controllers\website;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
  public function profile()
  {
    $id = auth()->user()->id;
    $info =  Users::with('store_info')->findOrFail($id);
    // dd($info);
    // $data = json_encode($data);
    return response()->json(['user' => $info]);
  }
}
