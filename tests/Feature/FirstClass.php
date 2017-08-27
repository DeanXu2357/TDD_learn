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

    /**
     * @test
     */
    public function getAllFruits()
    {
        $this->get('/api')->assertJson([
            'Fruits' => 'Delicious and healthy!'
        ]);
    }

    /**
     * @test
     */
    public function getFetchFruits()
    {
        $this->seed('FruitsTableSeeder');
        $this->get('/api/fruits')
             ->assertJsonStructure([
                'data' => [
                    '*' => [
                         'name', 'color', 'weight', 'delicious'
                    ]
                ]
             ]);
    }
}
