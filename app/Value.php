<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $table = "values";
    protected $fillable = ["name","slug","description","value"];

    public function getFillable(){
    	return $this->fillable;
    }
}
