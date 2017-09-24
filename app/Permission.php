<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Permission extends Model
{
	protected $table 	= 'permissions';
    protected $fillable = ['name','label'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::updating(function($permission){
            $permission->logs()->attach(Auth::user()->id, ['module_name' => 'Permission', 'log' => Auth::user()->first_name . ' ' . Auth::user()->last_name . ' is updating ' . $permission->name]);
        });

        static::creating(function($permission){
            $permission->logs()->attach(Auth::user()->id, ['module_name' => 'Permission', 'log' => Auth::user()->first_name . ' ' . Auth::user()->last_name . ' is creating ' . $permission->name]);
        });

        static::deleting(function($permission){
            $permission->logs()->attach(Auth::user()->id, ['module_name' => 'Permession', 'log' => Auth::user()->first_name . ' ' . Auth::user()->last_name . ' is deleting ' . $permission->name]);
        });
    }

    public function Roles()
    {
    	return $this->belongsToMany(Role::class);
    }  
    public function PermissionRole()
    {
    	return $this->hasMany(PermissionRole::class);
    }

    public function logs(){
        return $this->belongsToMany(User::class, 'logs', 'module_id')
            ->withTimestamps()
            ->latest('pivot_updated_at');
    }
}