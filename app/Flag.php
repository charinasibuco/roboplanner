<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    protected $table 	= 'flag';
    protected $fillable	= ['color', 'description', 'range','wealth_score'];
    public $timestamps = false;

}
