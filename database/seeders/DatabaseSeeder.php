<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;



use App\Models\Institution;
use App\Models\Tehsil;
use App\Models\Student;
use App\Models\StudentsSubject;
use App\Models\StudentsSemester;
use App\Models\StudentsExam;
use App\Models\Fee;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Standard;
use App\Models\Bank;
use App\Models\StudentsFee;
use App\Models\StudentsFeesSelection;
use Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$user = new User;
        $user->name = 'Waqar Ul Hassan';
    	$user->email = 'gltstar@hotmail.com';
    	$user->password = Hash::make('password123');
    	$user->user_role = 1;
    	$user->save();

        $user1 = new User;
        $user1->name = 'User';
        $user1->email = 'dataentry@beeg@gov.pk';
        $user1->password = Hash::make('password123');
        $user1->user_role = 3;
        $user1->save();

        $user2 = new User;
        $user2->name = 'User';
        $user2->email = 'assesmentcenter@beeg@gov.pk';
        $user2->password = Hash::make('password123');
        $user2->user_role = 3;
        $user2->save();

        /*$session = new Session;
        $session->id = 1;
        $session->title = 'Session 2021-2022';
        $session->year = 2021;
        $session->save();

        $district = new District;
        $district->id = 1;
        $district->name = 'Gilgit';
        $district->save();

        $tehsil = new Tehsil;
        $tehsil->id = 1;
        $tehsil->name = 'Danyore';
        $tehsil->district_id = 1;
        $tehsil->save();

        $institution = new Institution;
        $institution->id = 1;
        $institution->name = 'Government Boys High School, Rahimabad';
        $institution->is_ddo = 1;
        $institution->is_center = 1;
        $institution->center_id = NULL;
        $institution->tehsil_id = 1;
        $institution->save();

        $student = new Student;
        $student->id = 1;
        $student->name = 'Waqar Ul Hassan';
        $student->father_name = 'Bulbul Jan';
        $student->date_of_birth = date('Y-m-d', strtotime('15-11-1992'));
        $student->dob_in_words = 'Fifteen November Nineteen Ninty Two';
        $student->home_address = 'Mohallah Meherbanpura Amphry, Gilgit';
        $student->cell_no = '0313-6158155';
        $student->image = 'Some Image';
        $student->student_type = 1;
        $student->s_class = 1;
        $student->session_id = 1;
        $student->center_id = 1;
        $student->fee_id = 1;
        $student->bank = 1;
        $student->challan_no = 123;
        $student_date_of_deposit = date('Y-m-d', strtotime('26-11-2021'));
        $student->save();*/

        // \App\Models\User::factory(10)->create();


        /*$faker = Faker\Factory::create();
        $session_id = 1;

        ini_set('max_execution_time', 5000);

        for($i=1; $i<=200; $i++){
            $student = new Student;
            $student->name = $faker->name;
            $student->father_name = $faker->name;

            $class_selection = $faker->numberBetween(1, 2);

            if($class_selection == 1){
                $year = $faker->numberBetween(2008, 2012);
                $month = $faker->numberBetween(1, 12);
                $day = $faker->numberBetween(1, 28);
                $dob = $day.'-'.$month.'-'.$year;
                $student->date_of_birth = date('Y-m-d', strtotime($dob));

            } else {
                $year = $faker->numberBetween(2006, 2009);
                $month = $faker->numberBetween(1, 12);
                $day = $faker->numberBetween(1, 28);
                $dob = $day.'-'.$month.'-'.$year;
                $student->date_of_birth = date('Y-m-d', strtotime($dob));
            }
            $student->dob_in_words = 'NAN';
            $student->gender = $faker->numberBetween(0,1);
            $student->home_address = $faker->address;
            $student->cell_no = '03'.$faker->numberBetween(100, 999).'-'.$faker->numberBetween(1111111, 9999999);
            $student->email = $faker->email;

            $student->image = $faker->imageUrl($width = 488, $height = 556);

            $student->student_type = $faker->numberBetween(0, 1);
            $student->session_id = $session_id;
            $cent_inst_id = $faker->numberBetween(1, 1275);
            $student->institution_id = $cent_inst_id;
            $student->center_id = $cent_inst_id;
            $student->class_id = $class_selection;
            
            $student->save();

            //$standard = Standard::find($student->class_id);
            //$counter = $standard->min_subjects;

            $class_fifths = array(1, 2, 3, 4, 5, 6);
            $class_eighths = array(1, 2, 3, 4, 5, 7, $faker->numberBetween(9, 10), $faker->numberBetween(11, 12));


            if($class_selection == 1) {
                foreach($class_fifths as $fifth){
                    $students_subject = new StudentsSubject;
                    $students_subject->student_id = $student->id;
                    $students_subject->subject_id = $fifth;
                    $students_subject->save();
                }
            } else {
                foreach($class_eighths as $eight){
                    $students_subject = new StudentsSubject;
                    $students_subject->student_id = $student->id;
                    $students_subject->subject_id = $eight;
                    $students_subject->save();
                }
            }

            StudentsSemester::where('student_id', $student->id)->delete();
            $semesters = Semester::where('session_id', $student->session_id)->get();

            foreach($semesters as $semester){
                $studentsemester = new StudentsSemester;
                $studentsemester->student_id = $student->id;
                $studentsemester->semester_id = $semester->id;
                $studentsemester->save();
            }

            $semester_id = 1;

            $studentfee = new StudentsFee;
            $studentfee->student_id = $student->id;
            $studentfee->semester_id = $semester_id;
            $studentfee->bank_id = $faker->numberBetween(1,2);
            $studentfee->challan_no = $faker->numberBetween(1000, 9999);

            $year = $faker->numberBetween(2020, 2021);
            $month = $faker->numberBetween(1, 12);
            $day = $faker->numberBetween(1, 28);
            $dob = $day.'-'.$month.'-'.$year;

            $studentfee->date_of_deposit = date('Y-m-d', strtotime($dob));
            $studentfee->total_amount = $faker->numberBetween(450, 1400);
            $studentfee->save();
            
            $counter = 3;

            StudentsFeesSelection::where('student_id', $student->id)->where('semester_id', $semester_id)->delete();

            for($i=0; $i<$counter; $i++){
                $students_fees_selection = new StudentsFeesSelection;
                $students_fees_selection->students_fees_id = $studentfee->id;
                $students_fees_selection->student_id = $student->id;
                $students_fees_selection->semester_id = $semester_id;
                $students_fees_selection->fee_id = $faker->numberBetween(1, 10);
                $students_fees_selection->save();
            }

            $studentsubjects = StudentsSubject::join('subjects', 'students_subjects.subject_id', '=', 'subjects.id')->where('student_id', $student->id)->get();

            foreach($studentsubjects as $stdsub){
                $studentexam = new StudentsExam;
                $studentexam->student_id= $student->id;
                $studentexam->semester_id= $semester_id;
                $studentexam->subject_id= $stdsub->subject_id;
                $studentexam->is_absent= 0;

                $theory_max_marks = 100;
                $practical_max_marks = 0;
                $min_val_prc_obt_marks = 0;

                if($stdsub->has_practical){
                    $theory_max_marks = 75;
                    $practical_max_marks = 25;
                    $min_val_prc_obt_marks = 1;
                }

                $theory_obt_marks = $faker->numberBetween(1, $theory_max_marks);
                $practical_obt_marks = $faker->numberBetween($min_val_prc_obt_marks, $practical_max_marks);

                $studentexam->theory_max_marks= $theory_max_marks;
                $studentexam->theory_obt_marks= $theory_obt_marks;
                $studentexam->practical_max_marks= $practical_max_marks;
                $studentexam->practical_obt_marks= $practical_obt_marks;
                $studentexam->total_max_marks= $theory_max_marks + $practical_max_marks;
                $studentexam->total_obt_marks= $theory_obt_marks + $practical_obt_marks;
                $studentexam->save();
            }



            //Semester 2

            $semester_id = 2;

            $studentfee = new StudentsFee;
            $studentfee->student_id = $student->id;
            $studentfee->semester_id = $semester_id;
            $studentfee->bank_id = $faker->numberBetween(1,2);
            $studentfee->challan_no = $faker->numberBetween(1000, 9999);

            $year = $faker->numberBetween(2020, 2021);
            $month = $faker->numberBetween(1, 12);
            $day = $faker->numberBetween(1, 28);
            $dob = $day.'-'.$month.'-'.$year;

            $studentfee->date_of_deposit = date('Y-m-d', strtotime($dob));
            $studentfee->total_amount = $faker->numberBetween(450, 1400);
            $studentfee->save();
            
            $counter = 3;

            StudentsFeesSelection::where('student_id', $student->id)->where('semester_id', $semester_id)->delete();

            for($i=0; $i<$counter; $i++){
                $students_fees_selection = new StudentsFeesSelection;
                $students_fees_selection->students_fees_id = $studentfee->id;
                $students_fees_selection->student_id = $student->id;
                $students_fees_selection->semester_id = $semester_id;
                $students_fees_selection->fee_id = $faker->numberBetween(1, 10);
                $students_fees_selection->save();
            }

            $studentsubjects = StudentsSubject::join('subjects', 'students_subjects.subject_id', '=', 'subjects.id')->where('student_id', $student->id)->get();

            foreach($studentsubjects as $stdsub){
                $studentexam = new StudentsExam;
                $studentexam->student_id= $student->id;
                $studentexam->semester_id= $semester_id;
                $studentexam->subject_id= $stdsub->subject_id;
                $studentexam->is_absent= 0;

                $theory_max_marks = 100;
                $practical_max_marks = 0;
                $min_val_prc_obt_marks = 0;

                if($stdsub->has_practical){
                    $theory_max_marks = 75;
                    $practical_max_marks = 25;
                    $min_val_prc_obt_marks = 1;
                }

                $theory_obt_marks = $faker->numberBetween(1, $theory_max_marks);
                $practical_obt_marks = $faker->numberBetween($min_val_prc_obt_marks, $practical_max_marks);

                $studentexam->theory_max_marks= $theory_max_marks;
                $studentexam->theory_obt_marks= $theory_obt_marks;
                $studentexam->practical_max_marks= $practical_max_marks;
                $studentexam->practical_obt_marks= $practical_obt_marks;
                $studentexam->total_max_marks= $theory_max_marks + $practical_max_marks;
                $studentexam->total_obt_marks= $theory_obt_marks + $practical_obt_marks;
                $studentexam->save();
            }

        }*/


        /*$tehsils = Tehsil::all();

        foreach($tehsils as $tehsil){
            $ex_tehsils = Institution::where('tehsil_id', $tehsil->id)->where('is_ddo', 1)->get()->toArray();
            for($i=1; $i<=10; $i++){
                $institution = new Institution;
                $institution->name = 'Government Primary School, '.$faker->name;
                $institution->is_ddo = 0;
                $selected_ddo = $faker->numberBetween(0, count($ex_tehsils)-1);
                $institution->ddo_id = $ex_tehsils[$selected_ddo]['id'];
                $institution->is_center = 1;
                $institution->tehsil_id = $tehsil->id;
                $institution->save();
            }
        }*/

        echo "<h1>Completed</h1>";
        exit;
    }
}
