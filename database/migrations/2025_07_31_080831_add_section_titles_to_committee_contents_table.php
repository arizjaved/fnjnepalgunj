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
        Schema::table('committee_contents', function (Blueprint $table) {
            $table->json('section_titles')->nullable()->after('contact_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committee_contents', function (Blueprint $table) {
            $table->dropColumn('section_titles');
        });
    }
};
