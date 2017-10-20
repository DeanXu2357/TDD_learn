<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Dingo\Api\Routing\Helpers;
use App\Transformers\UsersList as UsersListTransformers;

class UserController extends Controller
{
    use Helpers;

    public function index()
    {
        $users = Users::all();

        return $this->collection($users, new UsersListTransformers);
    }
}
