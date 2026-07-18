<?php

namespace App\Models;

use App\Models\Concerns\HasThumbnail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasThumbnail;
    protected $table = 'services';
    protected $fillable = [];

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'uid');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
