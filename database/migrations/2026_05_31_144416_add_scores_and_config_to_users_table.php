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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('governance_score')->default(0);
            $table->integer('design_score')->default(0);
            $table->string('active_provider')->default('mock');
            $table->string('gemini_api_key')->nullable();
            $table->string('gemini_model')->default('gemini-1.5-flash');
            $table->string('ollama_url')->default('http://127.0.0.1:11434');
            $table->string('ollama_model')->default('llama3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'governance_score',
                'design_score',
                'active_provider',
                'gemini_api_key',
                'gemini_model',
                'ollama_url',
                'ollama_model',
            ]);
        });
    }
};
