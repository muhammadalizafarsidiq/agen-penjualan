<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    //
    use HasFactory;


    protected $guarded = [];

    protected $table = 'customers';

    public function faktur()
    {
        return $this->hasMany(Faktur::class);
    }
}
