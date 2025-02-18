<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->text('twitter')->nullable();
            $table->text('instagram')->nullable();
            $table->text('twitch')->nullable();
            $table->text('avatar')->nullable();
            $table->boolean('visible')->default(false);
            $table->string('position', 20);
            $table->integer('age');
            $table->string('victory', 10);
            $table->string('team', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
