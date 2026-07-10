<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function show(int $id)
    {
        $order = Order::with('downloads.product')->findOrFail($id);
        return view('pages.orders.show', compact('order'));
    }

    public function download(string $token)
    {
        $download = Download::with('product')->where('token', $token)->firstOrFail();

        if (! $download->isValid()) {
            abort(403, 'This download link has expired or reached its limit.');
        }

        if (! $download->product->file_path || ! Storage::disk('local')->exists($download->product->file_path)) {
            abort(404, 'File not found.');
        }

        $download->increment('download_count');

        return Storage::disk('local')->download(
            $download->product->file_path,
            $download->product->file_name ?? basename($download->product->file_path)
        );
    }
}
