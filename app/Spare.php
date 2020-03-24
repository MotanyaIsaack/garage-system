<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
    protected $primaryKey = 'spare_id';
    protected $table = 'tbl_spares';
    protected $fillable = ['name','stock'];
}
