<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Users;
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    use Helpers;

    public function resgister(RegisterUserRequest $request)
    {
        $newUser = new Users;
        $newUser->name = $request->input('name');
        $newUser->email = $request->input('email');
        $newUser->password = bcrypt($request->input('password'));

        if ($newUser->save()) {
            return $this->response->created();
        }

        return $this->response->errorBadRequest();
    }
}
