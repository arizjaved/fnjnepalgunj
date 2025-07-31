<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MediaCategory;
use App\Models\PhotoGallery;
use App\Models\VideoGallery;

class MediaSeeder extends Seeder
{
    public function run()
    {
        // Create media categories
        $categories = [
            [
                'name' => 'संस्थागत',
                'slug' => 'institutional',
                'description' => 'संस्थागत कार्यक्रम र गतिविधिहरू',
                'type' => 'both',
                'is_active' => true,
            ],
            [
                'name' => 'कार्यक्रम',
                'slug' => 'programs',
                'description' => 'विभिन्न कार्यक्रमहरू',
                'type' => 'both',
                'is_active' => true,
            ],
            [
                'name' => 'तालिम',
                'slug' => 'training',
                'description' => 'तालिम र कार्यशालाहरू',
                'type' => 'both',
                'is_active' => true,
            ],
            [
                'name' => 'सम्मेलन',
                'slug' => 'conference',
                'description' => 'सम्मेलन र बैठकहरू',
                'type' => 'both',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            MediaCategory::create($categoryData);
        }

        // Create sample photos
        $institutionalCategory = MediaCategory::where('slug', 'institutional')->first();
        $programCategory = MediaCategory::where('slug', 'programs')->first();

        $photos = [
            [
                'title' => 'नेपाल पत्रकार महासंघको वार्षिक सम्मेलन २०८०',
                'slug' => 'annual-conference-2080',
                'description' => 'नेपाल पत्रकार महासंघको वार्षिक सम्मेलनको तस्बिर',
                'image_path' => 'photo-gallery/sample1.jpg',
                'image_alt' => 'Annual Conference 2080',
                'category_id' => $institutionalCategory->id,
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'title' => 'पत्रकारिता तालिम कार्यक्रम',
                'slug' => 'journalism-training',
                'description' => 'पत्रकारिता तालिम कार्यक्रमको तस्बिर',
                'image_path' => 'photo-gallery/sample2.jpg',
                'image_alt' => 'Journalism Training',
                'category_id' => $programCategory->id,
                'status' => 'active',
                'sort_order' => 2,
            ],
        ];

        foreach ($photos as $photoData) {
            PhotoGallery::create($photoData);
        }

        // Create sample videos
        $videos = [
            [
                'title' => 'नेपाल पत्रकार महासंघको परिचय',
                'slug' => 'fnj-introduction',
                'description' => 'नेपाल पत्रकार महासंघको संक्षिप्त परिचय',
                'youtube_embed_code' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'youtube_video_id' => 'dQw4w9WgXcQ',
                'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'duration' => '5:30',
                'category_id' => $institutionalCategory->id,
                'status' => 'active',
                'sort_order' => 1,
                'views' => 150,
            ],
            [
                'title' => 'डिजिटल पत्रकारिता सेमिनार',
                'slug' => 'digital-journalism-seminar',
                'description' => 'डिजिटल पत्रकारिता सम्बन्धी सेमिनार',
                'youtube_embed_code' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'youtube_video_id' => 'dQw4w9WgXcQ',
                'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'duration' => '12:45',
                'category_id' => $programCategory->id,
                'status' => 'active',
                'sort_order' => 2,
                'views' => 89,
            ],
        ];

        foreach ($videos as $videoData) {
            VideoGallery::create($videoData);
        }
    }
}