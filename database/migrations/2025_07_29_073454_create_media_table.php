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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Original filename
            $table->string('filename'); // Stored filename
            $table->string('path'); // Storage path
            $table->string('mime_type');
            $table->bigInteger('size'); // File size in bytes
            $table->string('type'); // image, document, video, etc.
            $table->json('metadata')->nullable(); // Additional metadata (dimensions, etc.)
            $table->string('alt_text')->nullable(); // For accessibility
            $table->text('description')->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['type', 'mime_type']);
            $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
