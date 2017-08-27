<?php

namespace App\Transformers;

use App\Models\Fruits;
use League\Fractal\TransformerAbstract;

class FruitsTransformer extends TransformerAbstract
{
    public function transform(Fruits $fruit)
    {
        return [
            'id'        => (int)$fruit->id,
            'name'      => ucfirst($fruit->name),
            'color'     => ucfirst($fruit->color),
            'weight'    => $fruit->weight . ' grams',
            'delicious' => (bool) $fruit->delicious,
        ];
    }
}
