<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('cerdas.index') }}" class="text-gray-500 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Ficha de la Cerda — ' . $cerda->codigo) }}
                </h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('cerdas.index', ['modal' => 'edit', 'cerda' => $cerda->id]) }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold border border-gray-300 rounded-lg shadow-sm transition-colors duration-150">
                    Editar Datos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Ficha General de la Cerda -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden mb-8">
                <div class="p-6 bg-gray-50/50 border-b border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-500 flex items-center justify-center font-bold text-lg border border-brand-200">
                            C
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-900">Código: {{ $cerda->codigo }}</h3>
                            <p class="text-xs text-gray-500 font-semibold">{{ $cerda->nombre ? 'Nombre: ' . $cerda->nombre : 'Sin nombre asignado' }}</p>
                        </div>
                    </div>
                    <div>
                        @if($cerda->estado === 'activa')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                Activa (Ciclando / Destetada)
                            </span>
                        @elseif($cerda->estado === 'gestante')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200" style="color: #d97706; background-color: #fef3c7; border-color: #fde68a;">
                                Gestante (Preñada)
                            </span>
                        @elseif($cerda->estado === 'lactante')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                Lactante (Con camada)
                            </span>
                        @elseif($cerda->estado === 'en_celo')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-purple-50 text-purple-800 border border-purple-200">
                                En Celo
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                Descarte
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Raza</span>
                        <span class="text-sm font-semibold text-gray-800 mt-1 block">{{ $cerda->raza ?? 'No registrada' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha Nacimiento</span>
                        <span class="text-sm font-semibold text-gray-800 mt-1 block">
                            {{ $cerda->fecha_nacimiento ? $cerda->fecha_nacimiento->format('d/m/Y') : 'No registrada' }}
                            @if($cerda->fecha_nacimiento)
                                <span class="text-xs text-gray-500 font-medium">({{ (int) now()->diffInMonths($cerda->fecha_nacimiento) }} meses)</span>
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Peso Actual</span>
                        <span class="text-sm font-semibold text-gray-800 mt-1 block">{{ $cerda->peso_actual ? number_format($cerda->peso_actual, 1) . ' kg' : 'No registrado' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Total Partos</span>
                        <span class="text-sm font-bold text-gray-900 mt-1 block">{{ $cerda->numero_partos }} partos registrados</span>
                    </div>
                    <div class="md:col-span-4 border-t border-gray-100 pt-4 mt-2">
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Notas del Hato</span>
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $cerda->notas ?? 'Sin observaciones adicionales.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Interfaz de Navegación por Pestañas (Tabs) -->
            <div class="mb-6 border-b border-gray-200 overflow-x-auto">
                <nav class="-mb-px flex space-x-8 min-w-max" aria-label="Tabs">
                    <button onclick="switchTab('reproduccion')" id="tab-btn-reproduccion" class="tab-btn border-brand-500 text-brand-600 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm" style="border-color: #f4b08a; color: #f4b08a;">
                        Historial Reproductivo
                    </button>
                    <button onclick="switchTab('salud')" id="tab-btn-salud" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm">
                        Alimentación y Salud
                    </button>
                    <button onclick="switchTab('registrar')" id="tab-btn-registrar" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm">
                        Registrar Eventos Clínicos
                    </button>
                </nav>
            </div>

            <!-- Contenidos de las Pestañas -->
            
            <!-- PESTAÑA 1: REPRODUCCIÓN -->
            <div id="tab-content-reproduccion" class="tab-content space-y-6">
                <!-- Inseminaciones -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Registro de Inseminaciones</h4>
                        @if($cerda->estado !== 'gestante' && $cerda->estado !== 'lactante' && $cerda->estado !== 'descarte')
                            <a href="{{ route('inseminaciones.index', ['cerda_id' => $cerda->id, 'modal' => 'create']) }}" class="text-xs font-semibold text-brand-500 hover:underline">
                                Inseminar Cerda →
                            </a>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Tipo</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Verraco</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Parto Estimado</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase text-center">Diagnóstico</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Notas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($cerda->inseminaciones as $inseminacion)
                                    <tr class="text-sm text-gray-700">
                                        <td class="py-3.5 px-4">{{ $inseminacion->fecha_inseminacion->format('d/m/Y') }}</td>
                                        <td class="py-3.5 px-4">{{ ucfirst($inseminacion->tipo) }}</td>
                                        <td class="py-3.5 px-4 font-semibold">{{ optional($inseminacion->verraco)->codigo ?? ($inseminacion->verraco ?? 'N/A') }}</td>
                                        <td class="py-3.5 px-4">{{ $inseminacion->fecha_parto_estimada->format('d/m/Y') }}</td>
                                        <td class="py-3.5 px-4 text-center">
                                            @if($inseminacion->exitosa === true)
                                                <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                                                    Gestación Confirmada
                                                </span>
                                            @elseif($inseminacion->exitosa === false)
                                                <span class="inline-flex items-center text-xs font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full">
                                                    Fallida / Retorno
                                                </span>
                                            @else
                                                <div class="flex flex-col items-center gap-1.5">
                                                    <span class="inline-flex items-center text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-0.5 rounded-full">
                                                        Pendiente
                                                    </span>
                                                    <!-- Botones rápidos de confirmación -->
                                                    <div class="flex gap-1">
                                                        <form action="{{ route('inseminaciones.confirm', $inseminacion->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="exitosa" value="1">
                                                            <button type="submit" class="text-[10px] bg-emerald-100 hover:bg-emerald-200 text-emerald-800 font-bold px-1.5 py-0.5 rounded transition-colors border border-emerald-200">
                                                                Preñada
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('inseminaciones.confirm', $inseminacion->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="exitosa" value="0">
                                                            <button type="submit" class="text-[10px] bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold px-1.5 py-0.5 rounded transition-colors border border-rose-200">
                                                                Vacía
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-gray-500">{{ $inseminacion->notas ?? 'Sin notas' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-xs text-gray-500">No hay inseminaciones registradas para esta cerda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Partos -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Historial de Partos y Camadas</h4>
                        @if($cerda->estado === 'gestante')
                            <a href="{{ route('partos.index', ['cerda_id' => $cerda->id, 'modal' => 'create']) }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                                Registrar Parto Actual →
                            </a>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Fecha Parto</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase text-center">Nacidos Vivos</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase text-center">Muertos</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase text-center">Momias</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Peso Camada</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase text-center">Destete</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($cerda->partos as $parto)
                                    <tr class="text-sm text-gray-700">
                                        <td class="py-3.5 px-4 font-semibold">{{ $parto->fecha_parto->format('d/m/Y') }}</td>
                                        <td class="py-3.5 px-4 text-center text-emerald-700 font-bold">{{ $parto->lechones_vivos }}</td>
                                        <td class="py-3.5 px-4 text-center text-rose-700 font-medium">{{ $parto->lechones_muertos }}</td>
                                        <td class="py-3.5 px-4 text-center text-amber-700">{{ $parto->lechones_momificados }}</td>
                                        <td class="py-3.5 px-4">{{ $parto->peso_camada ? number_format($parto->peso_camada, 1) . ' kg' : 'N/A' }}</td>
                                        <td class="py-3.5 px-4 text-center">
                                            @if($parto->destete)
                                                <div class="text-[11px]">
                                                    <span class="font-bold text-gray-800">{{ $parto->destete->lechones_destetados }} destetados</span>
                                                    <div class="text-gray-400">{{ $parto->destete->fecha_destete->format('d/m/Y') }}</div>
                                                </div>
                                            @else
                                                @if($cerda->estado === 'lactante')
                                                    <!-- Botón para destetar directamente -->
                                                    <button onclick="openDesteteModal({{ $parto->id }}, {{ $parto->lechones_vivos }})" class="text-[10px] bg-blue-50 hover:bg-blue-100 text-blue-800 font-bold px-2 py-1 border border-blue-200 rounded transition-colors">
                                                        Destetar
                                                    </button>
                                                @else
                                                    <span class="text-xs text-gray-400">Sin destete</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-xs text-gray-500">{{ $parto->observaciones ?? 'Sin observaciones' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 text-center text-xs text-gray-500">No hay partos registrados para esta cerda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PESTAÑA 2: ALIMENTACIÓN Y SALUD -->
            <div id="tab-content-salud" class="tab-content hidden space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Vacunas -->
                    <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Registro de Vacunación</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Vacuna</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Dosis</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Próxima Dosis</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                    @forelse($cerda->vacunaciones as $vacuna)
                                        <tr>
                                            <td class="py-3 px-4">{{ $vacuna->fecha->format('d/m/Y') }}</td>
                                            <td class="py-3 px-4 font-semibold">{{ $vacuna->vacuna }}</td>
                                            <td class="py-3 px-4">{{ $vacuna->dosis ?? 'N/A' }}</td>
                                            <td class="py-3 px-4">
                                                @if($vacuna->proxima_dosis)
                                                    <span class="inline-flex items-center text-xs font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full">
                                                        {{ $vacuna->proxima_dosis->format('d/m/Y') }}
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-4 text-center text-xs text-gray-500">No hay vacunas aplicadas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tratamientos -->
                    <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Tratamientos Veterinarios</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Diagnóstico</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Tratamiento</th>
                                        <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Medicamento</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                    @forelse($cerda->tratamientos as $tratamiento)
                                        <tr>
                                            <td class="py-3 px-4">{{ $tratamiento->fecha->format('d/m/Y') }}</td>
                                            <td class="py-3 px-4 font-semibold text-rose-700">{{ $tratamiento->diagnostico }}</td>
                                            <td class="py-3 px-4 text-xs text-gray-600">{{ $tratamiento->tratamiento }}</td>
                                            <td class="py-3 px-4">
                                                {{ $tratamiento->medicamento }}
                                                @if($tratamiento->dosis)
                                                    <span class="text-xs text-gray-400">({{ $tratamiento->dosis }})</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-4 text-center text-xs text-gray-500">No hay tratamientos médicos registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Alimentación Reciente -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Consumo de Alimento (Últimos 10 registros)</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                    <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Tipo de Alimento</th>
                                    <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Cantidad Consumida (kg)</th>
                                    <th class="py-2.5 px-4 text-xs font-bold text-gray-500 uppercase">Notas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                                @forelse($cerda->alimentos as $alimento)
                                    <tr>
                                        <td class="py-3 px-4">{{ $alimento->fecha->format('d/m/Y') }}</td>
                                        <td class="py-3 px-4 font-semibold">{{ $alimento->tipo_alimento }}</td>
                                        <td class="py-3 px-4 font-bold text-gray-900">{{ number_format($alimento->cantidad_kg, 2) }} kg</td>
                                        <td class="py-3 px-4 text-xs text-gray-500">{{ $alimento->notas ?? 'Sin notas' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-xs text-gray-500">No hay registros de alimentación recientes.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PESTAÑA 3: REGISTRAR EVENTOS CLÍNICOS -->
            <div id="tab-content-registrar" class="tab-content hidden grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Registrar Consumo de Alimento -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Log de Alimentación</h4>
                    <form action="{{ route('quick-record.alimento') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="cerda_id" value="{{ $cerda->id }}">
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Fecha</label>
                            <input type="date" name="fecha" value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-lg border-gray-200 focus:border-brand-500 focus:ring-brand-200" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Tipo de Alimento</label>
                            <select name="tipo_alimento" class="w-full text-sm rounded-lg border-gray-200 focus:border-brand-500" required>
                                <option value="Mantenimiento">Mantenimiento</option>
                                <option value="Gestación">Gestación</option>
                                <option value="Lactancia">Lactancia</option>
                                <option value="Pre-iniciador">Pre-iniciador</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Cantidad (kg)</label>
                            <input type="number" step="0.01" name="cantidad_kg" placeholder="Ej. 2.50" class="w-full text-sm rounded-lg border-gray-200" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Notas</label>
                            <textarea name="notas" rows="2" class="w-full text-xs rounded-lg border-gray-200" placeholder="Opcional..."></textarea>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 text-white text-xs font-bold rounded-lg shadow-sm transition-colors" style="background-color: #f4b08a; hover:background-color: #e39a72;">
                            Guardar Consumo
                        </button>
                    </form>
                </div>

                <!-- Registrar Vacuna -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Log de Vacunación</h4>
                    <form action="{{ route('quick-record.vacunacion') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="cerda_id" value="{{ $cerda->id }}">
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Fecha</label>
                            <input type="date" name="fecha" value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-lg border-gray-200" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Vacuna / Biológeno</label>
                            <input type="text" name="vacuna" placeholder="Ej. NeoColipor, Parvovirus..." class="w-full text-sm rounded-lg border-gray-200" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Dosis (ml)</label>
                                <input type="text" name="dosis" placeholder="2 ml" class="w-full text-sm rounded-lg border-gray-200">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Veterinario</label>
                                <input type="text" name="veterinario" placeholder="Dr. Mendoza" class="w-full text-sm rounded-lg border-gray-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Próxima Dosis (Alerta)</label>
                            <input type="date" name="proxima_dosis" class="w-full text-sm rounded-lg border-gray-200">
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 text-white text-xs font-bold rounded-lg shadow-sm transition-colors" style="background-color: #f4b08a; hover:background-color: #e39a72;">
                            Aplicar Vacuna
                        </button>
                    </form>
                </div>

                <!-- Registrar Tratamiento -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Tratamiento Veterinario</h4>
                    <form action="{{ route('quick-record.tratamiento') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="cerda_id" value="{{ $cerda->id }}">
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Fecha</label>
                            <input type="date" name="fecha" value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-lg border-gray-200" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Diagnóstico / Síntoma</label>
                            <input type="text" name="diagnostico" placeholder="Ej. Cojera, Fiebre, Mastitis..." class="w-full text-sm rounded-lg border-gray-200" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Tratamiento Realizado</label>
                            <input type="text" name="tratamiento" placeholder="Ej. Terapia analgésica, limpieza..." class="w-full text-sm rounded-lg border-gray-200" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Medicamento</label>
                                <input type="text" name="medicamento" placeholder="Ej. Flunixin" class="w-full text-sm rounded-lg border-gray-200">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Duración (Días)</label>
                                <input type="number" name="duracion_dias" placeholder="3" class="w-full text-sm rounded-lg border-gray-200">
                            </div>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 text-white text-xs font-bold rounded-lg shadow-sm transition-colors" style="background-color: #f4b08a; hover:background-color: #e39a72;">
                            Guardar Tratamiento
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <!-- MODAL DE DESTETE (Vanilla Tailwind CSS y JS) -->
    <div id="destete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDesteteModal()"></div>

            <!-- Position centering -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content Panel -->
            <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
                <div class="bg-white p-6 pb-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                            D
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider" id="modal-title">Registrar Destete de Camada</h3>
                            <p class="text-xs text-gray-500 mt-1">Completa los datos para cerrar el ciclo de lactancia de la cerda.</p>
                            
                            <form action="{{ route('quick-record.destete') }}" method="POST" class="mt-4 space-y-4">
                                @csrf
                                <input type="hidden" name="parto_id" id="destete-parto-id">

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Fecha del Destete</label>
                                    <input type="date" name="fecha_destete" value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500" required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Lechones Destetados</label>
                                        <input type="number" name="lechones_destetados" id="destete-max-lechones" min="0" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Peso Promedio (kg)</label>
                                        <input type="number" step="0.01" name="peso_promedio" placeholder="Ej. 6.5" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Notas</label>
                                    <textarea name="notes" rows="2" placeholder="Opcional..." class="w-full text-xs rounded-lg border-gray-300 focus:border-brand-500"></textarea>
                                </div>

                                <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" onclick="closeDesteteModal()" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold border border-gray-300 rounded-lg shadow-sm">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="px-4 py-2 text-white text-xs font-bold rounded-lg shadow-sm" style="background-color: #f4b08a; hover:background-color: #e39a72;">
                                        Registrar Destete
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // JS Tabs switching logic
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });
            // Show target content
            document.getElementById('tab-content-' + tabId).classList.remove('hidden');

            // Reset tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm";
                btn.style.borderColor = "";
                btn.style.color = "";
            });

            // Highlight selected button
            const selectedBtn = document.getElementById('tab-btn-' + tabId);
            selectedBtn.className = "tab-btn border-brand-500 text-brand-600 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm";
            selectedBtn.style.borderColor = "#f4b08a";
            selectedBtn.style.color = "#f4b08a";
        }

        // Destete Modal Logic
        function openDesteteModal(partoId, lechonesCount) {
            document.getElementById('destete-parto-id').value = partoId;
            document.getElementById('destete-max-lechones').value = lechonesCount;
            document.getElementById('destete-max-lechones').max = lechonesCount;
            document.getElementById('destete-modal').classList.remove('hidden');
        }

        function closeDesteteModal() {
            document.getElementById('destete-modal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
