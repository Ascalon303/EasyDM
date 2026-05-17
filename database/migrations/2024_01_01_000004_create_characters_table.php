<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('race');
            $table->string('class');
            $table->integer('level')->default(1);
            $table->string('background')->nullable();
            $table->integer('max_hp')->default(10);
            $table->integer('current_hp')->default(10);
            $table->integer('armor_class')->default(10);
            $table->json('ability_scores')->nullable();
            $table->json('inventory')->nullable();
            $table->json('spells')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
