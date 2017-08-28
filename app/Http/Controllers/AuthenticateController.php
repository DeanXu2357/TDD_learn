<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    /**
     * API 登入成功後會回傳JWT Auth token
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // 排除異常情況
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTEixception $e) {
            return respose()->json(['error' => 'could_not_create_token'], 500);
        }

        // 最後所有的都對了後，回傳token
        return response()->json(compact('token')); // 這邊的$token是上邊 $token = JWTAuth::attempt()的執行結果
    }

    /**
     * 登出
     * 註銷一組token
     * 使用者不能再使用這組token
     * 若要使用token則必須重新登入，然後生成一組新token
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        // 驗證 token 欄位必須
        $this->validate($reqeust, [
            'token' => 'required'
        ]);

        JWTAuth::invalidate($request->input('token'));
    }

    /**
     * Returns the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Wxceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTexception $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
