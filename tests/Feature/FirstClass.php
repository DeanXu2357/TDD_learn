<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DatabaseMigrations as DB;

class FirstClass extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function 取得水果列表()
    {
        $this->get('/api')->seeJson([
            'Fruits' => 'Delicious and healthy!'
        ]);
    }

    public function 取得對應水果資料()
    {
        $this->seed('FruitsTableSeeder');
        $this->get('/api/fruits')
             ->seeJsonStructure();
    }
}
