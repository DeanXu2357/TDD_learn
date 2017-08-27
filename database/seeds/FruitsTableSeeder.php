<?php

use App\Models\Fruits;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FruitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard(); // 暫時取消批量附值(Mass-Assignment)

        DB::table('fruits')->delete();
        // $fruitsModel = new Fruits();
        // $fruitsModel->delete();

        $fruits =  [
            ['name' => 'apple', 'color' => 'green', 'weight' => 150, 'delicious' => true],
            ['name' => 'banana', 'color' => 'yellow', 'weight' => 116, 'delicious' => true],
            ['name' => 'strawberries', 'color' => 'red', 'weight' => 12, 'delicious' => true],
        ];

        foreach ($fruits as $fruit) {
            Fruits::create($fruit);
            // $fruitsModel->create($fruit); // 使用create Mass-Assignment
        }

        Model::reguard(); // 回復Mass-Assignment
    }
}
