<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DatabaseMigrations as DB;

use JWTAuth;
use App\Models\Users;
use App\Models\Fruits;

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
        // 註解掉是因為每次測試都會播種一次
        // $this->seed('FruitsTableSeeder');
        $this->get('/api/fruits')
             ->assertJsonStructure([
                'data' => [
                    '*' => [
                         'name', 'color', 'weight', 'delicious'
                    ]
                ]
             ]);
    }

    /**
     * @test
     */
    public function getSpecificFruits()
    {
        $this->get('/api/fruit/banana')
            ->assertJsonStructure([
                'data' => ['id', 'name', 'color', 'weight', 'delicious']
            ]);
    }

    /**
     * @test
     */
    public function authenticateUser()
    {
        // 用工廠新創一筆users資料 帳號隨機 密碼 foo
        // TODO 缺點 每次執行測試都會創造一筆資料 之後找方法改進
        // $user = factory(\App\Models\Users::class)
        //     ->create(['password' => bcrypt('foo')]);

        // $this->post('/api/authenticate', ['email' => $user->email, 'password' => 'foo'])->assertJsonStructure(['token']);
        $this->post('/api/authenticate', ['email' => 'jacobi.dan@example.net', 'password' => 'foo'])->assertJsonStructure(['token']);
    }

    /**
     * @test
     *
     * Test: Post /api/fruits.
     */
    public function 創造新的水果()
    {
        // 用工廠新創一筆users資料 帳號隨機 密碼 foo
        // TODO 缺點 每次執行測試都會創造一筆資料 之後找方法改進
        // $user = factory(\App\Models\Users::class)
        //     ->create(['password' => bcrypt('foo')]);
        $user = Users::where('email', 'jacobi.dan@example.net')->first();


        $fruit = ['name' => 'peache', 'color' => 'peache', 'weight' => '175', 'delicious' => true];

        // $this->post('/api/fruits', $fruit, $this->headers($user))->seeStatusCode(201);
        $header = $this->headers($user);
        // TODO 這邊在header 裡放使用者資訊似乎不太優 ， 待之後改進
        $response = $this->call('POST', '/api/fruits', $fruit, [], [], $header);

        // $this->assertEquals($header, []);
        $this->assertEquals(201, $response->status());
    }

    public function headers($user = null)
    {
        $headers = ['HTTP_Accept' => 'application/json'];

        if ($user) {
            $token = JWTAuth::fromUser($user);
            //JWTAuth::setToken($token);
            $headers['HTTP_Authorization'] = 'Bearer '.$token;
        }

        return $headers;
    }

    /**
     * @test
     */
    public function 沒有認證就創造水果()
    {
        $fruit = Fruits::create(['name' => 'peache', 'color' => 'peache', 'weight' => '175', 'delicious' => true])->toArray();

        $response = $this->post('/api/fruits', $fruit);
        $this->assertEquals('401', $response->status());
    }
}
