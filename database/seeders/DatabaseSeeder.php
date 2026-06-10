<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cerda;
use App\Models\Inseminacion;
use App\Models\Parto;
use App\Models\Lechon;
use App\Models\Alimento;
use App\Models\Vacunacion;
use App\Models\Tratamiento;
use App\Models\Destete;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario por defecto
        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Productor Porcly',
                'password' => Hash::make('password'),
            ]
        );

        // Crear cerdas
        $cerdasData = [
            ['codigo' => 'C-001', 'nombre' => 'Margarita', 'raza' => 'Landrace', 'fecha_nacimiento' => '2024-03-15', 'peso_actual' => 185.50, 'estado' => 'activa', 'numero_partos' => 2, 'notas' => 'Buena madre, dócil.'],
            ['codigo' => 'C-002', 'nombre' => 'Clara', 'raza' => 'Large White', 'fecha_nacimiento' => '2024-01-10', 'peso_actual' => 192.00, 'estado' => 'gestante', 'numero_partos' => 3, 'notas' => 'Inseminada con verraco Duroc.'],
            ['codigo' => 'C-003', 'nombre' => 'Bella', 'raza' => 'Duroc', 'fecha_nacimiento' => '2024-05-22', 'peso_actual' => 178.00, 'estado' => 'gestante', 'numero_partos' => 1, 'notas' => 'Primer parto esperado.'],
            ['codigo' => 'C-004', 'nombre' => 'Lola', 'raza' => 'Landrace', 'fecha_nacimiento' => '2023-11-05', 'peso_actual' => 205.00, 'estado' => 'lactante', 'numero_partos' => 4, 'notas' => 'Camada actual de 10 lechones.'],
            ['codigo' => 'C-005', 'nombre' => 'Fiona', 'raza' => 'Pietrain', 'fecha_nacimiento' => '2024-06-01', 'peso_actual' => 165.00, 'estado' => 'en_celo', 'numero_partos' => 0, 'notas' => 'Lista para primera inseminación.'],
            ['codigo' => 'C-006', 'nombre' => 'Rosa', 'raza' => 'Yorkshire', 'fecha_nacimiento' => '2024-02-18', 'peso_actual' => 188.00, 'estado' => 'gestante', 'numero_partos' => 2, 'notas' => 'Gestación en curso normal.'],
            ['codigo' => 'C-007', 'nombre' => 'Diana', 'raza' => 'Landrace', 'fecha_nacimiento' => '2024-04-02', 'peso_actual' => 190.50, 'estado' => 'activa', 'numero_partos' => 2, 'notas' => 'En recuperación post-destete.'],
            ['codigo' => 'C-008', 'nombre' => 'Gorda', 'raza' => 'Duroc', 'fecha_nacimiento' => '2023-08-12', 'peso_actual' => 215.00, 'estado' => 'descarte', 'numero_partos' => 6, 'notas' => 'Baja productividad en última camada.'],
            ['codigo' => 'C-009', 'nombre' => 'Nieve', 'raza' => 'Large White', 'fecha_nacimiento' => '2024-02-28', 'peso_actual' => 197.00, 'estado' => 'gestante', 'numero_partos' => 2, 'notas' => 'Parto inminente.'],
            ['codigo' => 'C-010', 'nombre' => 'Princesa', 'raza' => 'Pietrain', 'fecha_nacimiento' => '2023-12-14', 'peso_actual' => 182.00, 'estado' => 'lactante', 'numero_partos' => 3, 'notas' => 'Camada muy uniforme.'],
            ['codigo' => 'C-011', 'nombre' => 'Luna', 'raza' => 'Landrace', 'fecha_nacimiento' => '2024-07-01', 'peso_actual' => 160.00, 'estado' => 'activa', 'numero_partos' => 0, 'notas' => 'Reemplazo joven.'],
            ['codigo' => 'C-012', 'nombre' => 'Estrella', 'raza' => 'Yorkshire', 'fecha_nacimiento' => '2024-01-25', 'peso_actual' => 195.00, 'estado' => 'en_celo', 'numero_partos' => 3, 'notas' => 'Celo detectado hoy por la mañana.'],
            ['codigo' => 'C-013', 'nombre' => 'Perla', 'raza' => 'Duroc', 'fecha_nacimiento' => '2024-04-10', 'peso_actual' => 184.00, 'estado' => 'gestante', 'numero_partos' => 1, 'notas' => 'Inseminación confirmada por ecografía.'],
            ['codigo' => 'C-014', 'nombre' => 'Daisy', 'raza' => 'Large White', 'fecha_nacimiento' => '2024-03-30', 'peso_actual' => 180.00, 'estado' => 'activa', 'numero_partos' => 1, 'notas' => 'Ciclando normal.'],
            ['codigo' => 'C-015', 'nombre' => 'Rita', 'raza' => 'Landrace', 'fecha_nacimiento' => '2023-10-20', 'peso_actual' => 208.00, 'estado' => 'lactante', 'numero_partos' => 5, 'notas' => 'Próxima a destete.'],
        ];

        $cerdas = [];
        foreach ($cerdasData as $data) {
            $data['user_id'] = $user->id;
            $cerdas[$data['codigo']] = Cerda::create($data);
        }

        // Crear inseminaciones históricas y activas
        // Gestación dura 115 días
        // C-002: Inseminada hace 110 días -> Parto en 5 días
        $ins2 = Inseminacion::create([
            'cerda_id' => $cerdas['C-002']->id,
            'fecha_inseminacion' => Carbon::now()->subDays(110),
            'tipo' => 'artificial',
            'verraco' => 'DUROC-99',
            'fecha_parto_estimada' => Carbon::now()->subDays(110)->addDays(115),
            'exitosa' => true,
            'notas' => 'Confirmada por ultrasonido día 30.'
        ]);

        // C-003: Inseminada hace 113 días -> Parto en 2 días (alerta inminente)
        $ins3 = Inseminacion::create([
            'cerda_id' => $cerdas['C-003']->id,
            'fecha_inseminacion' => Carbon::now()->subDays(113),
            'tipo' => 'artificial',
            'verraco' => 'LAND-44',
            'fecha_parto_estimada' => Carbon::now()->subDays(113)->addDays(115),
            'exitosa' => true,
            'notas' => 'Primeriza.'
        ]);

        // C-006: Inseminada hace 50 días -> Parto en 65 días
        $ins6 = Inseminacion::create([
            'cerda_id' => $cerdas['C-006']->id,
            'fecha_inseminacion' => Carbon::now()->subDays(50),
            'tipo' => 'artificial',
            'verraco' => 'PIET-05',
            'fecha_parto_estimada' => Carbon::now()->subDays(50)->addDays(115),
            'exitosa' => true,
            'notas' => 'Confirmada por ecografía.'
        ]);

        // C-009: Inseminada hace 114 días -> Parto mañana
        $ins9 = Inseminacion::create([
            'cerda_id' => $cerdas['C-009']->id,
            'fecha_inseminacion' => Carbon::now()->subDays(114),
            'tipo' => 'artificial',
            'verraco' => 'YORK-88',
            'fecha_parto_estimada' => Carbon::now()->subDays(114)->addDays(115),
            'exitosa' => true,
            'notas' => 'Presenta ubres inflamadas y leche.'
        ]);

        // C-013: Inseminada hace 90 días -> Parto en 25 días
        $ins13 = Inseminacion::create([
            'cerda_id' => $cerdas['C-013']->id,
            'fecha_inseminacion' => Carbon::now()->subDays(90),
            'tipo' => 'natural',
            'verraco' => 'DUROC-VERR-1',
            'fecha_parto_estimada' => Carbon::now()->subDays(90)->addDays(115),
            'exitosa' => true,
        ]);

        // Inseminación fallida en C-012 hace 22 días -> Celo hoy (21 días ciclo promedio)
        Inseminacion::create([
            'cerda_id' => $cerdas['C-012']->id,
            'fecha_inseminacion' => Carbon::now()->subDays(22),
            'tipo' => 'artificial',
            'verraco' => 'DUROC-99',
            'fecha_parto_estimada' => Carbon::now()->subDays(22)->addDays(115),
            'fecha_proximo_celo' => Carbon::now()->subDays(22)->addDays(21), // ayer
            'exitosa' => false,
            'notas' => 'Retornó a celo.'
        ]);

        // Crear partos y lechones (para las lactantes C-004, C-010, C-015)
        // C-004: Parto hace 10 días
        $parto4 = Parto::create([
            'cerda_id' => $cerdas['C-004']->id,
            'fecha_parto' => Carbon::now()->subDays(10),
            'lechones_vivos' => 10,
            'lechones_muertos' => 1,
            'lechones_momificados' => 0,
            'peso_camada' => 14.50,
            'observaciones' => 'Parto normal y rápido.'
        ]);
        // Lechones individuales
        for ($i = 1; $i <= 10; $i++) {
            Lechon::create([
                'parto_id' => $parto4->id,
                'codigo' => 'L-C004-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'sexo' => $i % 2 == 0 ? 'macho' : 'hembra',
                'peso_nacimiento' => 1.45,
                'estado' => 'vivo',
            ]);
        }

        // C-010: Parto hace 20 días
        $parto10 = Parto::create([
            'cerda_id' => $cerdas['C-010']->id,
            'fecha_parto' => Carbon::now()->subDays(20),
            'lechones_vivos' => 12,
            'lechones_muertos' => 0,
            'lechones_momificados' => 1,
            'peso_camada' => 16.80,
            'observaciones' => 'Excelente camada.'
        ]);
        for ($i = 1; $i <= 12; $i++) {
            Lechon::create([
                'parto_id' => $parto10->id,
                'codigo' => 'L-C010-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'sexo' => $i % 3 == 0 ? 'macho' : 'hembra',
                'peso_nacimiento' => 1.40,
                'estado' => 'vivo',
            ]);
        }

        // C-015: Parto hace 25 días (ya destetados o por destetar)
        $parto15 = Parto::create([
            'cerda_id' => $cerdas['C-015']->id,
            'fecha_parto' => Carbon::now()->subDays(25),
            'lechones_vivos' => 11,
            'lechones_muertos' => 2,
            'lechones_momificados' => 0,
            'peso_camada' => 15.00,
            'observaciones' => 'Dos nacidos muertos por parto distócico.'
        ]);
        for ($i = 1; $i <= 11; $i++) {
            Lechon::create([
                'parto_id' => $parto15->id,
                'codigo' => 'L-C015-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'sexo' => $i % 2 == 0 ? 'macho' : 'hembra',
                'peso_nacimiento' => 1.36,
                'peso_destete' => 6.20,
                'fecha_destete' => Carbon::now()->subDays(2),
                'estado' => 'vivo',
            ]);
        }

        // Crear destete para C-015 (hace 2 días)
        Destete::create([
            'parto_id' => $parto15->id,
            'fecha_destete' => Carbon::now()->subDays(2),
            'lechones_destetados' => 11,
            'peso_promedio' => 6.20,
            'notas' => 'Destete a los 23 días de nacidos.'
        ]);

        // Partos históricos de otros meses (para las estadísticas mensuales)
        // Mes -1 (hace 30 días)
        $p_m1 = Parto::create([
            'cerda_id' => $cerdas['C-001']->id,
            'fecha_parto' => Carbon::now()->subDays(30),
            'lechones_vivos' => 11,
            'lechones_muertos' => 0,
            'peso_camada' => 15.20,
        ]);
        // Mes -2 (hace 60 días)
        $p_m2 = Parto::create([
            'cerda_id' => $cerdas['C-007']->id,
            'fecha_parto' => Carbon::now()->subDays(60),
            'lechones_vivos' => 12,
            'lechones_muertos' => 1,
            'peso_camada' => 16.00,
        ]);
        // Mes -3 (hace 90 días)
        $p_m3 = Parto::create([
            'cerda_id' => $cerdas['C-014']->id,
            'fecha_parto' => Carbon::now()->subDays(90),
            'lechones_vivos' => 9,
            'lechones_muertos' => 0,
            'peso_camada' => 12.80,
        ]);
        // Mes -4 (hace 120 días)
        $p_m4 = Parto::create([
            'cerda_id' => $cerdas['C-001']->id,
            'fecha_parto' => Carbon::now()->subDays(120),
            'lechones_vivos' => 13,
            'lechones_muertos' => 1,
            'peso_camada' => 18.20,
        ]);

        // Alimentación (registros de consumo para los últimos 3 días)
        foreach (['C-001', 'C-002', 'C-003', 'C-004', 'C-006', 'C-007', 'C-009', 'C-010', 'C-011', 'C-012', 'C-013', 'C-014', 'C-015'] as $cod) {
            $cerda = $cerdas[$cod];
            $baseKg = $cerda->estado === 'gestante' ? 3.0 : ($cerda->estado === 'lactante' ? 5.5 : 2.5);
            
            // Registrar consumo de ayer y hoy
            Alimento::create([
                'cerda_id' => $cerda->id,
                'fecha' => Carbon::now()->subDay(),
                'tipo_alimento' => $cerda->estado === 'lactante' ? 'Lactancia' : ($cerda->estado === 'gestante' ? 'Gestación' : 'Mantenimiento'),
                'cantidad_kg' => $baseKg + (rand(-5, 5) / 10.0),
                'notas' => 'Consumo normal.'
            ]);
            Alimento::create([
                'cerda_id' => $cerda->id,
                'fecha' => Carbon::now(),
                'tipo_alimento' => $cerda->estado === 'lactante' ? 'Lactancia' : ($cerda->estado === 'gestante' ? 'Gestación' : 'Mantenimiento'),
                'cantidad_kg' => $baseKg + (rand(-3, 3) / 10.0),
                'notas' => 'Consumo normal.'
            ]);
        }

        // Vacunaciones históricas y futuras alertas
        // Vacunación completada hace 5 días
        Vacunacion::create([
            'cerda_id' => $cerdas['C-001']->id,
            'fecha' => Carbon::now()->subDays(5),
            'vacuna' => 'Parvovirus + Leptospira (Gilt)',
            'dosis' => '2 ml',
            'proxima_dosis' => null,
            'veterinario' => 'Dr. Carlos Mendoza',
            'notas' => 'Refuerzo anual.'
        ]);

        // Vacunación próxima (Alerta en 3 días)
        Vacunacion::create([
            'cerda_id' => $cerdas['C-002']->id,
            'fecha' => Carbon::now()->subDays(20),
            'vacuna' => 'Colibacilosis (NeoColipor)',
            'dosis' => '2 ml',
            'proxima_dosis' => Carbon::now()->addDays(3), // en 3 días
            'veterinario' => 'Dr. Carlos Mendoza',
            'notas' => 'Segunda dosis pre-parto.'
        ]);

        // Vacunación próxima (Alerta en 6 días)
        Vacunacion::create([
            'cerda_id' => $cerdas['C-009']->id,
            'fecha' => Carbon::now()->subDays(21),
            'vacuna' => 'Colibacilosis (NeoColipor)',
            'dosis' => '2 ml',
            'proxima_dosis' => Carbon::now()->addDays(6), // en 6 días
            'veterinario' => 'Dr. Carlos Mendoza',
            'notas' => 'Segunda dosis pre-parto.'
        ]);

        // Tratamientos médicos
        // Tratamiento activo en C-004 (Mastitis)
        Tratamiento::create([
            'cerda_id' => $cerdas['C-004']->id,
            'fecha' => Carbon::now()->subDays(2),
            'diagnostico' => 'Mastitis leve',
            'tratamiento' => 'Antibiótico + antiinflamatorio',
            'medicamento' => 'Mastilac + Flunixin',
            'dosis' => '5 ml / 10 ml',
            'duracion_dias' => 3,
            'notas' => 'Monitorear consumo de alimento y fiebre en la ubre.'
        ]);

        // Tratamiento pasado en C-007
        Tratamiento::create([
            'cerda_id' => $cerdas['C-007']->id,
            'fecha' => Carbon::now()->subDays(15),
            'diagnostico' => 'Cojera (traumatismo leve)',
            'tratamiento' => 'Reposo y analgésico',
            'medicamento' => 'Ketoprofeno',
            'dosis' => '6 ml',
            'duracion_dias' => 3,
            'notas' => 'Recuperada por completo.'
        ]);
    }
}
