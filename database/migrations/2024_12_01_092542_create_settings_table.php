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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('button_color')->default('#5A080C');
            $table->string('background_color')->default('#ffffff');
            $table->string('input_color')->default('#5A080C');
            $table->string('text_color')->default('#5A080C');
            $table->string('icon_color')->default('#5A080C');
            $table->string('sidebar_background')->default('#F2F2F2');
            $table->string('navbar_background')->default('#F2F2F2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
