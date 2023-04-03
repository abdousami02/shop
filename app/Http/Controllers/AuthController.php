<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Saller;
use Symfony\Component\HttpFoundation\ServerBag;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['mobile', 'password']);

        $page = isset($_GET['permition']) ? $_GET['permition']: '';

        if (! $token = auth()->attempt($credentials)) {
          return response()->json(['status' => 'error', 'message' => 'info wrange']);


        //==============
        // login to saller
        }elseif($page == 'saller'){
          $user = auth()->user();
          $saller = Saller::where('user_id', '=', $user->id)->get();

          if(count($saller) == 0 || $user->group > 4){
            return response()->json(['status' => 'error', 'message' => 'not_saller']);
          }

          $login = new UserController;
          $login->setLogin($user);
          return $this->respondWithToken($token, $user);


        // =============
        // login to user
        }else{
          $user = auth()->user();
          if($user['status'] == 0){
            return response()->json(['status' => 'in_active']);
            // return response()->json(['message' => 'Unauthenticated.'], 401);
          }
          $login = new UserController;
          $login->setLogin($user);
          return $this->respondWithToken($token, $user);


        }

        // return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['status' => 'logged_out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
      $token = auth()->refresh();
      $user  = auth()->user();

      $page = isset($_GET['permition']) ? $_GET['permition']: '';

      if($user['status'] == 0){
        auth()->logout();
        return response()->json(['message' => 'Unauthenticated.'], 401);

      //==============
        // login to saller
      }elseif($page == 'saller'){
        $user = auth()->user();
        $saller = Saller::where('user_id', '=', $user->id)->get();

        if(count($saller) == 0 || $user->group > 4){
          return response()->json(['status' => 'error', 'message' => 'not_saller']);
        }

        $login = new UserController;
        $login->setLogin($user);
        return $this->respondWithToken($token, $user);

      }else{
        $login = new UserController;
        $login->setLogin($user);
        return $this->respondWithToken($token, $user);
      }

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'user_info'    => $user,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
