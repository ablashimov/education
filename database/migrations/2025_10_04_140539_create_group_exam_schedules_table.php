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
        Schema::create('group_exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('exam_id')->index()->constrained()->cascadeOnDelete();
            $table->timestampTz('start_at')->index();
            $table->timestampTz('end_at');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_exam_schedules');
    }
};
