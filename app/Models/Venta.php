<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //use HasFactory;
    protected $table = 'ventas';
    protected $fillable = ['producto_id',"cliente_id","cantidad","precio"];


    public function productos()
    {
       return $this->hasMany(Producto::class);
    }

    public function cliente()
    {
       return $this->belongsTo(Cliente::class);
    }
}
