<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ToolsController extends Controller
{
    public function index()
    {
        return view('admin.tools.index');
    }

    public function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return back()->with('success', 'Cache cleared successfully.');
    }

    public function backup()
    {
        $fileName = 'backup-' . date('Y-m-d-H-i-s') . '.zip';
        $path = storage_path('app/' . $fileName);

        if (! class_exists('ZipArchive')) {
            return back()->withErrors(['zip' => 'ZipArchive is not available.']);
        }

        $zip = new \ZipArchive();
        $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile(base_path('composer.json'));
        $zip->close();

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
