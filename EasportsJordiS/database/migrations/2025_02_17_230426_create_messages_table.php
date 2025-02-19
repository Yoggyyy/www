<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('subject', 100);
            $table->text('text');
            $table->boolean('readed')->default(false);
            $table->timestamps();

            // Añadimos índice para mejorar las consultas de mensajes no leídos
            $table->index('readed');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
