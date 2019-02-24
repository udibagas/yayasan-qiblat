<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'content',
        'title_en', 'content_en',
        'title_ar', 'content_ar',
        'slug', 'slug_en', 'slug_ar',
        'post_category_id', 'image',
        'user_id', 'status', 'type'
    ];

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
