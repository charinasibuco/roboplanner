<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Category extends Model
{
    //
    protected $table    = 'categories';
    protected $fillable = ["title","slug","sort","description","parent_id"];
    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::updating(function($role){
            $role->logs()->attach(Auth::user()->id, ['module_name' => 'Category', 'log' => Auth::user()->first_name . ' ' . Auth::user()->last_name . ' is updating ' . $role->name]);
        });

        static::creating(function($role){
            $role->logs()->attach(Auth::user()->id, ['module_name' => 'Category', 'log' => Auth::user()->first_name . ' ' . Auth::user()->last_name . ' is creating ' . $role->name]);
        });

        static::deleting(function($role){
            $role->logs()->attach(Auth::user()->id, ['module_name' => 'Category', 'log' => Auth::user()->first_name . ' ' . Auth::user()->last_name . ' is deleting ' . $role->name]);
        });

    }

    public function Post()
    {
        return $this->belongsToMany(Post::class);
    }  
    public function CategoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    public function logs(){
        return $this->belongsToMany(User::class, 'logs', 'module_id')
            ->withTimestamps()
            ->latest('pivot_updated_at');
    }
}
