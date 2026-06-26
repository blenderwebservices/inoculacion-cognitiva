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
        Schema::create('ai_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_vendor_id')->constrained('ai_vendors')->onDelete('cascade');
            $table->string('key');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ai_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('ai_vendor_id')->constrained('ai_vendors')->onDelete('cascade');
            $table->string('api_key')->nullable();
            $table->string('base_url')->nullable();
            $table->foreignId('ai_model_id')->nullable()->constrained('ai_models')->onDelete('set null');
            $table->boolean('is_default')->default(false);
            $table->boolean('web_search_enabled')->default(false);
            $table->text('system_prompt')->nullable();
            
            // HCS specific columns (replacing bots.json properties)
            $table->double('temperature')->default(1.0);
            $table->double('presence_penalty')->default(0.0);
            $table->json('target_lies')->nullable();
            $table->text('description')->nullable();
            $table->string('creator')->default('Anónimo');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_providers');
        Schema::dropIfExists('ai_models');
        Schema::dropIfExists('ai_vendors');
    }
};
