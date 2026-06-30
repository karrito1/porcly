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
        Schema::table('inseminaciones', function (Blueprint $table) {
            $table->foreignId('verraco_id')->nullable()->after('tipo')->constrained('verracos')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inseminaciones', function (Blueprint $table) {
            $table->dropForeign(['verraco_id']);
            $table->dropColumn('verraco_id');
        });
    }
};
