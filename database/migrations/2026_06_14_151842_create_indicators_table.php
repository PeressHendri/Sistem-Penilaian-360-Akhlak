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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('assessment_programs')->cascadeOnDelete();
            $table->foreignId('core_value_id')->constrained('core_values');
            $table->string('nama_indikator');
            $table->text('deskripsi')->nullable();
            $table->decimal('bobot', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
