<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tratamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cerda_id', 'fecha', 'diagnostico', 'tratamiento',
        'medicamento', 'dosis', 'duracion_dias', 'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function cerda(): BelongsTo
    {
        return $this->belongsTo(Cerda::class);
    }
}
