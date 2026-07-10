<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'min_order_total' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'active' => 'nullable|boolean',
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['active'] = $request->boolean('active', true);

        $coupon = Coupon::create($data);
        AuditLog::record('coupon.created', "Coupon {$coupon->code} created", $coupon);

        return back()->with('success', 'Coupon created.');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'active' => 'nullable|boolean',
        ]);

        $coupon->update(['active' => $request->boolean('active')]);
        AuditLog::record('coupon.updated', "Coupon {$coupon->code} toggled active=" . ($coupon->active ? 'yes' : 'no'), $coupon);

        return back()->with('success', 'Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        AuditLog::record('coupon.deleted', "Coupon {$coupon->code} deleted", $coupon);
        $coupon->delete();
        return back()->with('success', 'Coupon deleted.');
    }
}
