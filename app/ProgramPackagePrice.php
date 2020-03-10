<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramPackagePrice extends Model
{
    protected $fillable = ['program_package_id', 'currency_rate_id', 'price'];

    protected $with = ['currency'];

    protected $casts = [
        // 'price' => 'decimal',
        'program_package_id' => 'integer',
        'currency_rate_id' => 'integer',
    ];

    public function currency() {
        return $this->belongsTo(CurrencyRate::class, 'currency_rate_id');
    }
}
