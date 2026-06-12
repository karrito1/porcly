<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sent_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('alert_type'); // 'parto', 'celo', 'vacuna'
            $table->unsignedBigInteger('source_id'); // ID of Inseminacion or Vacunacion
            $table->timestamp('sent_at')->useCurrent();
            
            // Unique index to prevent duplicate records
            $table->unique(['user_id', 'alert_type', 'source_id'], 'user_alert_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_alerts');
    }
};
