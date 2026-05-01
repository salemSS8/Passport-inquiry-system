<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        // For now, just a placeholder for updating system settings
        return back()->with('success', 'تم تحديث الإعدادات بنجاح.');
    }
}
