<?php

namespace App\Http\Controllers;

use App\Models\FailedJob;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;


class FailedJobsController extends Controller
{
    protected $page_title = "Board of Elementary Examination, GB | Failed Jobs";
    protected $main_title = "Failed Jobs";
    protected $breadcrumb_title = "Failed Jobs";
    protected $selected_main_menu = "failed_jobs";
    protected $card_title;
    protected $selected_sub_menu;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->selected_sub_menu = "failed_jobs_index";
        $this->card_title = "View and delete all failed jobs shown below.";
        if(request()->ajax())
        {
            return datatables()->of(FailedJob::select('failed_jobs.id', 'failed_jobs.uuid', 'failed_jobs.exception', 'failed_jobs.queue', 'failed_jobs.failed_at', 'failed_jobs.payload')->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('failedjobs.destroy').'" data-failedjobid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->addColumn('centerdets', function($data){
                        $split_array = explode('-', $data->payload);
                        $roll_no = (int)$split_array[1];
                        $student = Student::find($roll_no);

                        $result = "<a class='btn btn-secondary btn-block' target='_blank' href='".url('admin/exams/index?session_id='.$student->session_id.'&class_id='.$student->class_id.'&center_id='.$student->center_id)."'>Goto Center</a>";

                        return $result;
                    })
                    ->addColumn('stdlink', function($data){
                        $split_array = explode('-', $data->payload);
                        $roll_no = (int)$split_array[1];
                        $student = Student::find($roll_no);

                        $result = "<a class='btn btn-warning btn-block' target='_blank' href='".url('admin/students/edit/'.$student->id)."'>Edit Student</a>";

                        return $result;
                    })
                    ->addColumn('links', function($data){
                        $split_array = explode('-', $data->payload);
                        $roll_no = (int)$split_array[1];

                        $student = Student::find($roll_no);
                        $semesters = Semester::where('session_id', $student->session_id)->get(['*']);

                        $result = "";
                        $counter = count($semesters);
                        $i = 0;
                        foreach($semesters as $semester){
                            $result .= "<a class='btn btn-info btn-block' target='_blank' href='".url('admin/exams/edit/'.$roll_no.'/'.$semester->id.'/'.$student->session_id.'/'.$student->class_id.'/'.$student->center_id)."'>Update Marks for ". $semester->title ."</a>";
                            if($i < $counter){
                                $result.="<br>";
                            }
                            $i++;
                        }

                        return $result;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('failedjobs.index')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function destroy(Request $request)
    {
        $failedjob = FailedJob::find($request->get('id'));

        if($failedjob){
            try {
                $failedjob->delete();
                return response()->json(['success'=>'true', 'message'=>'Success! Your request has been completed successfully.']);

            } catch (\Illuminate\Database\QueryException $e) {
                //var_dump($e->errorInfo);
                if($e->getCode()==23000) {
                    return response()->json(['success'=>'false', 'message'=>'<b>Integrity Constraint Violation!</b><br>You must delete child records first then you should delete this item to ensure referential integrity.']);
                } else {
                    return response()->json(['success'=>'false', 'message'=>'Something Went Wrong! Please Try Again Later.']);
                }
            }
        }

        return response()->json(['success'=>'false', 'message'=>'Something went wrong. Please try again later']);
    }

    public function destroyall(Request $request)
    {
        FailedJob::truncate();

        return response()->json(['success'=>'true', 'message'=>'Successfully Deleted all records.']);
    }
}
