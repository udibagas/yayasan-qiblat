<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramPackage extends Model
{
    protected $fillable = [
        'program_id', 
        'name_id', 'description_id', 
        'name_en', 'description_en', 
        'name_ar', 'description_ar', 
        'price', 'flexible_amount'
    ];

    protected $appends = ['prices'];

    protected $with = ['program'];

    protected $casts = [
        'flexible_amount' => 'boolean'
    ];

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

    public function getPricesAttribute() {
        $prices = [];
        foreach (CurrencyRate::all() as $c) {
            $prices[$c->currency] = $this->price * $c->rate;
        }

        return $prices;
    }
}
