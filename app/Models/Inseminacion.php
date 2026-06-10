<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inseminacion extends Model
{
    use HasFactory;

    protected $table = 'inseminaciones';

    protected $fillable = [
        'cerda_id', 'fecha_inseminacion', 'tipo', 'verraco',
        'fecha_parto_estimada', 'fecha_proximo_celo', 'exitosa', 'notas',
    ];

    protected $casts = [
        'fecha_inseminacion' => 'date',
        'fecha_parto_estimada' => 'date',
        'fecha_proximo_celo' => 'date',
        'exitosa' => 'boolean',
    ];

    public function cerda(): BelongsTo
    {
        return $this->belongsTo(Cerda::class);
    }

    public function parto(): HasOne
    {
        return $this->hasOne(Parto::class);
    }

    public function scopeProximosPartos($query, $dias = 5)
    {
        return $query->where('exitosa', '!=', false)
            ->whereBetween('fecha_parto_estimada', [now(), now()->addDays($dias)]);
    }

    public function scopeProximosCelos($query, $dias = 3)
    {
        return $query->where('exitosa', false)
            ->whereBetween('fecha_proximo_celo', [now(), now()->addDays($dias)]);
    }

    public function diasParaParto(): ?int
    {
        if (!$this->fecha_parto_estimada) return null;
        return (int) now()->diffInDays($this->fecha_parto_estimada, false);
    }
}
