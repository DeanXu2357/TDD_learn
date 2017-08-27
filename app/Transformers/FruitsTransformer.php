<?php

namespace App\Fruits;

use App\Models\Fruits;
use League\Fractal\TransformerAbstract;

class FruitsTransformer extends TransformerAbstract
{
    public function transform(Fruit $fruit)
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
