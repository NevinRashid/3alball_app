<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalSetting;

class PaymentController extends Controller
{
    /**
     * Display the payment settings form.
     */
    public function paymentSettings()
    {
        $settings = GlobalSetting::firstOrCreate([]);

        return view('admin.settings.payment.index', compact('settings'));
    }

    /**
     * Update the payment settings or toggle activation state
     */
    public function updatePaymentSettings(Request $request)
    {
        $settings = GlobalSetting::firstOrCreate([]);

        // Toggle activation
        if ($request->has('toggle')) {
            $key = $request->input('toggle');

            if (in_array($key, ['enable_cliq', 'enable_credit', 'enable_apple', 'enable_google'])) {
                $settings->$key = !$settings->$key;
                $settings->save();

                return back()->with('success', ucfirst(str_replace('_', ' ', $key)) . ' has been ' . ($settings->$key ? 'activated' : 'deactivated') . '.');
            }

            return back()->with('error', 'Invalid toggle key.');
        }

        
        $fields = [
            'bank_name',
            'iban',
            'cliq_name',
            'cliq_alias',
            'payment_note',
            'credit_fee',
            'mid',
            'tid',
            'ip_address',
            'enable_3d'
        ];

        foreach ($fields as $field) {
            if ($field === 'enable_3d') {
                $settings->$field = $request->has('enable_3d');
            } else {
                $settings->$field = $request->input($field);
            }
        }

        $settings->save();

        return back()->with('success', 'Payment settings updated successfully.');
    }
}
