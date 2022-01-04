<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Image;

class SettingsController extends Controller
{
	protected $page_title = "Board of Elementary Examination, GB | Settings";
    protected $main_title = "Settings";
    protected $breadcrumb_title = "Settings";
    protected $selected_main_menu = "settings";
    protected $card_title;
    protected $selected_sub_menu;

    public function index(){
    	$this->selected_sub_menu = "settings_index";
        $this->card_title = "View and update the settings of the system.";

        $setting = Setting::find(1);

        return view('settings.update')
        	->with('setting', $setting)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function update(Request $request){
    	$setting = Setting::find($request->input('setting_id'));
        if($setting){
            $validator = Validator::make($request->all(), Setting::$rules);
            if ($validator->passes()) {

                $setting->board_full_name = $request->input('board_full_name');
                $setting->minister_name = $request->input('minister_name');
                if($request->file('minister_image')!='') {
                    $originalImage1= $request->file('minister_image');
                    $thumbnailImage1 = Image::make($originalImage1);

                    $web_path_orig1 = '/images/'.time().'-orig-minister-image.'.$originalImage1->getClientOriginalExtension();

                    $orig_add1 = public_path().$web_path_orig1;
                    $thumbnailImage1->save($orig_add1);

                    $setting->minister_image=$web_path_orig1;
                }
                $setting->ministers_message = $request->input('ministers_message');
                $setting->secretary_name = $request->input('secretary_name');
                if($request->file('secretary_image')!='') {
                    $originalImage2= $request->file('secretary_image');
                    $thumbnailImage2 = Image::make($originalImage2);

                    $web_path_orig2 = '/images/'.time().'-orig-secretary-image.'.$originalImage2->getClientOriginalExtension();

                    $orig_add2 = public_path().$web_path_orig2;
                    $thumbnailImage2->save($orig_add2);

                    $setting->secretary_image=$web_path_orig2;
                }
                $setting->secretarys_message = $request->input('secretarys_message');
                $setting->controller_name = $request->input('controller_name');
                if($request->file('controller_image')!='') {
                    $originalImage3= $request->file('controller_image');
                    $thumbnailImage3 = Image::make($originalImage3);

                    $web_path_orig3 = '/images/'.time().'-orig-controller-image.'.$originalImage3->getClientOriginalExtension();

                    $orig_add3 = public_path().$web_path_orig3;
                    $thumbnailImage3->save($orig_add3);

                    $setting->controller_image=$web_path_orig3;
                }
                $setting->controllers_message = $request->input('controllers_message');

                $setting->deputy_controller_name = $request->input('deputy_controller_name');

                $setting->save();

                return Redirect::to('admin/index')
                    ->with('message', 'Settings updated successfully.');
            } else {
                return Redirect::to('admin/settings/index')
                    ->withErrors($validator)
                    ->withInput($request->all());      
            }
        }
    }
}
