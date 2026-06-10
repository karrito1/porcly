<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destete extends Model
{
    use HasFactory;

    protected $fillable = [
        'parto_id', 'fecha_destete', 'lechones_destetados',
        'peso_promedio', 'notas',
    ];

    protected $casts = [
        'fecha_destete' => 'date',
        'peso_promedio' => 'decimal:2',
    ];

    public function parto(): BelongsTo
    {
        return $this->belongsTo(Parto::class);
    }
}
