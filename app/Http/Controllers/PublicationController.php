<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::publications()
                                 ->published()
                                 ->orderBy('published_at', 'desc')
                                 ->paginate(12);

        return view('publications', compact('publications'));
    }

    public function download(Publication $publication)
    {
        if ($publication->type !== 'publication' || $publication->status !== 'published') {
            abort(404);
        }

        if (!$publication->document_file || !\Illuminate\Support\Facades\Storage::disk('public')->exists($publication->document_file)) {
            abort(404, 'Document not found.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download(
            $publication->document_file,
            $publication->document_name ?: 'publication.' . $publication->document_type
        );
    }
}
