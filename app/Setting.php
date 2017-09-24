<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "settings";
    protected $fillable = ['name', 'geometric_return','standard_deviation','max_drawdown','absolute_value','annual_return_rate'];
    public $timestamps = false;
}
