<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USStock extends Model
{
    protected $table = "us_stock";
    protected $fillable = ['symbol', 'details'];
    public $timestamps = true;
}
