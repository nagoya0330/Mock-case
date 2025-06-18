<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // ← この位置に追加
    protected $fillable = [
        'user_id',
        'name',
        'brand_name',
        'description',
        'condition',
        'price',
        'image_path',
        'category',
        'is_recommended',
        'is_sold',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite_items');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}