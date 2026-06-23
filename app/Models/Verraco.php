<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verraco extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'nombre', 'raza', 'fecha_nacimiento',
        'peso', 'procedencia', 'notas',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'peso' => 'decimal:2',
    ];
}
