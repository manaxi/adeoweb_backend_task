<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    // Table name
    protected $table = 'cities';
    // Primary key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = false;

    protected $fillable = ['code', 'name', 'administrativeDivision', 'countryCode'];
}
