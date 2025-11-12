<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('fileable');
            $table->string('path')->nullable();
            $table->string('name')->nullable();
            $table->string('mime_type')->nullable();
            $table->decimal('size', 20)->nullable();
            $table->string('description')->nullable();
            $table->string('fileable_tag')->nullable();

            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
