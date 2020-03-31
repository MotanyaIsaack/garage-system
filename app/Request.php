<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'tbl_requests';
    protected $primaryKey = 'request_id';
    protected $fillable = ['user_id','category_id','services','amount'];
}
