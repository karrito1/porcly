<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cerda_id')->constrained('cerdas')->cascadeOnDelete();
            $table->date('fecha');
            $table->string('tipo_alimento');
            $table->decimal('cantidad_kg', 8, 2);
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('alimentos'); }
};
