<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertaProduccionNotification extends Notification
{
    use Queueable;

    protected $alertasPartos;
    protected $alertasCelos;
    protected $alertasVacunas;

    /**
     * Create a new notification instance.
     */
    public function __construct($alertasPartos, $alertasCelos, $alertasVacunas)
    {
        $this->alertasPartos = $alertasPartos;
        $this->alertasCelos = $alertasCelos;
        $this->alertasVacunas = $alertasVacunas;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Porcly - Reporte Diario de Alertas de Producción')
            ->greeting('Estimado Productor,')
            ->line('Le presentamos el reporte diario de alertas automatizadas para la gestión de su producción porcícola.');

        if (!empty($this->alertasPartos) && count($this->alertasPartos) > 0) {
            $mailMessage->line('--- PARTOS INMINENTES O PRÓXIMOS ---');
            foreach ($this->alertasPartos as $alerta) {
                $cerda = $alerta->cerda;
                $dias = (int) now()->diffInDays($alerta->fecha_parto_estimada, false);
                $diasText = $dias === 0 ? 'hoy' : ($dias === 1 ? 'mañana' : "en $dias días");
                $mailMessage->line("- Cerda {$cerda->codigo} ({$cerda->nombre}): Parto estimado {$diasText} ({$alerta->fecha_parto_estimada->format('d/m/Y')}).");
            }
        }

        if (!empty($this->alertasCelos) && count($this->alertasCelos) > 0) {
            $mailMessage->line('--- CELOS ESTIMADOS / RETORNOS ---');
            foreach ($this->alertasCelos as $alerta) {
                $cerda = $alerta->cerda;
                $dias = (int) now()->diffInDays($alerta->fecha_proximo_celo, false);
                $diasText = $dias === 0 ? 'hoy' : ($dias === 1 ? 'mañana' : "en $dias días");
                $mailMessage->line("- Cerda {$cerda->codigo} ({$cerda->nombre}): Celo/Retorno estimado {$diasText} ({$alerta->fecha_proximo_celo->format('d/m/Y')}).");
            }
        }

        if (!empty($this->alertasVacunas) && count($this->alertasVacunas) > 0) {
            $mailMessage->line('--- VACUNACIONES PENDIENTES ---');
            foreach ($this->alertasVacunas as $alerta) {
                $cerda = $alerta->cerda;
                $dias = (int) now()->diffInDays($alerta->proxima_dosis, false);
                $diasText = $dias === 0 ? 'hoy' : ($dias === 1 ? 'mañana' : "en $dias días");
                $mailMessage->line("- Cerda {$cerda->codigo} ({$cerda->nombre}): Vacuna '{$alerta->vacuna}' programada {$diasText} ({$alerta->proxima_dosis->format('d/m/Y')}).");
            }
        }

        $mailMessage->action('Acceder al Panel de Control', url('/dashboard'))
            ->line('Por favor, revise el panel de Porcly para registrar las acciones correspondientes y mantener los datos actualizados.');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
