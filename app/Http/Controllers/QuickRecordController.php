<?php

namespace App\Http\Controllers;

use App\Models\Cerda;
use App\Models\Parto;
use App\Models\Alimento;
use App\Models\Vacunacion;
use App\Models\Tratamiento;
use App\Models\Destete;
use App\Events\AlertaCreada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuickRecordController extends Controller
{
    public function storeAlimento(Request $request)
    {
        $request->validate([
            'cerda_id' => 'required|exists:cerdas,id',
            'fecha' => 'required|date',
            'tipo_alimento' => 'required|string|max:100',
            'cantidad_kg' => 'required|numeric|min:0',
            'notas' => 'nullable|string',
        ]);

        Alimento::create($request->all());

        return redirect()->back()->with('success', 'Registro de alimento guardado.');
    }

    public function storeVacunacion(Request $request)
    {
        $request->validate([
            'cerda_id' => 'required|exists:cerdas,id',
            'fecha' => 'required|date',
            'vacuna' => 'required|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'proxima_dosis' => 'nullable|date|after_or_equal:fecha',
            'veterinario' => 'nullable|string|max:100',
            'notas' => 'nullable|string',
        ]);

        $vacunacion = Vacunacion::create($request->all());

        if ($vacunacion->cerda) {
            AlertaCreada::dispatch('vacuna', "Vacuna '{$vacunacion->vacuna}' aplicada", $vacunacion->cerda->codigo, $vacunacion->cerda->nombre);
        }

        $redirect = $request->filled('calendar_modal')
            ? redirect()->route('calendario.index')
            : redirect()->back();

        return $redirect->with('success', 'Registro de vacunación guardado.');
    }

    public function storeTratamiento(Request $request)
    {
        $request->validate([
            'cerda_id' => 'required|exists:cerdas,id',
            'fecha' => 'required|date',
            'diagnostico' => 'required|string|max:200',
            'tratamiento' => 'required|string|max:200',
            'medicamento' => 'nullable|string|max:100',
            'dosis' => 'nullable|string|max:50',
            'duracion_dias' => 'nullable|integer|min:1',
            'notas' => 'nullable|string',
        ]);

        Tratamiento::create($request->all());

        return redirect()->back()->with('success', 'Registro de tratamiento veterinario guardado.');
    }

    public function storeDestete(Request $request)
    {
        $request->validate([
            'parto_id' => 'required|exists:partos,id',
            'fecha_destete' => 'required|date',
            'lechones_destetados' => 'required|integer|min:0',
            'peso_promedio' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
        ]);

        $parto = Parto::findOrFail($request->parto_id);

        DB::transaction(function() use ($request, $parto) {
            // Registrar el destete
            Destete::create([
                'parto_id' => $request->parto_id,
                'fecha_destete' => $request->fecha_destete,
                'lechones_destetados' => $request->lechones_destetados,
                'peso_promedio' => $request->peso_promedio,
                'notas' => $request->notas,
            ]);

            // Actualizar lechones de este parto
            $parto->lechones()->update([
                'fecha_destete' => $request->fecha_destete,
                'peso_destete' => $request->peso_promedio,
            ]);

            // Devolver la cerda al estado activa
            $parto->cerda->update(['estado' => 'activa']);
        });

        return redirect()->back()->with('success', 'Destete registrado. La cerda ahora está activa.');
    }
}
