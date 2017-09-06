<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Fruits;
use App\Transformers\FruitsTransformer;
use App\Http\Requests\StoreFruitRequest;

class FruitsController extends Controller
{
    use Helpers;

    public function index()
    {
        $fruits = Fruits::all();
        // return $this->response->array(['data' => $fruits], 200);
        return $this->collection($fruits, new FruitsTransformer);
    }

    public function show($name)
    {
        $fruit = Fruits::where('name', $name)->first();

        if (!$fruit) {
            return $this->response->errorNotFound();
        }

        return $this->item($fruit, new FruitsTransformer);
    }

    public function store(StoreFruitRequest $request)
    {
        if (Fruits::Create($request->all())) {
            return $this->response->created();
        }

        return $this->response->errorBadRequest();
    }
}
