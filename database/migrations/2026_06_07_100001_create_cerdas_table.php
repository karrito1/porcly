<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cerdas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('codigo')->unique(); // e.g. C-001
            $table->string('nombre')->nullable();
            $table->string('raza')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->decimal('peso_actual', 8, 2)->nullable();
            $table->enum('estado', ['activa', 'gestante', 'lactante', 'en_celo', 'descarte'])->default('activa');
            $table->unsignedInteger('numero_partos')->default(0);
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('cerdas'); }
};
