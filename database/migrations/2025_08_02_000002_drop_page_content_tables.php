<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'news_page_contents',
            'notice_page_contents',
            'press_release_page_contents',
            'photo_gallery_page_contents',
            'video_gallery_page_contents',
            'publication_page_contents',
            'economic_activity_page_contents',
            'membership_page_contents',
            'grievance_page_contents'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
            }
        }
    }

    public function down(): void
    {
        // We won't recreate these tables as they're being replaced by the page_sections system
    }
};