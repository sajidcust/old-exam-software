<?php

namespace App\Http\Controllers;

use App\Models\AcademicQualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Excel;

class AdminController extends Controller
{
    protected $page_title = "Directorate of Education Colleges GB | Admin";
    protected $main_title = "Dashboard";
    protected $breadcrumb_title = "Dashboard";
    protected $selected_main_menu = "admin_dashboard";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $array = Excel::toArray([], storage_path('imports/centers_data_ghizer.xlsx'));

        //$theArray = Excel::toArray([], 'myexcelfile.xlsx');
        $new_array = array();
        $index = 0;
        foreach($array[0] as $arr){
            $new_array[$index]['id'] = (int)(trim($arr[0]));
            $new_array[$index]['center_name'] = strtolower(str_replace(' ', '_', trim($arr[1])));
            $new_array[$index]['institute_name'] = strtolower(str_replace(' ', '_', trim($arr[2])));
            $index++;
        }

        //dd($new_array);

        $input = array_map("unserialize", array_unique(array_map("serialize", $new_array)));

        //dd($input);


        $ids_array = array();
        $j=0;

        foreach($input as $inp) {
            $ids_array[$j] = $inp['id'];
            $j++;
        }

        $unique_ids = array_unique($ids_array);

        $i=1;
        $failed_array = array();
        $counter = 0;
        $first_value = false;

        foreach($unique_ids as $inp){
            $first_value = false;
            foreach($input as $inp2){
                if($inp == $inp2['id']) {
                    if($inp2['center_name'] == $inp2['institute_name']) {
                        $first_value = true;
                    }

                    if($first_value) {
                        echo "<h4>";
                        echo $i."-".$inp2['id'].":". strtoupper(str_replace('_', ' ', $inp2['center_name']))."-<span style='color:red'>".strtoupper(str_replace('_', ' ', $inp2['institute_name']))."</span>";
                        echo "</h4>";
                    } 
                    if(!$first_value) {
                        $failed_array[$counter]['id'] = $inp2['id'];
                        $failed_array[$counter]['center_name'] = $inp2['center_name'];
                        $failed_array[$counter]['institute_name'] = $inp2['institute_name'];
                        $counter++;
                    }
                }
            }
            $counter++;
            $i++;
        }
        
        //foreach($input as $inp){

            /*if($inp['center_name'] == $inp['institute_name']){
                echo "<h1>".$inp['center_name']."::::".$inp['institute_name']."</h1>";
                $first_value = true;
            }

            if($inp['center_name'] != $inp['institute_name']) {
                $first_value = false;
            }*/

            /*if($first_value){
                echo "<h4>";
                echo $i."-".$inp['id'].":". strtoupper(str_replace('_', ' ', $inp['center_name']))."-<span style='color:red'>".strtoupper(str_replace('_', ' ', $inp['institute_name']))."</span>";
                echo "</h1>";
            } else {
                $failed_array[$counter]['id'] = $inp['id'];
                $failed_array[$counter]['center_name'] = $inp['center_name'];
                $failed_array[$counter]['institute_name'] = $inp['institute_name'];
                $counter++;
            }
            $i++;*/
        //}

        dd($failed_array);

        exit;

        dd($input);
        echo "here";exit;

        //$database = DB::connection()->getPdo();
        //$driver_name = DB::connection()->getDriverName();
        //dd($driver_name);

        //strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth,
        //(CASE  WHEN s.gender=0 THEN 'Male' ELSE 'Female' END) AS gender,
        //(CASE  WHEN s.student_type=0 THEN 'Regular' ELSE 'Private' END) AS student_type,

        $this->selected_sub_menu = "admin_dashboard";
        $this->card_title = "Admin Dashboard";

        return view('admin.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

}