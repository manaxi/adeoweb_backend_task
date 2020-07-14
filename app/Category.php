<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Table name
    protected $table = 'categories';
    // Primary key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = false;

    protected $fillable = ['name', 'weather', 'slug'];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

}
