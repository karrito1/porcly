<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lechones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parto_id')->constrained('partos')->cascadeOnDelete();
            $table->string('codigo')->nullable();
            $table->enum('sexo', ['macho', 'hembra'])->nullable();
            $table->decimal('peso_nacimiento', 6, 2)->nullable();
            $table->decimal('peso_destete', 6, 2)->nullable();
            $table->date('fecha_destete')->nullable();
            $table->enum('estado', ['vivo', 'muerto', 'vendido', 'descarte'])->default('vivo');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('lechones'); }
};
