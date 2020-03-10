<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title_id', 'content_id',
        'title_en', 'content_en',
        'title_ar', 'content_ar',
        'slug_id', 'slug_en', 'slug_ar',
        'post_category_id', 'image',
        'user_id', 'status', 'type'
    ];

    protected $casts = [
        'status' => 'boolean',
        'post_category_id' => 'integer'
    ];

    protected $appends = ['content'];

    protected $with = ['category'];

    public function category() {
        return $this->belongsTo(PostCategory::class, 'post_category_id', 'id');
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function getTitleAttribute($v) {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->title_en;
        }

        if ($locale == 'ar') {
            return $this->title_ar;
        }

        return $this->title_id;
    }

    public function getContentAttribute($v) {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->content_en;
        }

        if ($locale == 'ar') {
            return $this->content_ar;
        }

        return $this->content_id;
    }

    public function getSlugAttribute($v) {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->slug_en;
        }

        if ($locale == 'ar') {
            return $this->slug_ar;
        }

        return $this->slug_id;
    }

    public function scopeActive($q) {
        return $q->where('status', 1);
    }

    public function scopePost($q) {
        return $q->where('type', 'post');
    }

    public function scopePage($q) {
        return $q->where('type', 'page');
    }
}
