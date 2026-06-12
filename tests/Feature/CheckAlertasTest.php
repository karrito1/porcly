<?php

namespace Tests\Feature;

use App\Models\Cerda;
use App\Models\Inseminacion;
use App\Models\User;
use App\Models\Vacunacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AlertaProduccionNotification;
use Tests\TestCase;

class CheckAlertasTest extends TestCase
{
    use RefreshDatabase;

    public function test_sends_email_alerts_to_users_and_prevents_duplicates(): void
    {
        Notification::fake();

        // 1. Crear usuarios
        $user1 = User::factory()->create(['email' => 'user1@gmail.com']);
        $user2 = User::factory()->create(['email' => 'user2@gmail.com']);

        // 2. Crear Cerda
        $cerda = Cerda::create([
            'user_id' => $user1->id,
            'codigo' => 'C-001',
            'nombre' => 'Lola',
            'raza' => 'Landrace',
            'fecha_nacimiento' => now()->subYears(2),
            'estado' => 'activa',
            'numero_partos' => 0,
        ]);

        // 3. Crear registros que generen alertas
        // Alerta de parto (dentro de 3 días)
        $inseminacionParto = Inseminacion::create([
            'cerda_id' => $cerda->id,
            'fecha_inseminacion' => now()->subDays(110),
            'tipo' => 'natural',
            'fecha_parto_estimada' => now()->addDays(3),
            'exitosa' => true,
        ]);

        // Alerta de vacuna (dentro de 2 días)
        $vacuna = Vacunacion::create([
            'cerda_id' => $cerda->id,
            'fecha' => now()->subDays(5),
            'vacuna' => 'Parvovirus',
            'dosis' => '2ml',
            'proxima_dosis' => now()->addDays(2),
        ]);

        // 4. Ejecutar el comando por primera vez
        $this->artisan('app:check-alertas')
            ->expectsOutputToContain('Se encontraron 2 alertas activas en total.')
            ->expectsOutputToContain('Enviando reporte de alertas a: user1@gmail.com')
            ->expectsOutputToContain('Enviando reporte de alertas a: user2@gmail.com')
            ->assertSuccessful();

        // Verificar que la notificación fue enviada a los usuarios
        Notification::assertSentTo(
            [$user1, $user2],
            AlertaProduccionNotification::class
        );

        // Verificar que se registraron los envíos en la base de datos para evitar duplicados
        $this->assertDatabaseHas('sent_alerts', [
            'user_id' => $user1->id,
            'alert_type' => 'parto',
            'source_id' => $inseminacionParto->id,
        ]);
        $this->assertDatabaseHas('sent_alerts', [
            'user_id' => $user1->id,
            'alert_type' => 'vacuna',
            'source_id' => $vacuna->id,
        ]);

        // 5. Ejecutar el comando por segunda vez
        // No debería enviar nuevas alertas a los mismos usuarios
        Notification::fake(); // Reset fake

        $this->artisan('app:check-alertas')
            ->expectsOutputToContain('No hay nuevas alertas pendientes para el usuario user1@gmail.com')
            ->expectsOutputToContain('No hay nuevas alertas pendientes para el usuario user2@gmail.com')
            ->assertSuccessful();

        Notification::assertNothingSent();
    }
}
