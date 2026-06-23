<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertaCreada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $tipo;
    public string $mensaje;
    public string $icono;
    public string $cerdaCodigo;
    public ?string $cerdaNombre;

    public function __construct(string $tipo, string $mensaje, string $cerdaCodigo, ?string $cerdaNombre = null)
    {
        $this->tipo = $tipo;
        $this->mensaje = $mensaje;
        $this->cerdaCodigo = $cerdaCodigo;
        $this->cerdaNombre = $cerdaNombre;

        $this->icono = match ($tipo) {
            'parto' => '🐷',
            'inseminacion' => '💉',
            'vacuna' => '🛡️',
            default => '🔔',
        };
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('alertas.produccion'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'alerta.creada';
    }
}
