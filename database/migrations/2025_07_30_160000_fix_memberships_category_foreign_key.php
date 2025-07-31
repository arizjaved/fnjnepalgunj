<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Add the new foreign key constraint
            $table->foreign('category_id')->references('id')->on('membership_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Add back the old foreign key constraint
            $table->foreign('category_id')->references('id')->on('media_categories')->onDelete('set null');
        });
    }
};