<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'name', 'category_id', 'author'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function detailLibrary()
    {
        return $this->hasMany('App\DetailLibrary');
    }

    public function library()
    {
        return $this->hasMany('App\Library');
    }

}
