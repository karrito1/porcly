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

            foreach ($users as $user) {
                // Filtrar alertas de partos que no hayan sido enviadas a este usuario
                $userPartos = $alertasPartos->filter(function ($alerta) use ($user) {
                    return !\Illuminate\Support\Facades\DB::table('sent_alerts')
                        ->where('user_id', $user->id)
                        ->where('alert_type', 'parto')
                        ->where('source_id', $alerta->id)
                        ->exists();
                });

                // Filtrar alertas de celos que no hayan sido enviadas a este usuario
                $userCelos = $alertasCelos->filter(function ($alerta) use ($user) {
                    return !\Illuminate\Support\Facades\DB::table('sent_alerts')
                        ->where('user_id', $user->id)
                        ->where('alert_type', 'celo')
                        ->where('source_id', $alerta->id)
                        ->exists();
                });

                // Filtrar alertas de vacunas que no hayan sido enviadas a este usuario
                $userVacunas = $alertasVacunas->filter(function ($alerta) use ($user) {
                    return !\Illuminate\Support\Facades\DB::table('sent_alerts')
                        ->where('user_id', $user->id)
                        ->where('alert_type', 'vacuna')
                        ->where('source_id', $alerta->id)
                        ->exists();
                });

                $totalUserAlertas = $userPartos->count() + $userCelos->count() + $userVacunas->count();

                if ($totalUserAlertas > 0) {
                    try {
                        $this->info("Enviando reporte de alertas a: {$user->email} ({$totalUserAlertas} alertas nuevas)...");
                        
                        // Enviar notificación a este usuario específico
                        $user->notify(new AlertaProduccionNotification($userPartos, $userCelos, $userVacunas));

                        // Registrar las alertas como enviadas para evitar duplicados
                        $insertData = [];
                        $now = now();
                        
                        foreach ($userPartos as $alerta) {
                            $insertData[] = [
                                'user_id' => $user->id,
                                'alert_type' => 'parto',
                                'source_id' => $alerta->id,
                                'sent_at' => $now,
                            ];
                        }
                        foreach ($userCelos as $alerta) {
                            $insertData[] = [
                                'user_id' => $user->id,
                                'alert_type' => 'celo',
                                'source_id' => $alerta->id,
                                'sent_at' => $now,
                            ];
                        }
                        foreach ($userVacunas as $alerta) {
                            $insertData[] = [
                                'user_id' => $user->id,
                                'alert_type' => 'vacuna',
                                'source_id' => $alerta->id,
                                'sent_at' => $now,
                            ];
                        }

                        if (!empty($insertData)) {
                            \Illuminate\Support\Facades\DB::table('sent_alerts')->insert($insertData);
                        }

                        \Illuminate\Support\Facades\Log::info("Alertas de producción enviadas exitosamente al usuario ID {$user->id} ({$user->email}). Total alertas: {$totalUserAlertas}");
                        $this->info("Reporte enviado exitosamente a {$user->email}");
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Fallo al enviar alertas de producción al usuario ID {$user->id} ({$user->email}). Error: " . $e->getMessage());
                        $this->error("Fallo al enviar reporte a {$user->email}. Error: " . $e->getMessage());
                    }
                } else {
                    $this->info("No hay nuevas alertas pendientes para el usuario {$user->email}.");
                }
            }
        } else {
            $this->info('No se encontraron alertas activas para el período actual. No se enviaron correos.');
        }

        return Command::SUCCESS;
    }
}
