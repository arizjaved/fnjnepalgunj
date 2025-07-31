<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    public function index()
    {
        $publications = config('site.publications_data');
        return view('publications', compact('publications'));
    }
}
