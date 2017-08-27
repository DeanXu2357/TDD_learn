<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Fruits;

class FruitsController extends Controller
{
    use Helpers;

    public function index()
    {
        $fruits = Fruits::all();
        return $this->response->array(['data' => $fruits], 200);
    }
}
