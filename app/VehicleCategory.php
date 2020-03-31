<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
    protected $fillable = ['name'];
    protected $table = 'tbl_vehiclecategories';
    protected $primaryKey = 'category_id';

    public function vehicle_types(){
        return $this->hasMany('App\VehicleTypes');
    }

}
