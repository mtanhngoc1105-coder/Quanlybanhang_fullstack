<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'parent_id'];

    // CHA -> nhiều CON (đệ quy vô hạn cấp)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
                    ->with('children'); //  QUAN TRỌNG
    }

    // CON -> thuộc CHA
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Category có nhiều Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}