<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Table name
    protected $table = 'products';
    // Primary key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = ['name', 'sku', 'price', 'status'];

    public function categories()
    {
        return $this->belongsToMany(Category::Class);
    }
}
