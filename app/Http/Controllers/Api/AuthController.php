<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth management
 *
 * APIs for JWT auth
 */
class AuthController extends \App\Http\Controllers\Controller
{
    /**
     * Register
     *
     * Регистрация пользователя. Пока что полей всего 3
     *
     * @bodyParam email string required User email. Example: jack@daniels.com
     * @bodyParam password string required User Password. Example: jacky
     * @bodyParam password_confirmation string required User Password Confirmation. Example: jacky
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([], 200);
    }

    /**
     * Login
     *
     * В случае успеха будет возвращен заголовок <b style='color: red;'>```Authorization```</b>, в котором будет содержаться токен
     *
     * @bodyParam email string required User email. Example: belitskii@gmail.com
     * @bodyParam password string required User Password. Example: asdasd
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'user_not_found'], 401);
    }

    /**
     * Logout
     *
     * @authenticated
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([], 200);
    }

    /**
     * User data
     *
     * Получение данных о текущем залогиненном пользователе
     *
     * @authenticated
     */
    public function user(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        return response()->json($user);
    }

    /**
     * Token refresh
     *
     * В случае успеха будет возвращен заголовок <b style='color: red;'>```Authorization```</b>, в котором будет содержаться токен
     *
     * @authenticated
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()->json()->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
