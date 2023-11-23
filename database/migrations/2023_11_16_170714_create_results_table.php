<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pilot_id');
            $table->integer('race_id');
            $table->foreign('pilot_id')->references('id')->on('pilots');
            $table->foreign('race_id')->references('id')->on('races');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->string('race_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
