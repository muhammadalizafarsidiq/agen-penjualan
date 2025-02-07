<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    use HasFactory;

    protected $guarded = [];

    protected $table = 'barangs';

    public function detail()
    {
        return $this->hasMany(detail::class);
    }
}
