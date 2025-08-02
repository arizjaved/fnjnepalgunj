<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page_name'); // news, membership, publications, about, committee, contact, etc.
            $table->string('section_key'); // header_title, search_placeholder, latest_news_title, etc.
            $table->string('section_title')->nullable();
            $table->json('content'); // flexible content storage
            $table->enum('content_type', ['text', 'html', 'array', 'image'])->default('text');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['page_name', 'is_active']);
            $table->unique(['page_name', 'section_key']);
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};