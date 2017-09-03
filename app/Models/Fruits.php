<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fruits extends Model
{
    /**
     * The table associated with the model.
     * 這個model關連到的資料表名稱
     *
     * @var string
     */
    protected $table = 'fruits';

    /**
     * 定義可被批量附值得欄位名
     *
     * @var array
     */
    protected $fillable = ['name', 'color', 'weight', 'delicious'];
}
