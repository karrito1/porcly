<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inseminaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cerda_id')->constrained('cerdas')->cascadeOnDelete();
            $table->date('fecha_inseminacion');
            $table->enum('tipo', ['natural', 'artificial'])->default('artificial');
            $table->string('verraco')->nullable();
            $table->date('fecha_parto_estimada');
            $table->date('fecha_proximo_celo')->nullable();
            $table->boolean('exitosa')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('inseminaciones'); }
};
