<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacunacion extends Model
{
    use HasFactory;

    protected $table = 'vacunaciones';

    protected $fillable = [
        'cerda_id', 'fecha', 'vacuna', 'dosis',
        'proxima_dosis', 'veterinario', 'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'proxima_dosis' => 'date',
    ];

    public function cerda(): BelongsTo
    {
        return $this->belongsTo(Cerda::class);
    }
}
