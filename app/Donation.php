<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id', 'program_id', 'program_package_id', 'amount',
        'status', 'expired_at', 'confirmed_at', 'payment_method',
        'remark'
    ];
}
