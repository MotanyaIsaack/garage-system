<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = ['category_id','service_id','amount'];
    protected $primaryKey = 'price_id';
    protected $table = 'tbl_pricing';

    public function service(){
        return $this->belongsTo('\App\Service','service_id','service_id');
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class,'category_id','category_id');
    }
}
