<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $contactContent = ContactContent::first();
        if (!$contactContent) {
            $contactContent = $this->createDefaultContactContent();
        }
        return view('admin.contact.index', compact('contactContent'));
    }

    private function createDefaultContactContent()
    {
        return ContactContent::create([
            'title' => 'सम्पर्क जानकारी',
            'subtitle' => 'हामीसँग सम्पर्क गर्न निम्न माध्यमहरू प्रयोग गर्नुहोस्',
            'description' => 'नेपाल पत्रकार महासंघसँग सम्पर्क गर्न तलका विवरणहरू प्रयोग गर्नुहोस्। हामी तपाईंको प्रश्न र सुझावहरूको स्वागत गर्छौं।',
            'contact_info' => [
                'address' => 'मिडिया भिलेज, तिलगंगा काठमाडौं',
                'phone' => '+९७७-१-५९१४७८५',
                'phone_secondary' => '+९७७-१-५९१४७२३',
                'email' => 'fnjnepalcentral@gmail.com',
                'fax' => '+९७७-१-५९१४७८५'
            ],
            'office_hours' => [
                'weekdays' => 'आइतबार - शुक्रबार: १० बजे - ५ बजे',
                'saturday' => 'शनिबार: बन्द',
                'holidays' => 'सार्वजनिक बिदाहरूमा बन्द'
            ],
            'social_links' => [
                'facebook' => '',
                'twitter' => '',
                'youtube' => '',
                'instagram' => ''
            ],
            'status' => 'active',
            'created_by' => Auth::id() ?? 1,
        ]);
    }

    public function edit()
    {
        $contactContent = ContactContent::first();
        if (!$contactContent) {
            $contactContent = $this->createDefaultContactContent();
        }
        return view('admin.contact.edit', compact('contactContent'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'contact_address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_phone_secondary' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_fax' => 'nullable|string',
            'office_weekdays' => 'nullable|string',
            'office_saturday' => 'nullable|string',
            'office_holidays' => 'nullable|string',
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'map_embed' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $contactContent = ContactContent::first();
        if (!$contactContent) {
            $contactContent = new ContactContent();
            $validated['created_by'] = Auth::id();
        }

        $validated['updated_by'] = Auth::id();

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($contactContent->banner_image) {
                Storage::disk('public')->delete($contactContent->banner_image);
            }
            
            $validated['banner_image'] = $request->file('banner_image')->store('contact', 'public');
        }

        // Structure contact info
        $validated['contact_info'] = [
            'address' => $validated['contact_address'] ?? '',
            'phone' => $validated['contact_phone'] ?? '',
            'phone_secondary' => $validated['contact_phone_secondary'] ?? '',
            'email' => $validated['contact_email'] ?? '',
            'fax' => $validated['contact_fax'] ?? ''
        ];

        // Structure office hours
        $validated['office_hours'] = [
            'weekdays' => $validated['office_weekdays'] ?? '',
            'saturday' => $validated['office_saturday'] ?? '',
            'holidays' => $validated['office_holidays'] ?? ''
        ];

        // Structure social links
        $validated['social_links'] = [
            'facebook' => $validated['social_facebook'] ?? '',
            'twitter' => $validated['social_twitter'] ?? '',
            'youtube' => $validated['social_youtube'] ?? '',
            'instagram' => $validated['social_instagram'] ?? ''
        ];

        // Remove individual fields
        unset($validated['contact_address'], $validated['contact_phone'], $validated['contact_phone_secondary'], 
              $validated['contact_email'], $validated['contact_fax'], $validated['office_weekdays'], 
              $validated['office_saturday'], $validated['office_holidays'], $validated['social_facebook'], 
              $validated['social_twitter'], $validated['social_youtube'], $validated['social_instagram']);

        $contactContent->fill($validated);
        $contactContent->save();

        return redirect()->route('admin.contact-page.index')
                        ->with('success', 'Contact page updated successfully.');
    }
}
