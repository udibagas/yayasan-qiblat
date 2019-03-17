<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramPackage extends Model
{
    protected $fillable = [
        'program_id', 
        'name', 'description', 
        'name_en', 'description_en', 
        'name_ar', 'description_ar', 
        'price', 'flexible_amount'
    ];

    protected $appends = ['prices'];

    protected $with = ['program'];

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
