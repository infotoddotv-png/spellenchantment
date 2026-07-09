<?php

namespace App\Http\Controllers;

use App\Models\LibraryEntry;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $entries    = LibraryEntry::all();
        $categories = $entries->pluck('category')->unique()->values()->prepend('All');
        $activeTab  = $request->tab ?? 'All';

        $filtered = $activeTab === 'All'
            ? $entries
            : $entries->where('category', $activeTab)->values();

        return view('pages.library.index', compact('filtered', 'categories', 'activeTab'));
    }

    public function show(string $slug)
    {
        $entry = LibraryEntry::where('slug', $slug)->firstOrFail();
        return view('pages.library.show', compact('entry'));
    }
}
