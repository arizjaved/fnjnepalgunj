<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommitteeContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $committeeContent = CommitteeContent::first();
        if (!$committeeContent) {
            $committeeContent = $this->createDefaultCommitteeContent();
        }
        return view('admin.committee.index', compact('committeeContent'));
    }

    private function createDefaultCommitteeContent()
    {
        return CommitteeContent::create([
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
            'created_by' => Auth::id() ?? 1,
        ]);
    }

    public function edit()
    {
        $committeeContent = CommitteeContent::first();
        if (!$committeeContent) {
            $committeeContent = CommitteeContent::create([
                'title' => 'कार्यसमिति',
                'subtitle' => 'नेपाल पत्रकार महासंघ केन्द्रीय समिति',
                'description' => '२०८१-२०८३ को कार्यकालका लागि निर्वाचित केन्द्रीय कार्यसमितिका सदस्यहरू',
                'term_info' => [
                    'कार्यकाल' => '२०८१-२०८३ (३ वर्ष)',
                    'कार्यकारी सदस्य' => '८ जना',
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
                'created_by' => Auth::id(),
            ]);
        }
        return view('admin.committee.edit', compact('committeeContent'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'term_info' => 'nullable|array',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'nullable|string',
            'section_titles' => 'nullable|array',
            'section_titles.*' => 'nullable|string',
            'contact_address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $committeeContent = CommitteeContent::first();
        if (!$committeeContent) {
            $committeeContent = new CommitteeContent();
            $validated['created_by'] = Auth::id();
        }

        $validated['updated_by'] = Auth::id();

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($committeeContent->banner_image) {
                Storage::disk('public')->delete($committeeContent->banner_image);
            }
            
            $validated['banner_image'] = $request->file('banner_image')->store('committee', 'public');
        }

        // Structure contact info
        $validated['contact_info'] = [
            'address' => $validated['contact_address'] ?? '',
            'phone' => $validated['contact_phone'] ?? '',
            'email' => $validated['contact_email'] ?? ''
        ];

        // Remove individual contact fields
        unset($validated['contact_address'], $validated['contact_phone'], $validated['contact_email']);

        // Filter out empty values from arrays
        $validated['responsibilities'] = array_filter($validated['responsibilities'] ?? []);

        $committeeContent->fill($validated);
        $committeeContent->save();

        return redirect()->route('admin.committee.index')
                        ->with('success', 'Committee page updated successfully.');
    }

    public function updateSection(Request $request)
    {
        $section = $request->input('section');
        $committeeContent = CommitteeContent::first();
        
        if (!$committeeContent) {
            return response()->json(['success' => false, 'message' => 'Committee content not found']);
        }

        try {
            switch ($section) {
                case 'basic-info':
                    $validated = $request->validate([
                        'title' => 'required|string|max:255',
                        'subtitle' => 'nullable|string|max:255',
                        'description' => 'nullable|string',
                    ]);
                    $committeeContent->fill($validated);
                    break;

                case 'term-info':
                    $validated = $request->validate([
                        'term_info_keys' => 'nullable|array',
                        'term_info_keys.*' => 'nullable|string',
                        'term_info_values' => 'nullable|array',
                        'term_info_values.*' => 'nullable|string',
                    ]);
                    
                    // Combine keys and values into associative array
                    $termInfo = [];
                    if (isset($validated['term_info_keys']) && isset($validated['term_info_values'])) {
                        $keys = array_filter($validated['term_info_keys']);
                        $values = array_filter($validated['term_info_values']);
                        
                        for ($i = 0; $i < min(count($keys), count($values)); $i++) {
                            if (!empty($keys[$i]) && !empty($values[$i])) {
                                $termInfo[$keys[$i]] = $values[$i];
                            }
                        }
                    }
                    
                    $committeeContent->term_info = $termInfo;
                    break;

                case 'responsibilities':
                    $validated = $request->validate([
                        'responsibilities' => 'nullable|array',
                        'responsibilities.*' => 'nullable|string',
                    ]);
                    $committeeContent->responsibilities = array_filter($validated['responsibilities'] ?? []);
                    break;

                case 'contact-info':
                    $validated = $request->validate([
                        'contact_address' => 'nullable|string',
                        'contact_phone' => 'nullable|string',
                        'contact_email' => 'nullable|email',
                    ]);
                    $committeeContent->contact_info = [
                        'address' => $validated['contact_address'] ?? '',
                        'phone' => $validated['contact_phone'] ?? '',
                        'email' => $validated['contact_email'] ?? ''
                    ];
                    break;

                default:
                    return response()->json(['success' => false, 'message' => 'Invalid section']);
            }

            $committeeContent->updated_by = Auth::id();
            $committeeContent->save();

            return response()->json(['success' => true, 'message' => 'Section updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}