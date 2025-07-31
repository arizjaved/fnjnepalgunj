<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EconomicActivityController extends Controller
{
    public function index()
    {
        $economicActivities = \App\Models\Publication::economicActivities()
                                                   ->published()
                                                   ->orderBy('published_at', 'desc')
                                                   ->paginate(12);

        return view('economic-activity', compact('economicActivities'));
    }

    public function download(\App\Models\Publication $publication)
    {
        if ($publication->type !== 'economic_activity' || $publication->status !== 'published') {
            abort(404);
        }

        if (!$publication->document_file || !\Illuminate\Support\Facades\Storage::disk('public')->exists($publication->document_file)) {
            abort(404, 'Document not found.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download(
            $publication->document_file,
            $publication->document_name ?: 'economic-activity.' . $publication->document_type
        );
    }
}
