<?php

namespace Database\Seeders;

use App\Models\Publication;
use Illuminate\Database\Seeder;

class PublicationSeeder extends Seeder
{
    public function run(): void
    {
        $publications = [
            [
                'title' => 'नेपाल पत्रकार महासंघको वार्षिक प्रतिवेदन २०८०',
                'document_name' => 'annual-report-2080.pdf',
                'document_type' => 'pdf',
                'type' => 'publication',
                'status' => 'published',
                'published_at' => now()->subDays(30),
                'created_by' => 1,
            ],
            [
                'title' => 'पत्रकारिता आचारसंहिता',
                'document_name' => 'journalism-code-of-conduct.pdf',
                'document_type' => 'pdf',
                'type' => 'publication',
                'status' => 'published',
                'published_at' => now()->subDays(60),
                'created_by' => 1,
            ],
            [
                'title' => 'आर्थिक सहायता कार्यक्रम २०८०',
                'document_name' => 'economic-assistance-program-2080.pdf',
                'document_type' => 'pdf',
                'type' => 'economic_activity',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'created_by' => 1,
            ],
            [
                'title' => 'पत्रकार कल्याण कोष दिशानिर्देश',
                'document_name' => 'journalist-welfare-fund-guidelines.pdf',
                'document_type' => 'pdf',
                'type' => 'economic_activity',
                'status' => 'published',
                'published_at' => now()->subDays(45),
                'created_by' => 1,
            ],
        ];

        foreach ($publications as $publication) {
            Publication::create($publication);
        }
    }
}