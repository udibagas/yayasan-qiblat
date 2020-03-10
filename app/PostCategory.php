<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $fillable = [
        'name_id', 'name_en', 'name_ar',
        'description_id', 'description_en', 'description_ar',
        'parent_id', 'image',
        'slug_id', 'slug_en', 'slug_ar'
    ];

    protected $casts = ['parent_id' => 'integer'];

    protected $with = ['children'];

    protected $appends = ['label'];

    public function children() {
        return $this->hasMany(PostCategory::class, 'parent_id', 'id');
    }

    public function getLabelAttribute()
    {
        return $this->name_id;
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

    public function getSlugAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->slug_en;
        }

        if ($locale == 'ar') {
            return $this->slug_ar;
        }

        return $this->slug_id;
    }
}
