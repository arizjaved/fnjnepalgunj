<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aboutPage = AboutPage::first();
        if (!$aboutPage) {
            $aboutPage = $this->createDefaultAboutPage();
        }
        return view('admin.about.index', compact('aboutPage'));
    }

    public function edit()
    {
        $aboutPage = AboutPage::first();
        if (!$aboutPage) {
            $aboutPage = $this->createDefaultAboutPage();
        }
        return view('admin.about.edit', compact('aboutPage'));
    }

    private function createDefaultAboutPage()
    {
        // Get default data from config
        $defaultData = config('site.about_page_data');
        
        return AboutPage::create([
            'title' => 'हाम्रो बारेमा',
            'main_content' => $defaultData['main_content'] ?? [],
            'vision' => $defaultData['vision_mission']['vision'] ?? '',
            'mission' => $defaultData['vision_mission']['mission'] ?? [],
            'objectives' => $defaultData['objectives'] ?? [],
            'quick_facts' => $defaultData['sidebar']['quick_facts']['facts'] ?? [],
            'leadership_positions' => $defaultData['sidebar']['leadership']['positions'] ?? [],
            'status' => 'active',
            'created_by' => Auth::id(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'main_content' => 'required|array',
            'main_content.*' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|array',
            'mission.*' => 'nullable|string',
            'objectives' => 'nullable|array',
            'objectives.*' => 'nullable|string',
            'quick_facts' => 'nullable|array',
            'quick_facts.*' => 'nullable|string',
            'leadership_positions' => 'nullable|array',
            'leadership_positions.*' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $aboutPage = AboutPage::first();
        if (!$aboutPage) {
            $aboutPage = new AboutPage();
            $validated['created_by'] = Auth::id();
        }

        $validated['updated_by'] = Auth::id();

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Delete old image if exists
            if ($aboutPage->hero_image) {
                Storage::disk('public')->delete($aboutPage->hero_image);
            }
            
            $validated['hero_image'] = $request->file('hero_image')->store('about', 'public');
        }

        // Filter out empty values from arrays
        $validated['main_content'] = array_filter($validated['main_content'] ?? []);
        $validated['mission'] = array_filter($validated['mission'] ?? []);
        $validated['objectives'] = array_filter($validated['objectives'] ?? []);
        $validated['quick_facts'] = array_filter($validated['quick_facts'] ?? []);
        $validated['leadership_positions'] = array_filter($validated['leadership_positions'] ?? []);

        $aboutPage->fill($validated);
        $aboutPage->save();

        return redirect()->route('admin.about.index')
                        ->with('success', 'About page updated successfully.');
    }

    public function updateSection(Request $request)
    {
        $section = $request->input('section');
        $aboutPage = AboutPage::first();
        
        if (!$aboutPage) {
            return response()->json(['success' => false, 'message' => 'About page not found']);
        }

        try {
            switch ($section) {
                case 'main':
                    $validated = $request->validate([
                        'main_content' => 'required|array',
                        'main_content.*' => 'required|string',
                    ]);
                    $aboutPage->main_content = array_filter($validated['main_content']);
                    break;

                case 'vision-mission':
                    $validated = $request->validate([
                        'vision' => 'nullable|string',
                        'mission' => 'nullable|array',
                        'mission.*' => 'nullable|string',
                    ]);
                    $aboutPage->vision = $validated['vision'];
                    $aboutPage->mission = array_filter($validated['mission'] ?? []);
                    break;

                case 'objectives':
                    $validated = $request->validate([
                        'objectives' => 'nullable|array',
                        'objectives.*' => 'nullable|string',
                    ]);
                    $aboutPage->objectives = array_filter($validated['objectives'] ?? []);
                    break;

                case 'quick-facts':
                    $validated = $request->validate([
                        'quick_facts' => 'nullable|array',
                        'quick_facts.*' => 'nullable|string',
                    ]);
                    $aboutPage->quick_facts = array_filter($validated['quick_facts'] ?? []);
                    break;

                case 'leadership':
                    $validated = $request->validate([
                        'leadership_positions' => 'nullable|array',
                        'leadership_positions.*' => 'nullable|string',
                    ]);
                    $aboutPage->leadership_positions = array_filter($validated['leadership_positions'] ?? []);
                    break;

                default:
                    return response()->json(['success' => false, 'message' => 'Invalid section']);
            }

            $aboutPage->updated_by = Auth::id();
            $aboutPage->save();

            return response()->json(['success' => true, 'message' => 'Section updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}