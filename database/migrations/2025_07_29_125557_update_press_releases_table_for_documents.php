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
        Schema::table('press_releases', function (Blueprint $table) {
            // Rename featured_image to document_file
            $table->renameColumn('featured_image', 'document_file');
            
            // Add document-related fields
            $table->string('document_name')->nullable()->after('content');
            $table->string('document_type')->nullable()->after('document_name');
            $table->integer('document_size')->nullable()->after('document_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('press_releases', function (Blueprint $table) {
            // Rename back to featured_image
            $table->renameColumn('document_file', 'featured_image');
            
            // Drop document-related fields
            $table->dropColumn(['document_name', 'document_type', 'document_size']);
        });
    }
};