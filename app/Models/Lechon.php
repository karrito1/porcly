<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lechon extends Model
{
    use HasFactory;

    protected $table = 'lechones';

    protected $fillable = [
        'parto_id', 'codigo', 'sexo', 'peso_nacimiento',
        'peso_destete', 'fecha_destete', 'estado', 'notas',
    ];

    protected $casts = [
        'fecha_destete' => 'date',
        'peso_nacimiento' => 'decimal:2',
        'peso_destete' => 'decimal:2',
    ];

    public function parto(): BelongsTo
    {
        return $this->belongsTo(Parto::class);
    }
}
