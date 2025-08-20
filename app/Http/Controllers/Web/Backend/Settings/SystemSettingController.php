<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SystemSettingController extends Controller {
    /**
     * Display the system settings page.
     *
     * @return View
     */
    public function index() {
        $setting = SystemSetting::latest('id')->first();
        return view('backend.layouts.settings.system_settings', compact('setting'));
    }

    /**
     * Update the system settings.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
            'title'          => 'nullable',
            'email'          => 'nullable',
            'contact_title'  => 'nullable',
            'contact_phone'  => 'nullable',
            'contact_address'=> 'nullable',
            'system_name'    => 'nullable',
            'copyright_text' => 'nullable',
            'logo'           => 'nullable',
            'favicon'        => 'nullable',
            'description'    => 'nullable',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $setting                 = SystemSetting::firstOrNew();
            $setting->title          = $request->title;
            $setting->email          = $request->email;
            $setting->contact_title  = $request->contact_title;
            $setting->contact_phone  = $request->contact_phone;
            $setting->contact_address= $request->contact_address;
            $setting->system_name    = $request->system_name;
            $setting->copyright_text = $request->copyright_text;
            $setting->description    = $request->description;

            
            if ($request->hasFile('logo')) {
                $setting->logo = Helper::fileUpload($request->file('logo'), 'logos', $setting->title);
            }

            if ($request->hasFile('favicon')) {
                $setting->favicon = Helper::fileUpload($request->file('favicon'), 'favicons', $setting->title);
            }
            $setting->save();

            return back()->with('t-success', 'Updated successfully');
        } catch (\Exception $e) {
            return back()->with('t-error', 'Failed to update: ' . $e->getMessage());
        }
    }


    /**
     * Edit the pixel settings.
     * 
     * @return View
     */
    public function pixel() {
        $setting = SystemSetting::latest('id')->first();
        return view('backend.layouts.settings.pixel', compact('setting'));
    }

    /**
     * Update the pixel settings.
     * 
     * @return RedirectResponse
     */
    public function pixelStotre(Request $request) {
        $request->validate([
            'pixel' => 'required|string',
        ]);
        $setting = SystemSetting::firstOrNew();
        $setting->pixel = $request->pixel;
        $setting->save();
        return back()->with('t-success', 'Updated successfully');
    }
    /**
     * Update the commition settings.
     * 
     * @return RedirectResponse
     */
    public function commitionStotre(Request $request) {
        $request->validate([
            'commission' => 'required|string',
        ]);
        $setting = SystemSetting::firstOrNew();
        $setting->commission = $request->commission;
        $setting->save();
        return back()->with('t-success', 'Updated successfully');
    }


}
