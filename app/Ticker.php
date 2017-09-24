<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    protected $table = "ticker";
    protected $fillable = ['name', 'symbol', 'created_at', 'updated_at'];
    public $timestamps = true;
}
