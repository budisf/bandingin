<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailLibrary extends Model
{
    protected $table = 'detail_libraries';

    protected $fillable = [
        'library_id','book_id', 
    ];

    public function library()
    {
        return $this->belongsTo('App\Library');
    }
    public function book()
    {
        return $this->belongsTo('App\Book');
    }

}
