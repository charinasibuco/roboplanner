<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = "user_meta";
    protected $fillable = ["user_id","option","value"];
    public $timestamps = false;

    public function User()
    {
        $this->belongsTo(User::class);
    }
}
