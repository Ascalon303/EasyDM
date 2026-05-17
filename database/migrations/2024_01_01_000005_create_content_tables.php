<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creator_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['campaign_pack', 'monster', 'spell', 'item']);
            $table->decimal('price', 8, 2)->default(0);
            $table->boolean('is_premium')->default(false);
            $table->json('content_data')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('download_count')->default(0);
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });

        Schema::create('content_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('creator_contents')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // monster, spell, equipment, content
            $table->string('api_index')->nullable();
            $table->string('name');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('campaign_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('joined_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_players');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('content_reviews');
        Schema::dropIfExists('creator_contents');
    }
};
