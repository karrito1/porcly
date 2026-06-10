<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cerda_id', 'fecha', 'tipo_alimento', 'cantidad_kg', 'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'cantidad_kg' => 'decimal:2',
    ];

    public function cerda(): BelongsTo
    {
        return $this->belongsTo(Cerda::class);
    }
}
