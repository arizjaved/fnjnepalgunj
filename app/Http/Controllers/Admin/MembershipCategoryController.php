<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MembershipCategoryController extends Controller
{
    public function index()
    {
        $categories = MembershipCategory::withCount('memberships')
                                       ->ordered()
                                       ->paginate(15);
        
        return view('admin.membership-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.membership-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:membership_categories,name',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        MembershipCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'sort_order' => $request->sort_order ?: 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.membership-categories.index')
                        ->with('success', 'Membership category created successfully.');
    }

    public function show(MembershipCategory $membershipCategory)
    {
        $membershipCategory->load(['memberships']);
        return view('admin.membership-categories.show', compact('membershipCategory'));
    }

    public function edit(MembershipCategory $membershipCategory)
    {
        return view('admin.membership-categories.edit', compact('membershipCategory'));
    }

    public function update(Request $request, MembershipCategory $membershipCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:membership_categories,name,' . $membershipCategory->id,
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $membershipCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?: 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.membership-categories.index')
                        ->with('success', 'Membership category updated successfully.');
    }

    public function destroy(MembershipCategory $membershipCategory)
    {
        // Check if category is in use
        $memberCount = $membershipCategory->memberships()->count();
        
        if ($memberCount > 0) {
            return redirect()->route('admin.membership-categories.index')
                            ->with('error', 'Cannot delete category that has members assigned to it.');
        }

        $membershipCategory->delete();

        return redirect()->route('admin.membership-categories.index')
                        ->with('success', 'Membership category deleted successfully.');
    }
}