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

    public function getTitleAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->title_en;
        }

        if ($locale == 'ar') {
            return $this->title_ar;
        }

        return $v;
    }

    public function getContentAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->content_en;
        }

        if ($locale == 'ar') {
            return $this->content_ar;
        }

        return $v;
    }

    protected $with = ['program'];

    public function program() {
        return $this->belongsTo(Program::class);
    }
}
