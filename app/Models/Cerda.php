<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cerda extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'codigo', 'nombre', 'raza', 'fecha_nacimiento',
        'peso_actual', 'estado', 'numero_partos', 'notas',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'peso_actual' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inseminaciones(): HasMany
    {
        return $this->hasMany(Inseminacion::class);
    }

    public function partos(): HasMany
    {
        return $this->hasMany(Parto::class);
    }

    public function alimentos(): HasMany
    {
        return $this->hasMany(Alimento::class);
    }

    public function vacunaciones(): HasMany
    {
        return $this->hasMany(Vacunacion::class);
    }

    public function tratamientos(): HasMany
    {
        return $this->hasMany(Tratamiento::class);
    }

    public function scopeGestantes($query)
    {
        return $query->where('estado', 'gestante');
    }

    public function scopeActivas($query)
    {
        return $query->whereNotIn('estado', ['descarte']);
    }

    public function ultimaInseminacion()
    {
        return $this->inseminaciones()->latest('fecha_inseminacion')->first();
    }
}
