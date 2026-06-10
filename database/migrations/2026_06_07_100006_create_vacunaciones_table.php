<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacunaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cerda_id')->constrained('cerdas')->cascadeOnDelete();
            $table->date('fecha');
            $table->string('vacuna');
            $table->string('dosis')->nullable();
            $table->date('proxima_dosis')->nullable();
            $table->string('veterinario')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('vacunaciones'); }
};
