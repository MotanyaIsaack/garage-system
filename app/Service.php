<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'tbl_services';
    protected $primaryKey = 'service_id';
    protected $fillable = ['name'];

    public function pricing(){
        return $this->hasMany('\App\Pricing','service_id','service_id');
    }
}
