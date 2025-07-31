<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\MembershipCategory;
use App\Models\CommitteeContent;

class CommitteeController extends Controller
{
    public function index()
    {
        // Get committee content from database
        $committeeContent = CommitteeContent::active()->first();
        
        // If no committee content exists, create default data
        if (!$committeeContent) {
            $committeeContent = CommitteeContent::create([
                'title' => 'कार्यसमिति',
                'subtitle' => 'नेपाल पत्रकार महासंघ केन्द्रीय समिति',
                'description' => '२०८१-२०८३ को कार्यकालका लागि निर्वाचित केन्द्रीय कार्यसमितिका सदस्यहरू',
                'term_info' => [
                    'कार्यकाल' => '२०८१-२०८३ (३ वर्ष)',
                    'कुल सदस्य संख्या' => '२० जना',
                    'कार्यकारी सदस्य' => '८ जना',
                    'केन्द्रीय सदस्य' => '१२ जना',
                    'निर्वाचन मिति' => '२०८१ चैत्र १५'
                ],
                'responsibilities' => [
                    'महासंघको नीति निर्माण र कार्यान्वयन',
                    'पत्रकारहरूको हक हितको संरक्षण',
                    'प्रेस स्वतन्त्रताको रक्षा र प्रवर्द्धन',
                    'पत्रकारिताको व्यावसायिक विकास',
                    'शाखा संगठनहरूको समन्वय र निर्देशन',
                    'अन्तर्राष्ट्रिय सम्बन्ध र सहकार्य'
                ],
                'contact_info' => [
                    'address' => 'काठमाडौं, नेपाल',
                    'phone' => '+977-1-4444444',
                    'email' => 'info@fnjnepal.org'
                ],
                'status' => 'active',
                'created_by' => 1,
            ]);
        }

        // Get committee members separated by executive committee status
        $executiveMembers = Membership::with('category')
                                    ->where('status', 'approved')
                                    ->where('is_executive_committee', true)
                                    ->get();
                                    
        $centralMembers = Membership::with('category')
                                  ->where('status', 'approved')
                                  ->where('is_executive_committee', false)
                                  ->orderBy('full_name')
                                  ->get();

        // Define executive committee hierarchy order
        $executiveOrder = [
            'अध्यक्ष' => 1,
            'वरिष्ठ उपाध्यक्ष' => 2,
            'उपाध्यक्षहरू' => 3,
            'उपाध्यक्ष' => 3, // Alternative spelling
            'महासचिव' => 4,
            'सचिव' => 5,
            'कोषाध्यक्ष' => 6,
        ];

        // Transform and sort executive members by hierarchy
        $executiveCommittee = $executiveMembers->map(function ($member) use ($executiveOrder) {
            // Get position title from category or position field
            $positionTitle = $member->category ? $member->category->name : $member->position;
            
            // Get the order for this position, default to 999 if not found
            $positionOrder = $executiveOrder[$positionTitle] ?? 999;
            
            return [
                'name' => $member->full_name,
                'title' => $positionTitle,
                'bio' => $member->current_workplace . ', ' . $member->experience_years . ' वर्षको अनुभव',
                'contact' => $member->email,
                'image' => $member->photo_url ?: 'https://placehold.co/200x240/0073b7/ffffff/png?text=' . urlencode(substr($member->full_name, 0, 2)),
                'position_order' => $positionOrder,
            ];
        })->sortBy([
            ['position_order', 'asc'],
            ['name', 'asc']
        ])->values();

        // Transform central members
        $centralCommittee = $centralMembers->map(function ($member) {
            return [
                'name' => $member->full_name,
                'title' => $member->category->name ?? $member->position,
                'bio' => $member->current_workplace . ', ' . $member->experience_years . ' वर्षको अनुभव',
                'contact' => $member->email,
                'image' => $member->photo_url ?: 'https://placehold.co/200x240/0073b7/ffffff/png?text=' . urlencode(substr($member->full_name, 0, 2)),
            ];
        });

        // If no members exist, create sample data from config
        if ($executiveCommittee->isEmpty() && $centralCommittee->isEmpty()) {
            $sampleMembers = collect(config('site.committee_members', []));
            $executiveCommittee = $sampleMembers->take(5)->map(function ($member) {
                return [
                    'name' => $member['name'],
                    'title' => $member['title'],
                    'bio' => $member['bio'],
                    'contact' => $member['contact'],
                    'image' => $member['image'],
                ];
            });
            $centralCommittee = $sampleMembers->skip(5)->map(function ($member) {
                return [
                    'name' => $member['name'],
                    'title' => $member['title'],
                    'bio' => $member['bio'],
                    'contact' => $member['contact'],
                    'image' => $member['image'],
                ];
            });
        }

        return view('committee', compact('executiveCommittee', 'centralCommittee', 'committeeContent'));
    }
}
