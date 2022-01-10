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
use App\Models\SubjectsGroup;
use App\Models\Standard;
use App\Models\Bank;
use App\Models\StudentsFee;
use App\Models\StudentsFeesSelection;
use App\Models\Setting;
use App\Models\District;
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

        $user2 = new User;
        $user2->name = 'User';
        $user2->email = 'assesmentcenter@beeg.gov.pk';
        $user2->password = Hash::make('password123');
        $user2->user_role = 2;
        $user2->save();

        $user1 = new User;
        $user1->name = 'User';
        $user1->email = 'dataentry@beeg.gov.pk';
        $user1->password = Hash::make('password123');
        $user1->user_role = 3;
        $user1->save();

        

        $setting = new Setting;
        $setting->id = 1;
        $setting->board_full_name = "Board Of Elementary Examination, Gilgit Division";
        $setting->minister_name = "Mohammad Azam Khan";
        $setting->minister_image = "/images/1640182853-orig-minister-image.png";
        $setting->ministers_message = '<table style="height: 107px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
        <tbody>
        <tr style="height: 50px;">
        <td style="width: 100%; height: 50px; border-style: none; text-align: center;"><strong>(FROM THE HONORABLE MR. RAJA AZAM KHAN MINISTER EDUCATION GILGIT BALTISTAN)</strong></td>
        </tr>
        <tr style="height: 18px;">
        <td style="width: 100%; height: 18px; border-style: none; text-align: center;">
        <p>Quality education is an essential tool for any nation to achieve progress and success. It develops confidence and helps to build the entire nation. Hence, in acheiving this goal, school education plays a key role in nations life. Education is a dire need for both men and women. Furthermore, educated and trained people can contribute effectively to construct a developed and enlightened society. Consequently, the nurtured and responsible citizens of the society build the future of the country. Moreover, the quality education makes people perfect and nobel.</p>
        <p>&nbsp; &nbsp; &nbsp;It is an immense pleasure to see the progress of the government schools of Gilgit-Baltistan. The government schools always put forward their tremendous effort in nation building.</p>
        <p>&nbsp; &nbsp; May Allah almighty bestow us strength and will to carry this great mission of spreading the light of education.</p>
        </td>
        </tr>
        </tbody>
        </table>';
        $setting->secretary_name = 'Iqbal Hussain';
        $setting->secretary_image = '/images/1640182853-orig-secretary-image.png';
        $setting->secretarys_message = '<table style="height: 107px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
        <tbody>
        <tr style="height: 50px;">
        <td style="width: 100%; height: 50px; border-style: none; text-align: center;"><strong>(FROM THE HONORABLE MR. IQBAL HUSSAIN SECRETARY EDUCATION GILGIT BALTISTAN)</strong></td>
        </tr>
        <tr style="height: 18px;">
        <td style="width: 100%; height: 18px; border-style: none; text-align: center;">
        <p>Quality education is an essential tool for any nation to achieve progress and success. It develops confidence and helps to build the entire nation. Hence, in acheiving this goal, school education plays a key role in nations life. Education is a dire need for both men and women. Furthermore, educated and trained people can contribute effectively to construct a developed and enlightened society. Consequently, the nurtured and responsible citizens of the society build the future of the country. Moreover, the quality education makes people perfect and nobel.</p>
        <p>&nbsp; &nbsp; &nbsp;It is an immense pleasure to see the progress of the government schools of Gilgit-Baltistan. The government schools always put forward their tremendous effort in nation building.</p>
        <p>&nbsp; &nbsp; May Allah almighty bestow us strength and will to carry this great mission of spreading the light of education.</p>
        </td>
        </tr>
        </tbody>
        </table>';
        $setting->controller_name = 'Abdul Hamid';
        $setting->controller_image = '/images/1640182853-orig-controller-image.png';
        $setting->controllers_message = '<table style="height: 107px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
        <tbody>
        <tr style="height: 50px;">
        <td style="width: 100%; height: 50px; border-style: none; text-align: center;"><strong>(FROM THE HONORABLE MR. ABDUL HAMID CONTROLLER EXAMINATION / DIRECTOR ACADEMICS EDUCATION GILGIT BALTISTAN)</strong></td>
        </tr>
        <tr style="height: 18px;">
        <td style="width: 100%; height: 18px; border-style: none; text-align: center;">
        <p>Quality education is an essential tool for any nation to achieve progress and success. It develops confidence and helps to build the entire nation. Hence, in acheiving this goal, school education plays a key role in nations life. Education is a dire need for both men and women. Furthermore, educated and trained people can contribute effectively to construct a developed and enlightened society. Consequently, the nurtured and responsible citizens of the society build the future of the country. Moreover, the quality education makes people perfect and nobel.</p>
        <p>&nbsp; &nbsp; &nbsp;It is an immense pleasure to see the progress of the government schools of Gilgit-Baltistan. The government schools always put forward their tremendous effort in nation building.</p>
        <p>&nbsp; &nbsp; May Allah almighty bestow us strength and will to carry this great mission of spreading the light of education.</p>
        </td>
        </tr>
        </tbody>
        </table>';
        $setting->deputy_controller_name = 'Hashim Ali';
        $setting->save();

        $standard = new Standard;
        $standard->id = 1001;
        $standard->name = '5th';
        $standard->min_subjects = 6;
        $standard->min_age = 9;
        $standard->save();

        $standard1 = new Standard;
        $standard1->name = '8th';
        $standard1->min_subjects = 8;
        $standard1->min_age = 12;
        $standard1->save();

        $bank = new Bank;
        $bank->id = 1001;
        $bank->name = 'KCBL';
        $bank->save();

        $bank2 = new Bank;
        $bank2->name = 'Faisal Bank';
        $bank2->save();

        $district = new District;
        $district->id = 1001;
        $district->name = 'Gilgit';
        $district->save();

        $district1 = new District;
        $district1->name = 'Ghizer';
        $district1->save();

        $district2 = new District;
        $district2->name = 'Nagar';
        $district2->save();

        $district3 = new District;
        $district3->name = 'Hunza';
        $district3->save();

        $tehsil = new Tehsil;
        $tehsil->id = 1001;
        $tehsil->name = 'Gilgit';
        $tehsil->district_id = 1001;
        $tehsil->save();

        $tehsil1 = new Tehsil;
        $tehsil1->name = 'Ghizer';
        $tehsil1->district_id = 1002;
        $tehsil1->save();

        $tehsil2 = new Tehsil;
        $tehsil2->name = 'Nagar';
        $tehsil2->district_id = 1003;
        $tehsil2->save();

        $tehsil3 = new Tehsil;
        $tehsil3->name = 'Hunza';
        $tehsil3->district_id = 1004;
        $tehsil3->save();

        $fee = new Fee;
        $fee->id = 1001;
        $fee->title = 'Registration Fee';
        $fee->amount = 100;
        $fee->save();

        $fee1 = new Fee;
        $fee1->title = 'Marksheet Fee';
        $fee1->amount = 100;
        $fee1->save();

        $fee2 = new Fee;
        $fee2->title = 'Examination Fee (5th) (Regular)';
        $fee2->amount = 250;
        $fee2->save();

        $fee3 = new Fee;
        $fee3->title = 'Examination Fee (5th) (Private)';
        $fee3->amount = 600;
        $fee3->save();

        $fee4 = new Fee;
        $fee4->title = 'Examination Fee (8th) (Regular)';
        $fee4->amount = 350;
        $fee4->save();

        $fee5 = new Fee;
        $fee5->title = 'Examination Fee (8th) (Private)';
        $fee5->amount = 800;
        $fee5->save();

        $fee6 = new Fee;
        $fee6->title = 'Late Fee (5th)';
        $fee6->amount = 150;
        $fee6->save();

        $fee7 = new Fee;
        $fee7->title = 'Double Late Fee (5th)';
        $fee7->amount = 300;
        $fee7->save();

        $fee8 = new Fee;
        $fee8->title = 'Late Fee (8th)';
        $fee8->amount = 200;
        $fee8->save();

        $fee9 = new Fee;
        $fee9->title = 'Double Late Fee (8th)';
        $fee9->amount = 400;
        $fee9->save();

        $subject = new Subject;
        $subject->id = 1001;
        $subject->name = 'English';
        $subject->short_name = 'ENG';
        $subject->is_optional = 0;
        $subject->has_practical = 0;
        $subject->save();

        $subject1 = new Subject;
        $subject1->name = 'Urdu';
        $subject1->short_name = 'URD';
        $subject1->is_optional = 0;
        $subject1->has_practical = 0;
        $subject1->save();

        $subject2 = new Subject;
        $subject2->name = 'Mathematics';
        $subject2->short_name = 'MTH';
        $subject2->is_optional = 0;
        $subject2->has_practical = 0;
        $subject2->save();

        $subject3 = new Subject;
        $subject3->name = 'Islamiat';
        $subject3->short_name = 'ISL';
        $subject3->is_optional = 0;
        $subject3->has_practical = 1;
        $subject3->save();

        $subject4 = new Subject;
        $subject4->name = 'General Science';
        $subject4->short_name = 'GSC';
        $subject4->is_optional = 0;
        $subject4->has_practical = 0;
        $subject4->save();

        $subject5 = new Subject;
        $subject5->name = 'Social Studies';
        $subject5->short_name = 'SST';
        $subject5->is_optional = 0;
        $subject5->has_practical = 0;
        $subject5->save();

        $subject6 = new Subject;
        $subject6->name = 'History And Geography';
        $subject6->short_name = 'HAG';
        $subject6->is_optional = 0;
        $subject6->has_practical = 0;
        $subject6->save();

        $subject7 = new Subject;
        $subject7->name = 'Drawing';
        $subject7->short_name = 'DRW';
        $subject7->is_optional = 1;
        $subject7->has_practical = 0;
        $subject7->save();

        $subject8 = new Subject;
        $subject8->name = 'Computer';
        $subject8->short_name = 'CMP';
        $subject8->is_optional = 1;
        $subject8->has_practical = 1;
        $subject8->save();

        $subject9 = new Subject;
        $subject9->name = 'Home Economics';
        $subject9->short_name = 'HEC';
        $subject9->is_optional = 1;
        $subject9->has_practical = 1;
        $subject9->save();

        $subject10 = new Subject;
        $subject10->name = 'Agriculture';
        $subject10->short_name = 'AGR';
        $subject10->is_optional = 1;
        $subject10->has_practical = 0;
        $subject10->save();

        $subject11 = new Subject;
        $subject11->name = 'Arabic';
        $subject11->short_name = 'ARB';
        $subject11->is_optional = 1;
        $subject11->has_practical = 0;
        $subject11->save();

        $subjectgroup = new SubjectsGroup;
        $subjectgroup->subject_id = 1001;
        $subjectgroup->class_id = 1001;
        $subjectgroup->save();

        $subjectgroup1 = new SubjectsGroup;
        $subjectgroup1->subject_id = 1002;
        $subjectgroup1->class_id = 1001;
        $subjectgroup1->save();

        $subjectgroup2 = new SubjectsGroup;
        $subjectgroup2->subject_id = 1003;
        $subjectgroup2->class_id = 1001;
        $subjectgroup2->save();

        $subjectgroup3 = new SubjectsGroup;
        $subjectgroup3->subject_id = 1004;
        $subjectgroup3->class_id = 1001;
        $subjectgroup3->save();

        $subjectgroup4 = new SubjectsGroup;
        $subjectgroup4->subject_id = 1005;
        $subjectgroup4->class_id = 1001;
        $subjectgroup4->save();

        $subjectgroup5 = new SubjectsGroup;
        $subjectgroup5->subject_id = 1006;
        $subjectgroup5->class_id = 1001;
        $subjectgroup5->save();

        $subjectgroup6 = new SubjectsGroup;
        $subjectgroup6->subject_id = 1001;
        $subjectgroup6->class_id = 1002;
        $subjectgroup6->save();

        $subjectgroup7 = new SubjectsGroup;
        $subjectgroup7->subject_id = 1002;
        $subjectgroup7->class_id = 1002;
        $subjectgroup7->save();

        $subjectgroup8 = new SubjectsGroup;
        $subjectgroup8->subject_id = 1003;
        $subjectgroup8->class_id = 1002;
        $subjectgroup8->save();

        $subjectgroup9 = new SubjectsGroup;
        $subjectgroup9->subject_id = 1004;
        $subjectgroup9->class_id = 1002;
        $subjectgroup9->save();

        $subjectgroup10 = new SubjectsGroup;
        $subjectgroup10->subject_id = 1005;
        $subjectgroup10->class_id = 1002;
        $subjectgroup10->save();

        $subjectgroup11 = new SubjectsGroup;
        $subjectgroup11->subject_id = 1007;
        $subjectgroup11->class_id = 1002;
        $subjectgroup11->save();

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

        echo "Completed";
        exit;
    }
}
