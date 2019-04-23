<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProgramPackage extends Model
{
    protected $fillable = [
        'program_id', 'name_id', 'description_id', 'name_en', 'description_en', 
        'name_ar', 'description_ar', 'flexible_amount', 'image', 'allow_multiple', 
        'multiple_step', 'minimum_qty'
    ];

    protected $appends = ['name', 'description', 'price'];

    protected $with = ['program', 'prices'];

    protected $casts = [
        'flexible_amount' => 'boolean'
    ];

    // yg jadi patokan dolar
    public function getPriceAttribute()
    {
        $usd = CurrencyRate::where('currency', 'USD')->first();
        if (!$usd) {
            return 0;
        }

        return DB::select("SELECT price FROM program_package_prices WHERE currency_rate_id = ?", [$usd->id])[0]->price;
    }

    public function getNameAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->name_en;
        }

        if ($locale == 'ar') {
            return $this->name_ar;
        }

        return $this->name_id;
    }

    public function getDescriptionAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->description_en;
        }

        if ($locale == 'ar') {
            return $this->description_ar;
        }

        return $this->description_id;
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // public function getPricesAttribute() {
    //     $prices = [];
    //     foreach (CurrencyRate::all() as $c) {
    //         $prices[$c->currency] = $this->price * $c->rate;
    //     }

    //     return $prices;
    // }

    public function prices() {
        return $this->hasMany(ProgramPackagePrice::class);
    }
}
