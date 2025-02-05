<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bank;
use App\Models\District;
use App\Models\Tehsil;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Fee;
use App\Models\FeeGroup;
use App\Models\FeeGroupFee;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\SubjectsGroup;
use App\Models\Institution;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentsSubject;
use App\Models\StudentsSemester;
use App\Models\StudentsFee;
use App\Models\StudentsFeesSelection;
use App\Models\StudentsExam;
use App\Models\Setting;
use App\Models\Datesheet;

use Config;
use DB;
use excel;

class ImportExportsController extends Controller
{
	protected $page_title = "Board of Elementary Examination, GB | Datesheets";
    protected $main_title = "Datesheets";
    protected $breadcrumb_title = "Datesheets";
    protected $selected_main_menu = "importsexports";
    protected $card_title;
    protected $selected_sub_menu;


    public function export(){
    	$this->selected_sub_menu = "export";
        $this->card_title = "Export data from here to external sources.";

        $sessions = Session::all();
        $districts = District::all();

        return view('importsexports.export')
        	->with('sessions', $sessions)
        	->with('districts', $districts)
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function getexporteddata(){

    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);
    		
    	$students = DB::connection('sqlite')->select(DB::raw("
                        SELECT
                            s.id,
                            s.name,
                            s.father_name,
                            d.name AS district_name,
                            ss.title,
                            (
                                SELECT institutions.name FROM institutions
                                WHERE s.institution_id = institutions.id
                            ) AS institution_name,
                            i.name as center_name,
                            stds.name as class_name
                        FROM students AS s
                        JOIN sessions AS ss
                        ON ss.id = s.session_id
                        JOIN standards as stds
                        ON stds.id = s.class_id
                        JOIN institutions AS i
                        ON i.id = s.center_id
                        JOIN tehsils AS t
                        ON t.id = i.tehsil_id
                        JOIN districts as d
                        ON d.id = t.district_id
                        ORDER BY s.id DESC;
					"));
        if(request()->ajax())
        {
            return datatables()->of($students)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="delete" id = "dlt_button" class="btn btn-danger margin-2px btn-sm" data-url="'.route('importsexports.destroystudents').'" data-districtid="'.$data->id.'" data-token="'.csrf_token().'"><span class="fa fa-window-close"></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('importsexports.export')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function destroystudents(Request $request) {
    	$student_id = $request->get('id');

    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);

        if($student_id){
            try {
            	DB::connection('sqlite')->select(DB::raw("DELETE FROM students_subjects WHERE student_id = ".$student_id));
            	DB::connection('sqlite')->select(DB::raw("DELETE FROM students_semesters WHERE student_id = ".$student_id));
            	DB::connection('sqlite')->select(DB::raw("DELETE FROM students_exams WHERE student_id = ".$student_id));
            	DB::connection('sqlite')->select(DB::raw("DELETE FROM students_fees_selections WHERE student_id = ".$student_id));
            	DB::connection('sqlite')->select(DB::raw("DELETE FROM students_fees WHERE student_id = ".$student_id));
            	DB::connection('sqlite')->select(DB::raw("DELETE FROM students WHERE id = ".$student_id));

            	$count_students = DB::connection('sqlite')->select(DB::raw("SELECT COUNT(*) AS total_records FROM students"));

                return response()->json(['success'=>'true', 'message'=>'Success! Your request has been completed successfully.', 'total_students'=>$count_students[0]->total_records]);

            } catch (\Illuminate\Database\QueryException $e) {
                
                if($e->getCode()==23000) {
                    return response()->json(['success'=>'false', 'message'=>'<b>Integrity Constraint Violation!</b><br>You must delete child records first then you should delete this item to ensure referential integrity.']);
                } else {
                    return response()->json(['success'=>'false', 'message'=>'Something Went Wrong! Please Try Again Later.']);
                }
            }
        }

        return response()->json(['success'=>'false', 'message'=>'Something went wrong. Please try again later']);
    }

    public function reset(Request $request){

    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);

        @ini_set('max_execution_time', 5000);

        //Students Fee Selections

        //DB::connection('sqlite')->table("students_fees_selections")->truncate();

        //Students Fees

        //DB::connection('sqlite')->table("students_fees")->truncate();

        //Students Semesters

        DB::connection('sqlite')->table("students_semesters")->truncate();

        //Students Subjects

        DB::connection('sqlite')->table("students_subjects")->truncate();

        //Students

        DB::connection('sqlite')->table("students")->truncate();

        //Institutions

        DB::connection('sqlite')->table("institutions")->truncate();

        //Subject Groups

        DB::connection('sqlite')->table("subjects_groups")->truncate();

        //subjects

        DB::connection('sqlite')->table("subjects")->truncate();

        //Fee Group Fees

        DB::connection('sqlite')->table("fee_group_fees")->truncate();
        
        //Fee Groups

        DB::connection('sqlite')->table("fee_groups")->truncate();

        //Fees

        DB::connection('sqlite')->table("fees")->truncate();

        //banks

        DB::connection('sqlite')->table("banks")->truncate();

        //Tehsils

        DB::connection('sqlite')->table("tehsils")->truncate();
        
        //Districts

        DB::connection('sqlite')->table("districts")->truncate();

        //standards

        DB::connection('sqlite')->table("standards")->truncate();

        //Semesters

        DB::connection('sqlite')->table("semesters")->truncate();

        //Sessions

        DB::connection('sqlite')->table("sessions")->truncate();

        //Users

        DB::connection('sqlite')->table("users")->truncate();

        //Settings

        DB::connection('sqlite')->table("settings")->truncate();

        //Datesheets

        DB::connection('sqlite')->table("datesheets")->truncate();

        return response()->json(['success'=>'true', 'message'=>'Successfully removed all records from the tables.']);
    }

    public function set(Request $request) {
    	
    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);

        @ini_set('max_execution_time', 5000);

        //banks

        $bs = DB::connection('sqlite')->select("SELECT * FROM banks;");

        if(count($bs) == 0) {
	        $banks = Bank::all();
	        foreach($banks as $bank){
	        	
	        	$data = [
	        		$bank->id, 
	        		$bank->name, 
	        		$bank->created_at, 
	        		$bank->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO banks (id, name, created_at, updated_at) VALUES (?, ?, ?, ?)', $data);
	        }
	    }

        //Districts

        $ds = DB::connection('sqlite')->select("SELECT * FROM districts;");

        if(count($ds) == 0) {
	        $districts = District::all();
	        foreach($districts as $district){
	        	
	        	$data = [
	        		$district->id, 
	        		$district->name, 
	        		$district->created_at, 
	        		$district->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO districts (id, name, created_at, updated_at) VALUES (?, ?, ?, ?)', $data);
	        }
	    }

        //Tehsils

        $ts = DB::connection('sqlite')->select("SELECT * FROM tehsils;");

	    if(count($ts)==0) { 
	        $tehsils = Tehsil::all();
	        foreach($tehsils as $tehsil){
	        	
	        	$data = [
	        		$tehsil->id, 
	        		$tehsil->name, 
	        		$tehsil->district_id, 
	        		$tehsil->created_at, 
	        		$tehsil->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO tehsils (id, name, district_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', $data);
	        }
	    }

        //Sessions

        $ss = DB::connection('sqlite')->select("SELECT * FROM sessions;");

        if(count($ss)==0) {
	        $session = Session::where('is_active', 1)->first();
	        	
        	$data = [
        		$session->id, 
        		$session->title, 
        		$session->year, 
        		$session->expiry_date,
        		$session->created_at, 
        		$session->updated_at
        	];
        	
        	DB::connection('sqlite')->insert('INSERT INTO sessions (id, title, year, expiry_date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', $data);

            //Semesters

            $sms = DB::connection('sqlite')->select("SELECT * FROM semesters;");

            if(count($sms)==0) {
                $semesters = Semester::where('session_id', $session->id)->get();
                foreach($semesters as $semester){
                    
                    $data = [
                        $semester->id, 
                        $semester->title, 
                        $semester->session_id, 
                        $semester->division_percentage, 
                        $semester->created_at, 
                        $semester->updated_at
                    ];
                    
                    DB::connection('sqlite')->insert('INSERT INTO semesters (id, title, session_id, division_percentage, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', $data);
                }
            }
	    }

        //Fees

        $fs = DB::connection('sqlite')->select("SELECT * FROM fees;");

        if(count($fs)==0){
	        $fees = Fee::all();
	        foreach($fees as $fee){
	        	
	        	$data = [
	        		$fee->id, 
	        		$fee->title, 
	        		$fee->amount, 
	        		$fee->created_at, 
	        		$fee->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO fees (id, title, amount, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', $data);
	        }
	    }

        //Fee Groups

        $fgs = DB::connection('sqlite')->select("SELECT * FROM fee_groups;");

        if(count($fgs)==0) {
	        $fee_groups = FeeGroup::all();
	        foreach($fee_groups as $fg){
	        	
	        	$data = [
	        		$fg->id, 
	        		$fg->fee_group_name, 
	        		$fg->class_id, 
	        		$fg->created_at, 
	        		$fg->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO fee_groups (id, fee_group_name, class_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', $data);
	        }
	    }

        //Fee Group Fees

        $fgfs = DB::connection('sqlite')->select("SELECT * FROM fee_group_fees;");

        if(count($fgfs)==0) {
	        $fee_group_fees = FeeGroupFee::all();
	        foreach($fee_group_fees as $fgf){
	        	
	        	$data = [
	        		$fgf->id, 
	        		$fgf->fee_group_id, 
	        		$fgf->fee_id, 
	        		$fgf->created_at, 
	        		$fgf->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO fee_group_fees (id, fee_group_id, fee_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', $data);
	        }
	    }

        //standards

        $stds = DB::connection('sqlite')->select("SELECT * FROM standards;");

        if(count($stds)==0) {
	        $standards = Standard::all();
	        foreach($standards as $standard){
	        	
	        	$data = [
	        		$standard->id, 
	        		$standard->name, 
	        		$standard->min_subjects, 
	        		$standard->min_age, 
	        		$standard->created_at, 
	        		$standard->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO standards (id, name, min_subjects, min_age, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', $data);
	        }
	    }

        //subjects

        $subs = DB::connection('sqlite')->select("SELECT * FROM subjects;");

        if(count($subs)==0){
	        $subjects = Subject::all();
	        foreach($subjects as $subject){
	        	
	        	$data = [
	        		$subject->id, 
	        		$subject->name, 
	        		$subject->short_name, 
	        		$subject->is_optional, 
	        		$subject->has_practical, 
	        		$subject->created_at, 
	        		$subject->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO subjects (id, name, short_name, is_optional, has_practical, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)', $data);
	        }
	    }

        //Subject Groups

        $sgs = DB::connection('sqlite')->select("SELECT * FROM subjects_groups;");

        if(count($sgs)==0) {
	        $subjects_groups = SubjectsGroup::all();
	        foreach($subjects_groups as $sg){
	        	
	        	$data = [
	        		$sg->id, 
	        		$sg->subject_id, 
	        		$sg->class_id,  
	        		$sg->created_at, 
	        		$sg->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO subjects_groups (id, subject_id, class_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', $data);
	        }
	    }

        //Institutions

        $ins = DB::connection('sqlite')->select("SELECT * FROM institutions;");

        if(count($ins)==0){
	        $institutions = Institution::all();
	        foreach($institutions as $institution){
	        	
	        	$data = [
	        		$institution->id, 
	        		$institution->name, 
	        		$institution->is_ddo, 
	        		$institution->ddo_id, 
	        		$institution->is_center, 
	        		$institution->tehsil_id, 
	        		$institution->created_at, 
	        		$institution->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO institutions (id, name, is_ddo, ddo_id, is_center, tehsil_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', $data);
	        }
	    }

        //Users

        $usrs = DB::connection('sqlite')->select("SELECT * FROM users;");

        if(count($usrs)==0){
	        $users = User::all();
	        foreach($users as $user){
	        	
	        	$data = [
	        		$user->id,
	        		$user->name,
			    	$user->email,
			    	$user->password,
			    	$user->user_role,  
	        		$user->created_at, 
	        		$user->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO users (id, name, email, password, user_role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)', $data);
	        }
	    }

	    $stngs = DB::connection('sqlite')->select("SELECT * FROM settings;");

        if(count($stngs)==0){
	        $settings = Setting::all();
	        foreach($settings as $setting){
	        	
	        	$data = [
	        		$setting->id,
	        		$setting->board_full_name,
			    	$setting->minister_name,
			    	$setting->minister_image,
			    	$setting->ministers_message,  
			    	$setting->secretary_name,  
			    	$setting->secretary_image,  
			    	$setting->secretarys_message,  
			    	$setting->controller_name,  
			    	$setting->controller_image,  
			    	$setting->controllers_message,  
			    	$setting->deputy_controller_name,  
			    	$setting->deputy_controller_signature,  
	        		$setting->created_at, 
	        		$setting->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO settings (id, board_full_name, minister_name, minister_image, ministers_message, secretary_name, secretary_image, secretarys_message, controller_name, controller_image, controllers_message, deputy_controller_name, deputy_controller_signature, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $data);
	        } 
	    }

	    $dtshts = DB::connection('sqlite')->select("SELECT * FROM datesheets;");

        if(count($dtshts)==0){
	        $datesheets = Datesheet::all();
	        foreach($datesheets as $datesheet){
	        	
	        	$data = [
	        		$datesheet->id,
	        		$datesheet->session_id,
			    	$datesheet->semester_id,
			    	$datesheet->subject_id,
			    	$datesheet->class_id,  
			    	$datesheet->paper_date,  
			    	$datesheet->paper_starting_time,  
			    	$datesheet->paper_ending_time, 
	        		$datesheet->created_at, 
	        		$datesheet->updated_at
	        	];
	        	
	        	DB::connection('sqlite')->insert('INSERT INTO datesheets (id, session_id, semester_id, subject_id, class_id, paper_date, paper_starting_time, paper_ending_time, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $data);
	        } 
	    }

        return response()->json(['success'=>'true', 'message'=>'Successfully updated records to the exports.']);
    }

    public function exportstudents(Request $request){
    	
    	@ini_set('max_execution_time', 5000);
    	
    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);

    	$session_id = $request->input('session_id');
    	$district_id = $request->input('district_id');
    	$skip_records = $request->input('skip_records');
    	$limit_records = $request->input('limit_records');
    	$count_records = $request->input('count_records');

    	if($session_id != '' && $district_id != '' && $skip_records != '' && $limit_records != ''){
	    	if($skip_records >= $count_records) {	
	    		$students = Student::join('institutions', 'institutions.id', '=', 'students.center_id')->join('tehsils', 'tehsils.id', '=', 'institutions.tehsil_id')->join('districts', 'districts.id', '=', 'tehsils.district_id')->where('students.session_id', $session_id)->where('districts.id', $district_id)->groupBy('students.id')->orderBy('students.id', 'ASC')->skip($skip_records)->take($limit_records)->get([
	    				'students.id',
						'students.name',
						'students.father_name',
						'students.gender',
						'students.date_of_birth',
						'students.dob_in_words',
						'students.home_address',
						'students.cell_no',
						'students.email',
						'students.image',
						'students.student_type',
						'students.class_id',
						'students.session_id',
						'students.institution_id',
						'students.center_id',
						'students.created_at',
						'students.updated_at'
	    			]);

	    		$i=0;
	    		foreach($students as $student){
	    			$data = [
		        		$student->id,
		        		$student->name,
				    	$student->father_name,
				    	$student->gender,
				    	$student->date_of_birth,  
				    	$student->dob_in_words,  
				    	$student->home_address,  
				    	$student->cell_no,  
				    	$student->email,  
				    	$student->image,  
				    	$student->student_type,  
				    	$student->class_id,  
				    	$student->session_id,  
				    	$student->institution_id,  
				    	$student->center_id,  
		        		$student->created_at, 
		        		$student->updated_at
		        	];
		        	
		        	DB::connection('sqlite')->insert('INSERT INTO students (id, name, father_name, gender, date_of_birth, dob_in_words, home_address, cell_no, email, image, student_type, class_id, session_id, institution_id, center_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $data);

					$studentssubjects = StudentsSubject::where('student_id', $student->id)->get();

					foreach($studentssubjects as $stdsubject){
						$data1 = [
			        		$stdsubject->id,
			        		$stdsubject->student_id,
					    	$stdsubject->subject_id, 
			        		$stdsubject->created_at, 
			        		$stdsubject->updated_at
			        	];
			        	
			        	DB::connection('sqlite')->insert('INSERT INTO students_subjects (id, student_id, subject_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', $data1);
					}

					$studentssemesters = StudentsSemester::where('student_id', $student->id)->get();

					foreach($studentssemesters as $studentssemester){
						$data2 = [
			        		$studentssemester->id,
					    	$studentssemester->semester_id, 
			        		$studentssemester->student_id,
			        		$studentssemester->created_at, 
			        		$studentssemester->updated_at
			        	];
			        	
			        	DB::connection('sqlite')->insert('INSERT INTO students_semesters (id, semester_id, student_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', $data2);
					}
					/*$studentsfees = StudentsFee::where('student_id', $student->id)->get();

					foreach($studentsfees as $studentsfee) {
						$data3 = [
			        		$studentsfee->id,
			        		$studentsfee->student_id,
					    	$studentsfee->semester_id, 
					    	$studentsfee->bank_id, 
					    	$studentsfee->challan_no, 
					    	$studentsfee->date_of_deposit, 
					    	$studentsfee->total_amount, 
			        		$studentsfee->created_at, 
			        		$studentsfee->updated_at
			        	];
			        	
			        	DB::connection('sqlite')->insert('INSERT INTO students_fees (id, student_id, semester_id, bank_id, challan_no, date_of_deposit, total_amount, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', $data3);
					}*/

					/*$studentsfeeselections = StudentsFeesSelection::where('student_id', $student->id)->get();

					foreach($studentsfeeselections as $studentsfeeselection) {
						$data4 = [
			        		$studentsfeeselection->id,
					    	$studentsfeeselection->students_fees_id, 
			        		$studentsfeeselection->student_id,
			        		$studentsfeeselection->semester_id,
			        		$studentsfeeselection->fee_id,
			        		$studentsfeeselection->created_at, 
			        		$studentsfeeselection->updated_at
			        	];
			        	
			        	DB::connection('sqlite')->insert('INSERT INTO students_fees_selections (id, students_fees_id, student_id, semester_id, fee_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)', $data4);
					}*/
				} /// end of foreach
    		}  else {
				return response()->json(['success'=>'false', 'message'=>'Please enter a value greater than or equal to '.$count_records.' otherwise duplication of data or integrity constraint violation error may occur.']);
			}


    		$stds = DB::connection('sqlite')->select("SELECT * FROM students;");

    		return response()->json(['success'=>'true', 'skip_records'=>$limit_records+$skip_records, 'limit_records'=>$limit_records, 'total_records'=>count($stds), 'message'=>'Successfully added '.$limit_records.' more records of students.']);
    	}

    	return response()->json(['success'=>'false', 'message'=>'Something went wrong! Please try again later.']);
    }

    public function resetstudents(Request $request){

    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);

    	//Students Fee Selections

        //DB::connection('sqlite')->table("students_fees_selections")->truncate();

        //Students Fees

        //DB::connection('sqlite')->table("students_fees")->truncate();

        //Students Semesters

        DB::connection('sqlite')->table("students_semesters")->truncate();

        //Students Subjects

        DB::connection('sqlite')->table("students_subjects")->truncate();

        //Students

        DB::connection('sqlite')->table("students")->truncate();

        return response()->json(['success'=>'true', 'message'=>'Successfully removed all records from the tables.']);
    }

    public function import() {
    	$this->selected_sub_menu = "import";
        $this->card_title = "Import data here from external sources.";

        return view('importsexports.import')
            ->with('main_title', $this->main_title)
            ->with('selected_main_menu', $this->selected_main_menu)
            ->with('breadcrumb_title', $this->breadcrumb_title)
            ->with('card_title', $this->card_title)
            ->with('selected_sub_menu', $this->selected_sub_menu)
            ->with('page_title', $this->page_title);
    }

    public function importstudents(Request $request){
    	@ini_set('max_execution_time', 5000);
    	
    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('db_imports\database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);

    	$skip_records = $request->input('skip_records');
    	$limit_records = $request->input('limit_records');
    	$count_records = $request->input('count_records');

    	if($skip_records != '' && $limit_records != ''){

    		$students = DB::connection('sqlite')->select('SELECT * FROM students LIMIT '.$skip_records.', '.$limit_records.';');

    		foreach($students as $student){
    			
    			$std = new Student;
        		$std->name = $student->name;
		    	$std->father_name = $student->father_name;
		    	$std->gender = $student->gender;
		    	$std->date_of_birth = $student->date_of_birth;  
		    	$std->dob_in_words = $student->dob_in_words;  
		    	$std->home_address = $student->home_address;  
		    	$std->cell_no = $student->cell_no;  
		    	$std->email = $student->email;  
		    	$std->image = $student->image;  
		    	$std->student_type = $student->student_type;  
		    	$std->class_id = $student->class_id;  
		    	$std->session_id = $student->session_id;  
		    	$std->institution_id = $student->institution_id;  
		    	$std->center_id = $student->center_id;  
        		$std->save();

        		$studentssubjects = DB::connection('sqlite')->select('SELECT * FROM students_subjects WHERE student_id = '.$student->id.';');

				foreach($studentssubjects as $stdsubject){
					$stdsub = new StudentsSubject;
	        		$stdsub->student_id = $std->id;
			    	$stdsub->subject_id = $stdsubject->subject_id; 
	        		$stdsub->save();
				}

				$studentssemesters = StudentsSemester::where('student_id', $student->id)->get();

				$studentssemesters = DB::connection('sqlite')->select('SELECT * FROM students_semesters WHERE student_id = '.$student->id.';');

				foreach($studentssemesters as $studentssemester){
					$stdssemester = new StudentsSemester;
					$stdssemester->semester_id = $studentssemester->semester_id; 
	        		$stdssemester->student_id = $std->id;
	        		$stdssemester->save();
				}

                $studentsfees = DB::connection('sqlite')->select('SELECT * FROM students_fees WHERE student_id = '.$student->id.';');

                foreach($studentsfees as $studentsfee){
                    $stdfee = new StudentsFee;
                    $stdfee->student_id = $std->id;
                    $stdfee->semester_id = $studentsfee->semester_id;
                    $stdfee->bank_id = $studentsfee->bank_id;
                    $stdfee->challan_no = $studentsfee->challan_no;
                    $stdfee->date_of_deposit = $studentsfee->date_of_deposit;
                    $stdfee->total_amount = $studentsfee->total_amount;
                    $stdfee->save();

                    $studentsfeesselections = DB::connection('sqlite')->select('SELECT * FROM students_fees_selections WHERE students_fees_id = '.$studentsfee->id.';');

                    foreach($studentsfeesselections as $studentsfeesselection) {
                        $stdfeeselection = new StudentsFeesSelection;
                        $stdfeeselection->students_fees_id = $stdfee->id;
                        $stdfeeselection->student_id = $std->id;
                        $stdfeeselection->semester_id = $studentsfeesselection->semester_id;
                        $stdfeeselection->fee_id = $studentsfeesselection->fee_id;
                        $stdfeeselection->save();
                    }
                }

			} /// end of foreach
    		

    		$stds = Student::all();

    		return response()->json(['success'=>'true', 'skip_records'=>$limit_records+$skip_records, 'limit_records'=>$limit_records, 'total_records'=>count($stds), 'message'=>'Successfully added '.$limit_records.' more records of students.']);
    	}

    	return response()->json(['success'=>'false', 'message'=>'Something went wrong! Please try again later.']);
    }

    public function importexamdata(Request $request){

    	@ini_set('max_execution_time', 5000);
    	
    	Config::set("database.connections.sqlite", [
            "driver" => "sqlite",
            "url" => '',
            "database" => database_path('db_imports\database.sqlite'),
            "prefix" => '',
            'foreign_key_constraints' => ''
        ]);

    	$skip_records = $request->input('skip_records');
    	$limit_records = $request->input('limit_records');
    	$count_records = $request->input('count_records');

    	if($skip_records != '' && $limit_records != '') {
    		$students = DB::connection('sqlite')->select('SELECT * FROM students LIMIT '.$skip_records.', '.$limit_records.';');

    		foreach($students as $student) {

    			$studentsexams = DB::connection('sqlite')->select('SELECT * FROM students_exams WHERE student_id = '.$student->id.';');

    			if(count($studentsexams) > 0) {
    				StudentsExam::where('student_id', $student->id)->delete();
	    			foreach($studentsexams as $studentexam) {
	    				$stdexam = new StudentsExam;
	    				$stdexam->student_id = $studentexam->student_id;
	    				$stdexam->subject_id = $studentexam->subject_id;
	    				$stdexam->semester_id = $studentexam->semester_id;
	    				$stdexam->is_absent = $studentexam->is_absent;
	    				$stdexam->sheet_no = $studentexam->sheet_no;
	    				$stdexam->theory_max_marks = $studentexam->theory_max_marks;
	    				$stdexam->theory_obt_marks = $studentexam->theory_obt_marks;
	    				$stdexam->practical_max_marks = $studentexam->practical_max_marks;
	    				$stdexam->practical_obt_marks = $studentexam->practical_obt_marks;
	    				$stdexam->total_max_marks = $studentexam->total_max_marks;
	    				$stdexam->total_obt_marks = $studentexam->total_obt_marks;
	    				$stdexam->created_at = $studentexam->created_at;
	    				$stdexam->updated_at = $studentexam->updated_at;
	    				$stdexam->save();
	    			}
	    		}

    			$count_records++;
    		}

			return response()->json(['success'=>'true', 'skip_records'=>$limit_records+$skip_records, 'limit_records'=>$limit_records, 'total_records'=>$count_records, 'message'=>'Successfully added '.$limit_records.' more records of students.']);

    	}

    	return response()->json(['success'=>'false', 'message'=>'Something went wrong! Please try again later.']);
    }
}
