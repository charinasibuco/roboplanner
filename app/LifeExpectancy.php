<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LifeExpectancy extends Model
{
    protected $table = "life_expectancy";
    protected $fillable = ["exact_age","sex","death_probability","number_of_lives","life_expectancy"];
}
