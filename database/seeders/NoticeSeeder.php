<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;
use App\Models\User;

class NoticeSeeder extends Seeder
{
    public function run()
    {
        // Get a user to assign as creator (assuming user with ID 1 exists)
        $user = User::first();
        $userId = $user ? $user->id : null;

        $notices = [
            [
                'title' => 'नेपाल पत्रकार महासंघको वार्षिक साधारण सभा सम्बन्धी सूचना',
                'slug' => 'annual-general-meeting-notice',
                'content' => 'नेपाल पत्रकार महासंघको वार्षिक साधारण सभा आगामी मंसिर १५ गते बिहान १० बजे महासंघको केन्द्रीय कार्यालयमा आयोजना गरिने भएको छ। सबै सदस्यहरूको उपस्थिति अनिवार्य रहेको छ।',
                'document_name' => 'वार्षिक साधारण सभा सूचना',
                'document_type' => 'pdf',
                'document_size' => 245760, // 240 KB
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'valid_until' => now()->addDays(30),
                'created_by' => $userId,
            ],
            [
                'title' => 'पत्रकारिता तालिम कार्यक्रम सम्बन्धी सूचना',
                'slug' => 'journalism-training-notice',
                'content' => 'नेपाल पत्रकार महासंघले आयोजना गर्ने पत्रकारिता तालिम कार्यक्रम आगामी कार्तिक २५ देखि २७ गतेसम्म काठमाडौंमा सञ्चालन हुने भएको छ। इच्छुक पत्रकारहरूले दर्ता गराउन सक्नुहुन्छ।',
                'document_name' => 'तालिम कार्यक्रम विवरण',
                'document_type' => 'pdf',
                'document_size' => 512000, // 500 KB
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'valid_until' => now()->addDays(15),
                'created_by' => $userId,
            ],
            [
                'title' => 'प्रेस स्वतन्त्रता दिवस मनाउने सम्बन्धमा',
                'slug' => 'press-freedom-day-notice',
                'content' => 'विश्व प्रेस स्वतन्त्रता दिवसको अवसरमा नेपाल पत्रकार महासंघले विभिन्न कार्यक्रम आयोजना गर्ने भएको छ। सबै सदस्यहरूको सहभागिता अपेक्षा गरिएको छ।',
                'document_name' => 'प्रेस स्वतन्त्रता दिवस कार्यक्रम',
                'document_type' => 'pdf',
                'document_size' => 180000, // 175 KB
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'valid_until' => now()->addDays(45),
                'created_by' => $userId,
            ],
            [
                'title' => 'नयाँ सदस्यता नवीकरण सम्बन्धी सूचना',
                'slug' => 'membership-renewal-notice',
                'content' => 'नेपाल पत्रकार महासंघको सदस्यता नवीकरणको समय सकिन लागेको हुनाले सबै सदस्यहरूलाई आफ्नो सदस्यता नवीकरण गर्न अनुरोध गरिएको छ।',
                'document_name' => 'सदस्यता नवीकरण फारम',
                'document_type' => 'pdf',
                'document_size' => 320000, // 312 KB
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'valid_until' => now()->addDays(60),
                'created_by' => $userId,
            ],
            [
                'title' => 'डिजिटल पत्रकारिता सेमिनार आयोजना',
                'slug' => 'digital-journalism-seminar',
                'content' => 'आधुनिक डिजिटल पत्रकारिताका विषयमा विशेष सेमिनार आयोजना गरिने भएको छ। यो सेमिनारमा राष्ट्रिय तथा अन्तर्राष्ट्रिय विज्ञहरूको सहभागिता रहनेछ।',
                'document_name' => 'डिजिटल पत्रकारिता सेमिनार',
                'document_type' => 'pdf',
                'document_size' => 450000, // 440 KB
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'valid_until' => now()->addDays(20),
                'created_by' => $userId,
            ],
            [
                'title' => 'मिडिया साक्षरता कार्यक्रम सञ्चालन',
                'slug' => 'media-literacy-program',
                'content' => 'समुदायिक स्तरमा मिडिया साक्षरता बढाउने उद्देश्यले विशेष कार्यक्रम सञ्चालन गरिने भएको छ। यस कार्यक्रममा स्थानीय पत्रकारहरूको सक्रिय सहभागिता अपेक्षा गरिएको छ।',
                'document_name' => 'मिडिया साक्षरता कार्यक्रम',
                'document_type' => 'pdf',
                'document_size' => 280000, // 273 KB
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'valid_until' => now()->addDays(25),
                'created_by' => $userId,
            ],
            [
                'title' => 'पत्रकार सुरक्षा सम्बन्धी दिशानिर्देश',
                'slug' => 'journalist-safety-guidelines',
                'content' => 'पत्रकारहरूको सुरक्षा सुनिश्चित गर्न नयाँ दिशानिर्देश जारी गरिएको छ। सबै पत्रकारहरूले यी दिशानिर्देशहरू पालना गर्न अनुरोध गरिएको छ।',
                'document_name' => 'पत्रकार सुरक्षा दिशानिर्देश',
                'document_type' => 'pdf',
                'document_size' => 380000, // 371 KB
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'valid_until' => now()->addDays(90),
                'created_by' => $userId,
            ],
            [
                'title' => 'आर्थिक सहायता कार्यक्रम घोषणा',
                'slug' => 'financial-assistance-program',
                'content' => 'आर्थिक समस्यामा परेका पत्रकारहरूका लागि विशेष आर्थिक सहायता कार्यक्रम घोषणा गरिएको छ। योग्य उम्मेदवारहरूले आवेदन दिन सक्नुहुन्छ।',
                'document_name' => 'आर्थिक सहायता आवेदन फारम',
                'document_type' => 'pdf',
                'document_size' => 195000, // 190 KB
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'valid_until' => now()->addDays(40),
                'created_by' => $userId,
            ],
        ];

        foreach ($notices as $noticeData) {
            Notice::create($noticeData);
        }
    }
}