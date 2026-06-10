<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cerda_id')->constrained('cerdas')->cascadeOnDelete();
            $table->foreignId('inseminacion_id')->nullable()->constrained('inseminaciones')->nullOnDelete();
            $table->date('fecha_parto');
            $table->unsignedInteger('lechones_vivos')->default(0);
            $table->unsignedInteger('lechones_muertos')->default(0);
            $table->unsignedInteger('lechones_momificados')->default(0);
            $table->decimal('peso_camada', 8, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('partos'); }
};
