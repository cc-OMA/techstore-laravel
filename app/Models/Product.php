<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Review;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'image',
        'description',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}