<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * @class AuthController
 * @author ANGIE CELESTE PAEZ MONTEJO
 */

class AuthController extends Controller
{
    /**
     * @method login
     * method responsible for authenticating system users and validating credentials
     * @param email email of the person to authenticate
     * @param password password  of the person to authenticate
     * @return response formatted with authentication token
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token', 'message' => $e->getMessage()], 500);
        }

        $user = User::where('id', JWTAuth::user()->id)->with('medico', 'paciente')->first();
        return response()->json(compact('token', 'user'));
    }

    /**
     * @method logout
     * method in charge of user logout
     * @return json response success message
     */
    public function logout()
    {
        try {
          JWTAuth::invalidate(JWTAuth::getToken());
          return response()->json([
            'status' => 'success',
            'msg' => 'You have successfully logged out.'
          ]);
        } catch (JWTException $e) {
            JWTAuth::unsetToken();
            // something went wrong tries to validate a invalid token
            return response()->json([
              'status' => 'error',
              'msg' => 'Failed to logout, please try again.'
          ]);
        }
    }

         /**
     * @method logout
     * method in charge of formatting the system authentication
     * @return json response with authentication token authentication type and duration time
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
