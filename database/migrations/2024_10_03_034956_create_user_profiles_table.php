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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->bigInteger('cv_id')->unsigned();
            $table->string('objective');
            $table->string('education');
            $table->string('exp');
            $table->string('language');
            $table->string('certificate');
            $table->string('skill');
            $table->string('soft_skill');
            $table->string('position');
            $table->foreign('cv_id')->references('id')->on('curriculum_vitaes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
