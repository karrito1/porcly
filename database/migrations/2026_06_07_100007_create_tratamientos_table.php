<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cerda_id')->constrained('cerdas')->cascadeOnDelete();
            $table->date('fecha');
            $table->string('diagnostico');
            $table->string('tratamiento');
            $table->string('medicamento')->nullable();
            $table->string('dosis')->nullable();
            $table->unsignedInteger('duracion_dias')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tratamientos'); }
};
