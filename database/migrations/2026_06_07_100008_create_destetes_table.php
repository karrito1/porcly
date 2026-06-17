<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('destetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parto_id')->constrained('partos')->cascadeOnDelete();
            $table->date('fecha_destete');
            $table->unsignedInteger('lechones_destetados')->default(0);
            $table->decimal('peso_promedio', 6, 2)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('destetes'); }
};
