<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleTypes extends Model
{
    protected $table = 'tbl_vehicletypes';
    protected $primaryKey = 'type_id';
    protected $fillable = ['category_id','make','model'];

    public function vehicle_category(){
        return $this->belongsTo('App\VehicleCategory');
    }
}
