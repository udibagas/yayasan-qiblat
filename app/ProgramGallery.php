<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramGallery extends Model
{
    protected $fillable = [
        'user_id', 'program_id', 'image_path', 
        'title', 'description',
        'title_en', 'description_en',
        'title_ar', 'description_ar',
    ];

    protected $with = ['program'];

    public function program() {
        return $this->belongsTo(Program::class);
    }
}
