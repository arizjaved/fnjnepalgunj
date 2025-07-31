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
        Schema::table('notices', function (Blueprint $table) {
            // Rename attachment to document_file for consistency
            $table->renameColumn('attachment', 'document_file');
            
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
        Schema::table('notices', function (Blueprint $table) {
            // Rename back to attachment
            $table->renameColumn('document_file', 'attachment');
            
            // Drop document-related fields
            $table->dropColumn(['document_name', 'document_type', 'document_size']);
        });
    }
};