<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $table = 'libraries';

    protected $fillable = [
        'name','address'
    ];

    public function detailLibrary()
    {
        return $this->hasMany('App\DetailLibrary');
    }
    public function book()
    {
        return $this->hasMany('App\Book');
    }
}
