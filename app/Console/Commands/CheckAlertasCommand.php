<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Inseminacion;
use App\Models\Vacunacion;
use App\Notifications\AlertaProduccionNotification;
use Illuminate\Support\Facades\Notification;

class CheckAlertasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-alertas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica alertas de producción (partos, celos, vacunas) y envía correos electrónicos de notificación a los usuarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando verificación de alertas de producción...');

        // 1. Alertas de partos (próximos 5 días)
        $alertasPartos = Inseminacion::with('cerda')
            ->where(function ($query) {
                $query->where('exitosa', true)
                      ->orWhereNull('exitosa');
            })
            ->whereBetween('fecha_parto_estimada', [now()->subDay(), now()->addDays(5)])
            ->whereDoesntHave('parto')
            ->orderBy('fecha_parto_estimada')
            ->get();

        // 2. Alertas de celos/retornos (próximos 3 días)
        $alertasCelos = Inseminacion::with('cerda')
            ->where('exitosa', false)
            ->whereBetween('fecha_proximo_celo', [now()->subDay(), now()->addDays(3)])
            ->orderBy('fecha_proximo_celo')
            ->get();

        // 3. Alertas de vacunas (próximos 7 días)
        $alertasVacunas = Vacunacion::with('cerda')
            ->whereNotNull('proxima_dosis')
            ->whereBetween('proxima_dosis', [now(), now()->addDays(7)])
            ->orderBy('proxima_dosis')
            ->get();

        $totalAlertas = $alertasPartos->count() + $alertasCelos->count() + $alertasVacunas->count();

        if ($totalAlertas > 0) {
            $this->info("Se encontraron {$totalAlertas} alertas activas en total.");
            
            // Obtener todos los usuarios a los que notificar
            $users = User::all();

            if ($users->isEmpty()) {
                $this->warn('No hay usuarios registrados en el sistema para enviar notificaciones.');
                return Command::SUCCESS;
            }

            // Enviar notificación a todos los usuarios
            Notification::send($users, new AlertaProduccionNotification($alertasPartos, $alertasCelos, $alertasVacunas));

            $this->info('Correos de alertas enviados exitosamente a ' . $users->count() . ' usuarios.');
        } else {
            $this->info('No se encontraron alertas activas para el período actual. No se enviaron correos.');
        }

        return Command::SUCCESS;
    }
}
