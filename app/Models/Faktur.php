<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'fakturs';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function detail()
    {
        return $this->hasMany(Detail::class, 'faktur_id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'faktur_id');
    }
}
