<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MpesaTransaction extends Model
{
    protected $table = 'tbl_mpesatransaction';
    protected $primaryKey = 'mpesatransaction_id';
    protected $fillable = ['MerchantRequestID','CheckoutRequestID','user_id'];
}
