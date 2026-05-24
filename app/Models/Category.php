<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $guarded = [];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id')
            ->where('status', 1)
            ->orderBy('name');
    }
}
