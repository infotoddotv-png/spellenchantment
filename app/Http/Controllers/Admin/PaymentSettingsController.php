<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $settings = PaymentSetting::all_settings();
        return view('admin.payments.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stripe_secret_key' => 'nullable|string',
            'stripe_publishable_key' => 'nullable|string',
            'stripe_webhook_secret' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'paypal_secret' => 'nullable|string',
            'paypal_mode' => 'nullable|in:sandbox,live',
            'manual_instructions' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
            PaymentSetting::set($key, $value);
        }

        AuditLog::record('payment_settings.updated', 'Payment gateway settings updated');

        return back()->with('success', 'Payment settings saved.');
    }
}
