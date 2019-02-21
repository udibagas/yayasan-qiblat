<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    const STATUS_PENDING = 'PENDING';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_EXPIRED = 'EXPIRED';

    protected $fillable = [
        'user_id', 'program_id', 'program_package_id', 'amount',
        'status', 'expired_at', 'confirmed_at', 'payment_method',
        'remark', 'external_id', 'merchant_name', 'billable_amount',
        'received_amount', 'xendit_fee_amount'
    ];

    public function program() {
        return $this->belongsTo(Program::class);
    }

    public function programPackage() {
        return $this->belongsTo(ProgramPackage::class);
    }

    public function scopePending($q)
    {
        return $q->where('status', self::STATUS_PENDING);
    }

    public function scopeCompleted($q)
    {
        return $q->where('status', self::STATUS_COMPLETED);
    }

    public function scopeExpired($q)
    {
        return $q->where('status', self::STATUS_EXPIRED);
    }
}
