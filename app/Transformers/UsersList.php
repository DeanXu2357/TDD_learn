<?php

namespace App\Transformers;

use App\Models\Users;
use League\Fractal\TransformerAbstract;

class UsersList extends TransformerAbstract
{
    public function transform(Users $user)
    {
        return [
            'id' => $user->id,
            'name' => ucfirst($user->name),
            'email' => ucfirst($user->email),
        ];
    }
}
