<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori'];

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'kategori_id');
    }
}