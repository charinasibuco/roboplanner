<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WealthScoreComment extends Model
{
    protected $table = "wealth_score_comments";
    protected $fillable = ['wealth_score','list','description','trigger_score','trigger_scope'];
}
