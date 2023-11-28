<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //use HasFactory;

    public function proveedor()
    {
       return $this->belongsTo(Proveedor::class);
    }

    public function venta()
    {
       return $this->belongsTo(Venta::class);
    }
}