<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $fillable = [];

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'uid', 'id');
    }
}
