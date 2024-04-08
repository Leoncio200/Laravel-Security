<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
    ];

    // Opcionalmente, puedes especificar la tabla si es diferente a la convención
    // protected $table = 'mi_tabla_de_productos';
}
