<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use DateTime;

class StudentsExam extends Model
{
    use HasFactory;

    protected $fillable = array('semester_id', 'student_id', 'subject_id', 'is_absent', 'sheet_no', 'theory_max_marks', 'theory_obt_marks', 'practical_max_marks', 'practical_obt_marks', 'total_max_marks', 'total_obt_marks');

	public static $rules = array(
        'student_id'=>'required|integer',
        'subject_id'=>'required|integer',
        'semester_id'=>'required|integer',
        'sheet_no'=>'required|numeric',
        'theory_max_marks'=>'required|numeric',
        'theory_obt_marks'=>'required|numeric|lte:theory_max_marks',
        'practical_max_marks'=>'required|numeric',
        'practical_obt_marks'=>'required|numeric|lte:practical_max_marks',
        'total_max_marks'=>'required|numeric',
        'total_obt_marks'=>'required|numeric|lte:total_max_marks'
	);

    public static function getSubjects($session_id, $semester_id, $center_id, $standard_id){
        $subjects = Subject::join('students_subjects', 'students_subjects.subject_id', '=', 'subjects.id')->join('students', 'students.id', 'students_subjects.student_id')->join('students_exams', 'students_exams.subject_id', '=', 'students_subjects.subject_id')->where('students.center_id', $center_id)->where('students.class_id', $standard_id)->where('students_exams.semester_id', $semester_id)->where('students.session_id', $session_id)->groupBy('subjects.id')->orderBy('subjects.id', 'ASC')->get(['subjects.id', 'subjects.short_name']);


        return $subjects;
    }

    public static function getSubjectsCombined($session_id, $center_id, $standard_id){
        $subjects = Subject::join('students_subjects', 'students_subjects.subject_id', '=', 'subjects.id')->join('students', 'students.id', 'students_subjects.student_id')->join('students_exams', 'students_exams.subject_id', '=', 'students_subjects.subject_id')->where('students.center_id', $center_id)->where('students.class_id', $standard_id)->where('students.session_id', $session_id)->groupBy('subjects.id')->orderBy('subjects.id', 'ASC')->get(['subjects.id', 'subjects.short_name']);


        return $subjects;
    }

    public static function getSubjectsByDistrictToppersCombined($session_id, $standard_id) {
        $subjects = Subject::join('students_subjects', 'students_subjects.subject_id', '=', 'subjects.id')->join('students', 'students.id', 'students_subjects.student_id')->join('students_exams', 'students_exams.subject_id', '=', 'students_subjects.subject_id')->where('students.class_id', $standard_id)->where('students.session_id', $session_id)->groupBy('subjects.id')->orderBy('subjects.id', 'ASC')->get(['subjects.id', 'subjects.short_name']);


        return $subjects;
    }

    public static function getCenters($session_id, $standard_id, $district_id){
        $institutions = Institution::join('students', 'students.center_id', '=', 'institutions.id')->join('standards', 'standards.id', '=', 'students.class_id')->join('tehsils', 'tehsils.id', '=', 'institutions.tehsil_id')->join('districts', 'districts.id', '=', 'tehsils.district_id')->where('institutions.is_center', 1)->where('districts.id', $district_id)->where('students.session_id', $session_id)->where('standards.id', $standard_id)->orderBy('institutions.id', 'ASC')->groupBy('institutions.id')->get(['institutions.id', 'institutions.name', DB::raw('districts.name AS district_name')]);
        
        return $institutions;
    }

    public static function getGazettes($session_id, $district_id, $center_id, $standard_id){

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(students.date_of_birth, '%d-%m-%Y') AS date_of_birth";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', students.date_of_birth) AS date_of_birth";
        }

        $gazettes = Gazette::join('institutions', 'institutions.id', '=', 'gazettes.institution_id')->join('students', 'students.id', '=', 'gazettes.student_id')->where('gazettes.session_id', $session_id)->where('gazettes.district_id', $district_id)->where('gazettes.center_id', $center_id)->where('gazettes.class_id', $standard_id)->orderBy('students.id', 'ASC')->get(['students.id', DB::raw('institutions.name AS institution_name'), 'students.name', 'students.father_name', DB::raw($date_of_birth), 'gazettes.total_obt_marks', 'gazettes.total_max_marks', 'gazettes.percentage_marks', 'gazettes.grade', 'gazettes.result']);

        return $gazettes;
    }

    public static function getToppersGazetteByDistricts($session_id, $standard_id, $district_id) {

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(s.date_of_birth, '%d-%m-%Y') AS date_of_birth";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth";
        }

        $gazettes = Gazette::join('institutions', 'institutions.id', '=', 'gazettes.center_id')->join('students', 'students.id', '=', 'gazettes.student_id')->where('gazettes.session_id', $session_id)->where('gazettes.district_id', $district_id)->where('gazettes.class_id', $standard_id)->orderBy('gazettes.total_obt_marks', 'DESC')->orderBy('students.id', 'ASC')->limit(3)->get(['students.id', DB::raw('institutions.id AS center_id'), DB::raw('institutions.name AS center_name'), 'students.name', 'students.father_name', DB::raw($date_of_birth), 'gazettes.total_obt_marks', 'gazettes.total_max_marks', 'gazettes.result']);
        return $gazettes;
    }

    public static function getOverAllToppersList($session_id, $standard_id) {

        if(DB::connection()->getDriverName() == 'mysql') {
            $date_of_birth = "DATE_FORMAT(s.date_of_birth, '%d-%m-%Y') AS date_of_birth";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $date_of_birth = "strftime('%d-%m-%Y', s.date_of_birth) AS date_of_birth";
        }

        $gazettes = Gazette::join('institutions', 'institutions.id', '=', 'gazettes.center_id')->join('students', 'students.id', '=', 'gazettes.student_id')->join('districts', 'districts.id', '=', 'gazettes.district_id')->where('gazettes.session_id', $session_id)->where('gazettes.class_id', $standard_id)->orderBy('gazettes.total_obt_marks', 'DESC')->orderBy('students.id', 'ASC')->limit(10)->get(['students.id', DB::raw('institutions.id AS center_id'), DB::raw('institutions.name AS center_name'), 'students.name', 'students.father_name', DB::raw($date_of_birth), 'gazettes.total_obt_marks', 'gazettes.total_max_marks', 'gazettes.result', DB::raw('districts.name AS district_name')]);
        return $gazettes;
    }

    public static function getSubjectsAndMarksDetails($session_id, $semester_id, $center_id, $standard_id, $student_id){
        $subjects = Subject::join('students_exams', 'students_exams.subject_id', '=', 'subjects.id')->join('students', 'students.id', 'students_exams.student_id')->where('students.center_id', $center_id)->where('students.class_id', $standard_id)->where('students_exams.semester_id', $semester_id)->where('students.session_id', $session_id)->where('students.id', $student_id)->groupBy('subjects.id')->orderBy('subjects.id', 'ASC')->get(['subjects.id', 'subjects.name', 'subjects.is_optional', 'students_exams.student_id', 'students_exams.semester_id', 'students_exams.is_absent', 'students_exams.sheet_no', 'students_exams.theory_max_marks', 'students_exams.theory_obt_marks', 'students_exams.practical_max_marks', 'students_exams.practical_obt_marks', 'students_exams.total_max_marks', 'students_exams.total_obt_marks'])->toArray();

        $transposed_subjects = array();

        foreach ($subjects as $row => $columns) {
          foreach ($columns as $row2 => $column2) {
            $transposed_subjects[$row2][$row] = $column2;
          }
        }

        return $transposed_subjects;
    }

    public static function getSubjectsAndMarksDetailsCombined($session_id, $center_id, $standard_id, $student_id){
        $subjects = DB::select(DB::raw("
                    select 
                        subjects.id, 
                        subjects.name, 
                        subjects.is_optional, 
                        students_exams.student_id, 
                        students_exams.semester_id, 
                        #students_exams.is_absent,
                        (CASE  WHEN SUM(students_exams.total_obt_marks)=0 AND SUM(students_exams.is_absent)=2 THEN 1 ELSE 0 END) AS is_absent,
                        students_exams.sheet_no, 
                        ROUND(((SUM(students_exams.theory_max_marks)/100)*semesters.division_percentage), 0) AS theory_max_marks, 
                        ROUND(((SUM(students_exams.theory_obt_marks)/100)*semesters.division_percentage), 0) AS theory_obt_marks, 
                        ROUND(((SUM(students_exams.practical_max_marks)/100)*semesters.division_percentage), 0) AS practical_max_marks, 
                        ROUND(((SUM(students_exams.practical_obt_marks)/100)*semesters.division_percentage), 0) AS practical_obt_marks, 
                        ROUND(((SUM(students_exams.total_max_marks)/100)*semesters.division_percentage), 0) AS total_max_marks, 
                        ROUND(((SUM(students_exams.total_obt_marks)/100)*semesters.division_percentage), 0) AS total_obt_marks 
                    from subjects 
                    inner join students_exams 
                    on students_exams.subject_id = subjects.id 
                    inner join students 
                    on students.id = students_exams.student_id
                    inner join semesters
                    on semesters.id = students_exams.semester_id
                    where students.center_id = ".$center_id." 
                    and students.class_id = ".$standard_id." 
                    and students.session_id = ".$session_id." 
                    and students.id = ".$student_id." 
                    GROUP BY subjects.id
                    order by subjects.id asc;
                "));

        $transposed_subjects = array();

        foreach ($subjects as $row => $columns) {
          foreach ($columns as $row2 => $column2) {
            $transposed_subjects[$row2][$row] = $column2;
          }
        }

        return $transposed_subjects;
    }

    public static function getSubjectsAndMarksDetailsByDistrictToppers($session_id, $standard_id, $student_id) {
        $subjects = DB::select(DB::raw("
                    select 
                        subjects.id, 
                        subjects.name, 
                        subjects.is_optional, 
                        students_exams.student_id, 
                        students_exams.semester_id, 
                        #students_exams.is_absent,
                        (CASE  WHEN SUM(students_exams.total_obt_marks)=0 AND SUM(students_exams.is_absent)=2 THEN 1 ELSE 0 END) AS is_absent,
                        students_exams.sheet_no, 
                        ROUND(((SUM(students_exams.theory_max_marks)/100)*semesters.division_percentage), 0) AS theory_max_marks, 
                        ROUND(((SUM(students_exams.theory_obt_marks)/100)*semesters.division_percentage), 0) AS theory_obt_marks, 
                        ROUND(((SUM(students_exams.practical_max_marks)/100)*semesters.division_percentage), 0) AS practical_max_marks, 
                        ROUND(((SUM(students_exams.practical_obt_marks)/100)*semesters.division_percentage), 0) AS practical_obt_marks, 
                        ROUND(((SUM(students_exams.total_max_marks)/100)*semesters.division_percentage), 0) AS total_max_marks, 
                        ROUND(((SUM(students_exams.total_obt_marks)/100)*semesters.division_percentage), 0) AS total_obt_marks 
                    from subjects 
                    inner join students_exams 
                    on students_exams.subject_id = subjects.id 
                    inner join students 
                    on students.id = students_exams.student_id
                    inner join semesters
                    on semesters.id = students_exams.semester_id
                    where students.class_id = ".$standard_id." 
                    and students.session_id = ".$session_id." 
                    and students.id = ".$student_id." 
                    GROUP BY subjects.id
                    order by subjects.id asc;
                "));

        $transposed_subjects = array();

        foreach ($subjects as $row => $columns) {
          foreach ($columns as $row2 => $column2) {
            $transposed_subjects[$row2][$row] = $column2;
          }
        }

        return $transposed_subjects;
    }

    public static function getStudents($session_id, $semester_id, $standard_id, $center_id){
        $students = DB::select(DB::raw("
                    SELECT
                        d.name AS district_name,
                        t.name AS tehsil_name,
                        i.id AS center_id,
                        i.name AS center_name,
                        s.name AS student_name,
                        s.father_name,
                        std.name AS class_name,
                        s.id AS roll_no
                        FROM students AS s
                        JOIN institutions AS i
                        ON s.center_id = i.id
                        JOIN tehsils AS t
                        ON i.tehsil_id = t.id
                        JOIN districts AS d
                        ON t.district_id = d.id
                        JOIN standards AS std
                        ON s.class_id = std.id
                        JOIN students_exams AS se
                        ON se.student_id = s.id
                        WHERE s.session_id = ". $session_id ."
                        AND s.class_id = ". $standard_id ."
                        AND s.center_id = ". $center_id ."
                        GROUP BY s.id
                        ORDER BY i.id;
                "));

        return $students;
    }

    public static function getStudentsCombined($session_id, $standard_id, $center_id){
        $students = DB::select(DB::raw("
                    SELECT
                        d.name AS district_name,
                        t.name AS tehsil_name,
                        i.id AS center_id,
                        i.name AS center_name,
                        s.name AS student_name,
                        s.father_name,
                        std.name AS class_name,
                        s.id AS roll_no
                        FROM students AS s
                        JOIN institutions AS i
                        ON s.center_id = i.id
                        JOIN tehsils AS t
                        ON i.tehsil_id = t.id
                        JOIN districts AS d
                        ON t.district_id = d.id
                        JOIN standards AS std
                        ON s.class_id = std.id
                        JOIN students_exams AS se
                        ON se.student_id = s.id
                        WHERE s.session_id = ". $session_id ."
                        AND s.class_id = ". $standard_id ."
                        AND s.center_id = ". $center_id ."
                        GROUP BY s.id
                        ORDER BY i.id;
                "));

        return $students;
    }

    public static function getTotalPassFailStudents($session_id, $standard_id){
        $results = DB::select(DB::raw("
                    SELECT result, COUNT(result) AS student_details
                    FROM gazettes
                    WHERE session_id = :session_id AND class_id = :standard_id
                    GROUP BY result;
                "), array('session_id'=>$session_id, 'standard_id'=>$standard_id));

        //dd($results);
        $results_arr = array();

        $total_students_appeared = 0;
        foreach($results as $result){
            if($result->result == 0){
                $results_arr['pass_students'] = $result->student_details;
            } elseif($result->result==1){
                $results_arr['promoted_students'] = $result->student_details;
            } else {
                $results_arr['reappear_students'] = $result->student_details;
            }
            $total_students_appeared+=$result->student_details;
        }

        $results_arr['total_students_appeared'] = $total_students_appeared;

        $percentages_arr = array(
            'PASS' => round(($results_arr['pass_students']/$results_arr['total_students_appeared'])*100, 0),
            'PROMOTED' => round(($results_arr['promoted_students']/$results_arr['total_students_appeared'])*100, 0),
            'REAPPEAR' => round(($results_arr['reappear_students']/$results_arr['total_students_appeared'])*100, 0)
        );

        $combined_arr = array();
        $combined_arr['results_arr'] = $results_arr;
        $combined_arr['percentages_arr'] = json_encode($percentages_arr);

        return $combined_arr;
    }


    public static function getTotalPassFailStudentsByDistricts($session_id, $standard_id){
        $results = DB::select(DB::raw("
                    SELECT d.id, d.name,
                    (
                        SELECT COUNT(gazettes.result) FROM gazettes WHERE gazettes.district_id = g.district_id AND gazettes.session_id = g.session_id
                    ) AS total_students_appeared,
                    (
                        SELECT COUNT(gazettes.result) FROM gazettes WHERE gazettes.district_id = g.district_id AND gazettes.result = 0 AND gazettes.session_id = g.session_id
                    ) AS pass_students,
                    (
                        SELECT COUNT(gazettes.result) FROM gazettes WHERE gazettes.district_id = g.district_id AND gazettes.result = 1 AND gazettes.session_id = g.session_id
                    ) AS promoted_students,
                    (
                        SELECT COUNT(gazettes.result) FROM gazettes WHERE gazettes.district_id = g.district_id AND gazettes.result = 2 AND gazettes.session_id = g.session_id
                    ) AS reappear_students
                    FROM gazettes g
                    JOIN districts d
                    ON d.id = g.district_id
                    WHERE g.session_id = :session_id AND g.class_id = :standard_id
                    GROUP BY d.id;
                "), array('session_id'=>$session_id, 'standard_id'=>$standard_id));

        $percentages_arr = array();

        $percentages_arr['cols'][] = array('label' => 'Districts', 'type' => 'string');
        $percentages_arr['cols'][] = array('label' => 'Pass', 'type' => 'number');
        $percentages_arr['cols'][] = array('label' => 'Promoted', 'type' => 'number');
        $percentages_arr['cols'][] = array('label' => 'Reappear', 'type' => 'number');

        $i=0;
        foreach($results as $result){
            $pass_stds = round(($result->pass_students/$result->total_students_appeared)*100, 0);
            $promoted_stds = round(($result->promoted_students/$result->total_students_appeared)*100, 0);
            $reappear_stds = round(($result->reappear_students/$result->total_students_appeared)*100, 0);
            $percentages_arr['rows'][] = array('c' => array( array('v'=>$result->name), array('v'=>$pass_stds),array('v'=>$promoted_stds), array('v'=>$reappear_stds)) );
        }

        $combined_arr = array();
        $combined_arr['results'] = json_encode($results);
        $combined_arr['percentages_arr'] = json_encode($percentages_arr);

        return $combined_arr;
    }

    public static function getTotalPassFailStudentsBySubjects($session_id, $standard_id){
        $results = DB::select(DB::raw("
                    SELECT s.id, s.name,
                    (
                        SELECT COUNT(*) FROM students_exams 
                        JOIN students
                        ON students_exams.student_id = students.id
                        WHERE students_exams.subject_id = s.id 
                        AND students.session_id = g.session_id
                        AND students.class_id = g.class_id
                        GROUP BY students_exams.subject_id
                    ) as total_students_appeared,
                    (
                        SELECT COUNT(*) FROM students_exams 
                        JOIN students
                        ON students_exams.student_id = students.id
                        WHERE ((students_exams.total_obt_marks/students_exams.total_max_marks)*100) >= 33
                        AND students_exams.subject_id = s.id 
                        AND students.session_id = g.session_id
                        AND students.class_id = g.class_id
                        GROUP BY students_exams.subject_id
                    ) as pass_students,
                    (
                        SELECT COUNT(*) FROM students_exams 
                        JOIN students
                        ON students_exams.student_id = students.id
                        WHERE ((students_exams.total_obt_marks/students_exams.total_max_marks)*100) < 33
                        AND students_exams.subject_id = s.id 
                        AND students.session_id = g.session_id
                        AND students.class_id = g.class_id
                        GROUP BY students_exams.subject_id
                    ) as fail_students
                    FROM gazettes g
                    JOIN students_exams se
                    ON g.student_id = se.student_id
                    JOIN subjects s
                    ON se.subject_id = s.id
                    WHERE g.session_id = :session_id AND g.class_id = :standard_id
                    GROUP BY s.id;
                "), array('session_id'=>$session_id, 'standard_id'=>$standard_id));

        $percentages_arr = array();

        $percentages_arr['cols'][] = array('label' => 'Subjects', 'type' => 'string');
        $percentages_arr['cols'][] = array('label' => 'Pass', 'type' => 'number');
        $percentages_arr['cols'][] = array('label' => 'Fail', 'type' => 'number');

        $i=0;
        foreach($results as $result){
            if($result->total_students_appeared > 0 ){
                $pass_stds = round(($result->pass_students/$result->total_students_appeared)*100, 0);
                $fail_stds = round(($result->fail_students/$result->total_students_appeared)*100, 0);
            } else {
                $pass_stds = 0;
                $fail_stds = 0;
            }
            
            $percentages_arr['rows'][] = array('c' => array( array('v'=>$result->name), array('v'=>$pass_stds),array('v'=>$fail_stds)) );
        }

        $combined_arr = array();
        $combined_arr['results'] = json_encode($results);
        $combined_arr['percentages_arr'] = json_encode($percentages_arr);

        return $combined_arr;
    }

    public static function getTotalPassFailStudentsBySubjectsAndDistricts($session_id, $standard_id, $district_id){
        $results = DB::select(DB::raw("
                    SELECT s.id, s.name,
                    (
                        SELECT COUNT(*) FROM students_exams 
                        JOIN students
                        ON students_exams.student_id = students.id
                        WHERE students_exams.subject_id = s.id 
                        AND students.session_id = g.session_id
                        AND students.class_id = g.class_id
                        GROUP BY students_exams.subject_id
                    ) as total_students_appeared,
                    (
                        SELECT COUNT(*) FROM students_exams 
                        JOIN students
                        ON students_exams.student_id = students.id
                        WHERE ((students_exams.total_obt_marks/students_exams.total_max_marks)*100) >= 33
                        AND students_exams.subject_id = s.id 
                        AND students.session_id = g.session_id
                        AND students.class_id = g.class_id
                        GROUP BY students_exams.subject_id
                    ) as pass_students,
                    (
                        SELECT COUNT(*) FROM students_exams 
                        JOIN students
                        ON students_exams.student_id = students.id
                        WHERE ((students_exams.total_obt_marks/students_exams.total_max_marks)*100) < 33
                        AND students_exams.subject_id = s.id 
                        AND students.session_id = g.session_id
                        AND students.class_id = g.class_id
                        GROUP BY students_exams.subject_id
                    ) as fail_students
                    FROM gazettes g
                    JOIN students_exams se
                    ON g.student_id = se.student_id
                    JOIN subjects s
                    ON se.subject_id = s.id
                    WHERE g.session_id = :session_id 
                    AND g.class_id = :standard_id
                    AND g.district_id = :district_id
                    GROUP BY s.id;
                "), array('session_id'=>$session_id, 'standard_id'=>$standard_id, 'district_id'=>$district_id));

        $percentages_arr = array();

        $percentages_arr['cols'][] = array('label' => 'Subjects', 'type' => 'string');
        $percentages_arr['cols'][] = array('label' => 'Pass', 'type' => 'number');
        $percentages_arr['cols'][] = array('label' => 'Fail', 'type' => 'number');

        $i=0;
        foreach($results as $result){
            if($result->total_students_appeared > 0) {
                $pass_stds = round(($result->pass_students/$result->total_students_appeared)*100, 0);
                $fail_stds = round(($result->fail_students/$result->total_students_appeared)*100, 0);
            } else {
                $pass_stds = 0;
                $fail_stds = 0;
            }
            
            
            $percentages_arr['rows'][] = array('c' => array( array('v'=>$result->name), array('v'=>$pass_stds),array('v'=>$fail_stds)) );
        }

        $combined_arr = array();
        $combined_arr['results'] = json_encode($results);
        $combined_arr['percentages_arr'] = json_encode($percentages_arr);

        return $combined_arr;
    }

    public static function getToppersByDistrict($session_id, $class_id, $district_id){
        $results = DB::select(DB::raw("
                SELECT s.id, s.name, s.father_name, i.id AS center_code, i.name AS center_name, s.name AS class_name, d.name AS district_name, g.total_obt_marks, ROUND((g.total_obt_marks/g.total_max_marks)*100, 2) AS marks_percentage, g.result
                    FROM students AS s
                    JOIN gazettes AS g
                    ON g.student_id = s.id
                    JOIN institutions AS i
                    ON i.id = s.center_id
                    JOIN districts AS d
                    ON d.id = g.district_id
                    JOIN standards AS ss
                    ON ss.id = g.class_id
                    WHERE g.result = 0 
                    AND g.district_id = :district_id
                    AND g.session_id = :session_id 
                    AND g.class_id = :standard_id
                    ORDER BY g.total_obt_marks DESC;
            "), array('session_id'=>$session_id, 'standard_id'=>$class_id, 'district_id'=>$district_id));

        $results_arr = array();

        $i = 1;
        $index = 0;
        $total_obt_marks_arr = array();
        foreach($results as $result){
            $total_obt_marks_arr[$index] = $result->total_obt_marks;
            $index++;
        }

        $occurences = array_count_values($total_obt_marks_arr);

        $counter = 1;
        $index = 0;
        $count = 0;
        foreach($occurences as $occurence){
            if($counter != 4){    
                for($j=0; $j<$occurence; $j++){
                    $results_arr[$index][$j]['id'] = $results[$count+$j]->id;
                    $results_arr[$index][$j]['name'] = $results[$count+$j]->name;
                    $results_arr[$index][$j]['father_name'] = $results[$count+$j]->father_name;
                    $results_arr[$index][$j]['center_code'] = $results[$count+$j]->center_code;
                    $results_arr[$index][$j]['center_name'] = $results[$count+$j]->center_name;
                    $results_arr[$index][$j]['class_name'] = $results[$count+$j]->class_name;
                    $results_arr[$index][$j]['district_name'] = $results[$count+$j]->district_name;
                    $results_arr[$index][$j]['total_obt_marks'] = $results[$count+$j]->total_obt_marks;
                    $results_arr[$index][$j]['marks_percentage'] = $results[$count+$j]->marks_percentage;
                    $results_arr[$index][$j]['result'] = $results[$count+$j]->result;
                    $results_arr[$index][$j]['position'] = $counter;
                }
                $count = $count+$occurence;
            } else {
                break;
            }
            $counter++;
            $index++;
        }

        return $results_arr;
    }

    public static function getToppersByOverAllClass($session_id, $class_id){
        $results = DB::select(DB::raw("
                SELECT s.id, s.name, s.father_name, i.id AS center_code, i.name AS center_name, s.name AS class_name, d.name AS district_name, g.total_obt_marks, ROUND((g.total_obt_marks/g.total_max_marks)*100, 2) AS marks_percentage, g.result
                    FROM students AS s
                    JOIN gazettes AS g
                    ON g.student_id = s.id
                    JOIN institutions AS i
                    ON i.id = s.center_id
                    JOIN districts AS d
                    ON d.id = g.district_id
                    JOIN standards AS ss
                    ON ss.id = g.class_id
                    WHERE g.result = 0 
                    AND g.session_id = :session_id 
                    AND g.class_id = :standard_id
                    ORDER BY g.total_obt_marks DESC;
            "), array('session_id'=>$session_id, 'standard_id'=>$class_id));

        $results_arr = array();

        $i = 1;
        $index = 0;
        $total_obt_marks_arr = array();
        foreach($results as $result){
            $total_obt_marks_arr[$index] = $result->total_obt_marks;
            $index++;
        }

        $occurences = array_count_values($total_obt_marks_arr);

        $counter = 1;
        $index = 0;
        $count = 0;
        foreach($occurences as $occurence){
            if($counter != 11){    
                for($j=0; $j<$occurence; $j++){
                    $results_arr[$index][$j]['id'] = $results[$count+$j]->id;
                    $results_arr[$index][$j]['name'] = $results[$count+$j]->name;
                    $results_arr[$index][$j]['father_name'] = $results[$count+$j]->father_name;
                    $results_arr[$index][$j]['center_code'] = $results[$count+$j]->center_code;
                    $results_arr[$index][$j]['center_name'] = $results[$count+$j]->center_name;
                    $results_arr[$index][$j]['class_name'] = $results[$count+$j]->class_name;
                    $results_arr[$index][$j]['district_name'] = $results[$count+$j]->district_name;
                    $results_arr[$index][$j]['total_obt_marks'] = $results[$count+$j]->total_obt_marks;
                    $results_arr[$index][$j]['marks_percentage'] = $results[$count+$j]->marks_percentage;
                    $results_arr[$index][$j]['result'] = $results[$count+$j]->result;
                    $results_arr[$index][$j]['position'] = $counter;
                }
                $count = $count+$occurence;
            } else {
                break;
            }
            $counter++;
            $index++;
        }

        return $results_arr;
    }

    public static function getMonthOfExams($session_id, $class_id, $student_id, $year) {

        if(DB::connection()->getDriverName() == 'mysql') {
            $month = "DATE_FORMAT(d.paper_date, '%m') AS month";
        }

        if(DB::connection()->getDriverName() == 'sqlite') {
            $month = "strftime('%m', d.paper_date) AS month";
        }

        $results = DB::select(DB::raw('
                        SELECT ss.subject_id, d.paper_date, s.year, d.semester_id,
                        '.$month.'
                        FROM datesheets d
                        JOIN students_subjects ss
                        ON ss.subject_id = d.subject_id
                        JOIN sessions s
                        ON d.session_id = s.id
                        WHERE d.session_id = :session_id
                        AND d.class_id = :class_id
                        AND ss.student_id = :student_id
                        GROUP BY ss.subject_id, d.semester_id
                        ORDER BY d.semester_id DESC, d.paper_date DESC;
                    '), array('session_id'=>$session_id, 'class_id'=>$class_id, 'student_id'=>$student_id));

        $months_arr = array();
        $i = 0;

        $current_semester = NULL;
        $previous_semester = NULL;

        $recent_month_arr = array();

        foreach($results as $result){

            if($current_semester == $previous_semester){
                $current_semester = $result->semester_id;
                $recent_month_arr[$i] = $result->month;
            } else {
                $months_arr[$i] = $result->month;
            }

            $previous_semester = $current_semester;
            $i++;
        }

        $count_value_arr = array_count_values($recent_month_arr);

        $max_value = max($count_value_arr);

        $final_month = 1;

        foreach($count_value_arr as $key => $value){
            if($value == $max_value){
                $final_month = $key;
                break;
            }
        }

        $monthNum  = 3;
        $dateObj   = DateTime::createFromFormat('!m', $final_month);
        $monthName = $dateObj->format('F');

        return $monthName."-".$year;
    }

    public static function numberToWords($num)
    {

        $singles = array(
        0 =>"ZERO",
        1 => "ONE",
        2 => "TWO",
        3 => "THREE",
        4 => "FOUR",
        5 => "FIVE",
        6 => "SIX",
        7 => "SEVEN",
        8 => "EIGHT",
        9 => "NINE",
        10 => "TEN",
        11 => "ELEVEN",
        12 => "TWELVE",
        13 => "THIRTEEN",
        14 => "FOURTEEN",
        15 => "FIFTEEN",
        16 => "SIXTEEN",
        17 => "SEVENTEEN",
        18 => "EIGHTEEN",
        19 => "NINETEEN",
        "014" => "FOURTEEN"
        );

        $tens = array( 
        0 => "ZERO",
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY", 
        4 => "FORTY", 
        5 => "FIFTY", 
        6 => "SIXTY", 
        7 => "SEVENTY", 
        8 => "EIGHTY", 
        9 => "NINETY" 
        ); 

        $hundreds = array( 
        "HUNDRED", 
        "THOUSAND", 
        "MILLION", 
        "BILLION", 
        "TRILLION", 
        "QUARDRILLION" 
        ); 

        /*limit t quadrillion */
        $num = number_format($num,2,".",","); 
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $numberofdesimal = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
        krsort($whole_arr,1); 
        $express_number = ""; 
        foreach($whole_arr as $key => $i){
            
        while(substr($i,0,1)=="0")
                $i=substr($i,1,5);
        if($i < 20){ 
        /* echo "getting:".$i; */
        $express_number .= $singles[$i]; 
        }elseif($i < 100){ 
        if(substr($i,0,1)!="0")  $express_number .= $tens[substr($i,0,1)]; 
        if(substr($i,1,1)!="0") $express_number .= " ".$singles[substr($i,1,1)]; 
        }else{ 
        if(substr($i,0,1)!="0") $express_number .= $singles[substr($i,0,1)]." ".$hundreds[0]; 
        if(substr($i,1,1)!="0")$express_number .= " ".$tens[substr($i,1,1)]; 
        if(substr($i,2,1)!="0")$express_number .= " ".$singles[substr($i,2,1)]; 
        } 
        if($key > 0){ 
        $express_number .= " ".$hundreds[$key]." "; 
        }
        } 
        if($numberofdesimal > 0){
        $express_number .= " and ";
        if($numberofdesimal < 20){
        $express_number .= $singles[$numberofdesimal];
        }elseif($numberofdesimal < 100){
        $express_number .= $tens[substr($numberofdesimal,0,1)];
        $express_number .= " ".$singles[substr($numberofdesimal,1,1)];
        }
        }
        return $express_number;
    }

    public static function getSubjectsForMarkSheet($session_id, $class_id, $student_id){
        $subjects = DB::select(DB::raw("
                        select 
                            subjects.id, 
                            subjects.name, 
                            subjects.is_optional, 
                            students_exams.student_id, 
                            students_exams.semester_id, 
                            (CASE  WHEN SUM(students_exams.total_obt_marks)=0 AND SUM(students_exams.is_absent)=2 THEN 1 ELSE 0 END) AS is_absent,
                            students_exams.sheet_no, 
                            ROUND(((SUM(students_exams.theory_max_marks)/100)*semesters.division_percentage), 0) AS theory_max_marks, 
                            ROUND(((SUM(students_exams.theory_obt_marks)/100)*semesters.division_percentage), 0) AS theory_obt_marks, 
                            ROUND(((SUM(students_exams.practical_max_marks)/100)*semesters.division_percentage), 0) AS practical_max_marks, 
                            ROUND(((SUM(students_exams.practical_obt_marks)/100)*semesters.division_percentage), 0) AS practical_obt_marks, 
                            ROUND(((SUM(students_exams.total_max_marks)/100)*semesters.division_percentage), 0) AS total_max_marks, 
                            ROUND(((SUM(students_exams.total_obt_marks)/100)*semesters.division_percentage), 0) AS total_obt_marks 
                        from subjects 
                        inner join students_exams 
                        on students_exams.subject_id = subjects.id 
                        inner join students 
                        on students.id = students_exams.student_id
                        inner join semesters
                        on semesters.id = students_exams.semester_id
                        where students.class_id = ".$class_id." 
                        and students.session_id = ".$session_id." 
                        and students.id = ".$student_id." 
                        GROUP BY subjects.id
                        order by subjects.id asc;
                    "));

        return $subjects;
    }

    public static function getMarkDetailsBySemester($student_id, $subject_id, $semester_id) {
        $results = StudentsExam::join('subjects', 'subjects.id', '=', 'students_exams.subject_id')->where('students_exams.student_id', $student_id)->where('students_exams.subject_id', $subject_id)->where('students_exams.semester_id', $semester_id)->first(['subjects.has_practical', 'students_exams.is_absent', 'students_exams.theory_max_marks', 'students_exams.practical_max_marks', 'students_exams.theory_obt_marks', 'students_exams.practical_obt_marks', 'students_exams.total_max_marks', 'students_exams.total_obt_marks']);
        return $results;
    }

    public static function getSessionCombinedResultDetail($session_id, $class_id) {
        $results = DB::select(DB::raw("
                        SELECT
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS total_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.result = 0 AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS pass_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.result = 1 AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS promoted_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.result = 2 AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS reappear_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.grade = 'A+' AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS a_plus_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.grade = 'A' AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS a_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.grade = 'B' AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS b_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.grade = 'C' AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS c_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.grade = 'D' AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS d_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.grade = 'E' AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS e_students,
                            (SELECT COUNT(*) FROM gazettes WHERE gazettes.grade = 'F' AND gazettes.class_id = g.class_id AND gazettes.session_id = g.session_id) AS f_students
                        FROM gazettes AS g
                        WHERE g.class_id = :class_id
                        AND g.session_id = :session_id
                        GROUP BY g.session_id LIMIT 1;
                    "), array('session_id'=>$session_id, 'class_id'=>$class_id));

        return $results;
    }

    public static function getstudentsubjectdetails($student_id, $session_id, $semester_id, $class_id, $center_id, $subject_id){
        $subject = StudentsExam::join('students', 'students.id', '=', 'students_exams.student_id')->where('students_exams.student_id', $student_id)->where('students_exams.semester_id', $semester_id)->where('students.session_id', $session_id)->where('students.class_id', $class_id)->where('students.center_id', $center_id)->where('students_exams.subject_id', $subject_id)->first();

        return $subject;
    }

    public static function getExamdetailsByStudents($student_id, $semester_id, $subject_id) {
        $subject = StudentsExam::join('students', 'students.id', '=', 'students_exams.student_id')->where('students_exams.student_id', $student_id)->where('students_exams.semester_id', $semester_id)->where('students_exams.subject_id', $subject_id)->first();

        return $subject;
    }
}
