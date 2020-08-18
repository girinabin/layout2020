<?php
namespace App\Traits;

use App\Permission;
use App\Role;

trait HasRolesAndPermissions{

    public function isAdmin()
    {
        if($this->roles->contains('slug', 'admin')){
            return true;
        }
    }

    public function posts(){
        return $this->hasMany(Post::class,'userId');
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

    public function hasRole($role){
        // dd($this->roles->contains('slug',$role));
        if(strpos($role, ',') !== false  ){
            dd('up',$role);
        }else{

            return $this->roles->contains('slug',$role);
                // dd('here');
                // return true;
        }

        return false;
    }
}
