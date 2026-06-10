<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Parto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cerda_id', 'inseminacion_id', 'fecha_parto',
        'lechones_vivos', 'lechones_muertos', 'lechones_momificados',
        'peso_camada', 'observaciones',
    ];

    protected $casts = [
        'fecha_parto' => 'date',
        'peso_camada' => 'decimal:2',
    ];

    public function cerda(): BelongsTo
    {
        return $this->belongsTo(Cerda::class);
    }

    public function inseminacion(): BelongsTo
    {
        return $this->belongsTo(Inseminacion::class);
    }

    public function lechones(): HasMany
    {
        return $this->hasMany(Lechon::class);
    }

    public function destete(): HasOne
    {
        return $this->hasOne(Destete::class);
    }

    public function totalLechones(): int
    {
        return $this->lechones_vivos + $this->lechones_muertos + $this->lechones_momificados;
    }
}
