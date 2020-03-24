<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tbl_roles';
    protected $primaryKey = 'role_id';

    /*
    * Relationship with the users table
    */
    public function users(){
        return $this->hasMany('App\User');
    }
}
