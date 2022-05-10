<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Detailed Mark Sheets</title>

<style type="text/css">

    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: 15px;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: 15px;
    }
    h1{
      font-family: Verdana;
    }

    footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 0cm;
    }

    @page { size: a4 portrait; }

    table.GeneratedTable {
      width: 100%;
      background-color: #ffffff;
      border-collapse: collapse;
      border-width: 1px;
      border-color: #000000;
      border-style: solid;
      color: #000000;
    }

    table.GeneratedTable td, table.GeneratedTable th {
      border-width: 1px;
      border-color: #000000;
      border-style: solid;
      padding: 3px;
    }

    table.GeneratedTable thead {
      background-color: #ffffff;
    }

    path {
      fill: transparent;
    }

    text {
      fill: #FF9800;
      text-align: center;
    }

    .page_break { page-break-before: always; }
</style>

</head>
<body>
<?php $counter = 1; ?>
@foreach($students as $student)
  @if($student)

    <?php $subjects = App\Models\StudentsExam::getSubjectsForMarkSheet($student->session_id, $student->class_id, $student->id); ?>

    @if(!$subjects)
      <?php continue; ?>
    @endif

    @if($counter != 1)
      <div class="page_break"></div>
    @endif
    
    <?php

      $semesters = App\Models\Semester::join('students_exams', 'students_exams.semester_id', '=', 'semesters.id')->groupBy('semesters.id')->where('students_exams.student_id', $student->id)->where('session_id', $student->session_id)->get(['semesters.id', 'semesters.title']);

    ?>
    <div style="height:50px;"></div>
    <table style="width: 100%; border-style: none;" border="0">
    <tbody>
    <tr>
    <td style="width:10%;" valign="top"><h4><strong></strong></h4></td>
    <td style="width:70%;padding-left:70px; border-style: none; text-align: center;"><span style="text-align:left;"></span></td>
    <td style="width:20%;text-align: left;">
      @if($student->image != '')
        <?php $image = ltrim($student->image, $student->image[0]); ?>
        <img style="margin-left: 10px; border: 3px double #000;" src="{{ $image }}" alt="" width="80" />
      @endif
    </td>
    </tr>
    </tbody>
    </table>
    <table style="height: 36px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
    <tbody>
    <tr style="height: 18px;">
    <td style="width: 100%; height: 18px; border-style: none; text-align: center;"><strong><span style="text-decoration: underline;"></span></strong></td>
    </tr>
    <tr style="height: 18px;">
    <td style="width: 100%; height: 18px; border-style: none; text-align: center;"><span style="font-weight: bold; font-size:17px;text-decoration: underline;">ELEMENTARY SCHOOL MARKS SHEET ANNUAL EXAMINATION {{ strtoupper($student->session_title) }}</span></td>
    </tr>
    </tbody>
    </table>
      <table style="width: 102.573%; height: 60px;">
      <tbody>
      <tr style="height: 37px;">
      <td style="font-size: 15px; width: 1%; text-align: right; height: 10px;">&nbsp;</td>
      <td style="font-size: 15px; width: 20.2551%; text-align: right; height: 10px;">Roll Number:</td>
      <td style="font-size: 15px; width: 20.925%; text-align: left; padding-left:10px; height: 10px;">
        <span style="display: inline-block; border-bottom: 1px solid #000; width: 100%;"><strong>{{ $student->id }}</strong></span></td>
      <td style="font-size: 15px; width: 2.98243%; text-align: right; height: 10px;">&nbsp;</td>
      <td style="font-size: 15px; width: 23.6042%; text-align: right; height: 10px;">Class:</td>
      <td style="font-size: 15px; width: 15.8565%; text-align: left; padding-left:10px; height: 10px;">
        <span style="display: inline-block; border-bottom: 1px solid #000; width: 100%;"><strong>{{ strtoupper($student->class_name) }}</strong></span></td>
      <td style="height: 30px; width: 1%;" rowspan="3"></td>
      <td style="width: 3.56315%; height: 30px;" rowspan="3">&nbsp;</td>
      </tr>
      <tr style="height: 37px;">
      <td style="font-size: 15px; width: 1.63682%; text-align: right; height: 10px;">&nbsp;</td>
      <td style="font-size: 15px; width: 20.2551%; text-align: right; height: 10px;">Registration No:</td>
      <td style="font-size: 15px; width: 20.925%; text-align: left; padding-left:10px; height: 10px;">
        <span style="display: inline-block; border-bottom: 1px solid #000; width: 100%;"><strong>{{ $student->registration_no }}</strong></span></td>
      <td style="font-size: 15px; width: 2.98243%; text-align: right; height: 10px;">&nbsp;</td>
      <td style="font-size: 15px; width: 23.6042%; text-align: right; height: 10px;">Center ID:</td>
      <td style="font-size: 15px; width: 15.8565%; text-align: left; padding-left:10px; height: 10px;">
        <span style="display: inline-block; border-bottom: 1px solid #000; width: 100%;"><strong>{{ $student->center_id }}</strong></span></td>
      </tr>
      <tr style="height: 37px;">
      <td style="font-size: 15px; width: 1.63682%; text-align: right;"></td>
      <td style="font-size: 15px; width: 20.2551%; text-align: right;"></td>
      <td style="font-size: 15px; width: 20.925%; text-align: center;"></td>
      <td style="font-size: 15px; width: 2.98243%; text-align: right;"></td>
      <td style="font-size: 15px; width: 23.6042%; text-align: right;"></td>
      <td style="font-size: 15px; width: 15.8565%; text-align: left;"></td>
      </tr>
      <tr style="height: 10px;">
      <td style="font-size: 13px; width: 1.63682%; text-align: right; height: 10px;">&nbsp;</td>
      <td style="font-size: 13px; width: 102.334%; text-align: left; height: 10px;" colspan="6">
        <span style="display: inline-block; width: 42%; border-bottom: 1px solid #000; font-weight: bold;">{{ strtoupper($student->name) }}</span> 
        <span style="width: 15%; display: inline-block; text-align: center;"> {{ $student->gender == 0 ? " Son of " : " Daughter of " }} </span> 
        <span style="display: inline-block; width: 43%; border-bottom: 1px solid #000; font-weight: bold;">{{ strtoupper($student->father_name) }}</span></td>
      <td style="width: 3.56315%; height: 10px;">&nbsp;</td>
      </tr>
      <tr style="height: 10px;">
      <td style="font-size: 13px; width: 1.63682%; text-align: right; height: 10px;">&nbsp;</td>
      <td style="font-size: 13px; width: 102.334%; text-align: left; height: 10px;" colspan="6">
        of Institution <span style="display: inline-block; width: 88%; border-bottom: 1px solid #000; text-align: center; font-weight: bold;">
         {{ strtoupper($student->institution_name) }}</span></td>
      <td style="width: 3.56315%; height: 10px;">&nbsp;</td>
      </tr>
      <?php $month_of_exams = App\Models\StudentsExam::getMonthOfExams($student->session_id, $student->class_id, $student->id, $student->year); ?>
      <tr style="height: 10px;">
      <td style="font-size: 13px; width: 1.63682%; text-align: right; height: 10px;">&nbsp;</td>
      <td style="font-size: 13px; width: 102.334%; text-align: left; height: 10px;" colspan="6">Status 
        <span style="display: inline-block; width: 10%; border-bottom: 1px solid #000; font-weight: bold;">{{ $student->status == 0 ? "REGULAR":"PRIVATE" }}</span> 
        has secured the marks shown against each subject in the Elementary School Certificate Annual Examination held in the month of 
        <span style="display: inline-block; width: 100px; border-bottom: 1px solid #000; font-weight: bold; text-align: center;">{{ strtoupper($month_of_exams) }}</span></td>
      <td style="width: 3.56315%; height: 10px;">&nbsp;</td>
      </tr>
      </tbody>
      </table>
      <?php //$semesters=App\Models\Semester::where('session_id', $student->session_id)->get(); ?>
      <?php $s_count = count($semesters); ?>
      <table style="width: 100%; border-collapse: collapse; border: 2px double #000; margin-top: 10px;">
      <thead style="border: 1px double #000;">
      <tr>
      <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 2.42515%; text-align: center;" rowspan="3">#</th>
      <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: width: 93.0337%; text-align: center;" rowspan="3">Subjects</th>
      <th style="font-size: 13px; border: 1px double #000000; padding: 10px; text-align: center; width: 8.46963%;" colspan="{{ $s_count * 3 }}">Maximum Marks</th>
      <th style="font-size: 13px; border: 1px double #000000; padding: 10px; text-align: center; width: 15.0986%;" colspan="{{ $s_count * 3 }}">Marks Obtained</th>
      <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 5.38702%; text-align: center;" rowspan="3">Total Obt</th>
      <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 0.928505%; text-align: center;" rowspan="3">Remarks</th>
      </tr>
      <tr>

        @for($i=0; $i<$s_count; $i++)
          @foreach($semesters as $semester)
            <th style="font-size: 13px; border: 1px double #000000; padding: 10px; text-align: center; width: 4.23481%;" colspan="{{ $s_count == 1 ? 6 : 3 }}">{{ $semester->title }}</th>
          @endforeach
        @endfor
      </tr>

      @if($s_count == 1)
        <?php $s_count = 2; ?>
      @endif

      <tr>
        @for($i=0; $i<$s_count; $i++)
          @foreach($semesters as $semester)
            <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 0.742942%; text-align: center;">Th</th>
            <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 0.742942%; text-align: center;">Pr</th>
            <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 2.74893%; text-align: center;">Tot</th>
          @endforeach
        @endfor
      </tr>
      </thead>
      <tbody>
      <?php $sno=1;$j=0;$found = true;$total_obt_marks = 0; $total_max_marks = 0; $o_result = 0; $o_grade = ''; $percentage_marks = 0; $combined_total_max_marks = 0; $combined_total_obt_marks = 0; ?>
      <?php $subjects = App\Models\StudentsExam::getSubjectsForMarkSheet($student->session_id, $student->class_id, $student->id); ?>
      <?php 

        $all_subjects_pass_arr = array();
        $all_subjects_pass_arr['optional_fails'] = array();
        $all_subjects_pass_arr['compulsory_fails'] = array();
        $all_subjects_pass_arr['less_than_10_optional_fails'] = array();
        $all_subjects_pass_arr['less_than_10_compulsory_fails'] = array();

      ?>
      @foreach($subjects as $subject)

      <?php

        $total_obt_marks += $subject->total_obt_marks;
        $total_max_marks += $subject->total_max_marks;
        if(!($subject->is_absent)) {
            if((($subject->total_obt_marks/$subject->total_max_marks)*100) >= 33) {

              $all_subjects_pass_arr['all_pass'][$j] = true;

            } else {
              $all_subjects_pass_arr['all_pass'][$j] = false;

              if($subject->is_optional == true){

                $all_subjects_pass_arr['optional_fails'][$j] = true;

                if((($subject->total_obt_marks/$subject->total_max_marks)*100) < 10) {
                    $all_subjects_pass_arr['less_than_10_optional_fails'][$j] = true;
                }
              } else {
                $all_subjects_pass_arr['compulsory_fails'][$j] = true;

                if((($subject->total_obt_marks/$subject->total_max_marks)*100) < 10) {

                    $all_subjects_pass_arr['less_than_10_compulsory_fails'][$j] = true;
                }
              }
            }
          } else {
            $all_subjects_pass_arr['all_pass'][$j] = false;

            if($subject->is_optional == true){
              $all_subjects_pass_arr['optional_fails'][$j] = true;
              $all_subjects_pass_arr['less_than_10_optional_fails'][$j] = true;
            } else {
              $all_subjects_pass_arr['compulsory_fails'][$j] = true;
              $all_subjects_pass_arr['less_than_10_compulsory_fails'][$j] = true;
            }
        }

        $j++;

    if(!in_array(0, $all_subjects_pass_arr['all_pass'])) {
        $o_result = 0;
    } else {
        if(count($all_subjects_pass_arr['optional_fails']) == 1 && count($all_subjects_pass_arr['compulsory_fails']) == 0) {
            $o_result = 1;
        }
        else if(count($all_subjects_pass_arr['compulsory_fails']) == 1 && count($all_subjects_pass_arr['less_than_10_compulsory_fails']) == 0 && count($all_subjects_pass_arr['optional_fails']) == 0) {
            $o_result = 1;
        }
        else if(count($all_subjects_pass_arr['compulsory_fails']) == 0 && count($all_subjects_pass_arr['optional_fails']) == 2 && count($all_subjects_pass_arr['less_than_10_optional_fails']) == 0){
            $o_result = 1;
        }
        else if(count($all_subjects_pass_arr['compulsory_fails']) == 1 && count($all_subjects_pass_arr['optional_fails']) == 1 && count($all_subjects_pass_arr['less_than_10_optional_fails']) == 0 && count($all_subjects_pass_arr['less_than_10_compulsory_fails']) == 0) {
            $o_result = 1;
        }
        else {
            $o_result = 2;
        }
    }

    $percentage_marks = round((($total_obt_marks/$total_max_marks)*100), 2);
    if($percentage_marks >= 80) {
        $o_grade = 'A+';
    } else if($percentage_marks >=70 && $percentage_marks <= 79.99) {
        $o_grade = 'A';
    } else if($percentage_marks >= 60 && $percentage_marks <= 69.99){
        $o_grade = 'B';
    } else if($percentage_marks >= 50 && $percentage_marks <= 59.99){
        $o_grade = 'C';
    } else if($percentage_marks >=40 && $percentage_marks <= 49.99) {
        $o_grade = 'D';
    } else if($percentage_marks>=33 && $percentage_marks <= 39.99) {
        $o_grade = 'E';
    } else {
        $o_grade = 'F';
    }

      ?>

        <tr>
          <td style="font-size: 13px; border: 1px solid #000000; text-align: center;">{{ $sno }}</td>
          <td style="font-size: 13px; border: 1px solid #000000;">{{ $subject->name }}</td>
          <?php $combined_subject_total_obt_marks = 0; ?>
          <?php $combined_subject_total_max_marks = 0; ?>
          @foreach($semesters as $semester)


            <?php $marks_details = App\Models\StudentsExam::getMarkDetailsBySemester($student->id, $subject->id, $semester->id); ?>

            @if($marks_details)
              <?php $combined_subject_total_obt_marks+=$marks_details->total_obt_marks; ?>
              <?php $combined_subject_total_max_marks+=$marks_details->total_max_marks; ?>

              @if(!$marks_details->is_absent)
                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->theory_max_marks }}</td>
                  @if($marks_details->has_practical)
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->practical_max_marks }}</td>
                  @else
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>
                  @endif

                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->total_max_marks }}</td> 

                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->theory_obt_marks }}</td>
                  @if($marks_details->has_practical)
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->practical_obt_marks }}</td>
                  @else
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>
                  @endif

                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->total_obt_marks }}</td>            

              @else
                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->theory_max_marks }}</td>
                  @if($marks_details->has_practical)
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->practical_max_marks }}</td>
                  @else
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>
                  @endif

                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->total_max_marks }}</td> 

                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">A</td>
                  @if($marks_details->has_practical)
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">A</td>
                  @else
                    <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>
                  @endif

                  <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">{{ $marks_details->total_obt_marks }}</td> 

              @endif
          @else
            <?php $combined_subject_total_obt_marks+=0; ?>
            <?php $combined_subject_total_max_marks+=0; ?>

            <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>
            <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>

            <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td> 

            <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>
            <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>

            <td style="font-size: 13px; border: 1px solid #000000; text-align:center;">&nbsp;</td>
          @endif

          @endforeach
        <td style="font-size: 13px; border: 1px solid #000000; text-align: center;">{{ $combined_subject_total_obt_marks }}</td>
        <td style="font-size: 13px; border: 1px solid #000000; text-align: center;">
        @if((($subject->total_obt_marks/$subject->total_max_marks)*100) >= 33)  
          PASS
        @else
          FAIL
        @endif
        </td>
        </tr>
        <?php $sno++; ?>

        <?php $combined_total_max_marks += $combined_subject_total_max_marks; ?>
        <?php $combined_total_obt_marks += $combined_subject_total_obt_marks; ?>
      @endforeach

      </tbody>
      </table>
      <table style="width: 100%; margin-top: 10px;" border="0">
      <tbody>
      <tr>
      <td style="font-size: 13px; width: 30.8091%; text-align: right;">Total Marks (In Figures):</td>
      <td style="padding-left: 10px; font-size: 13px; width: 69.1909%;">
        <span style="display: inline-block; width: 100%; border-bottom: 1px solid #000; text-align: left; font-weight: bold;">
         {{ $combined_total_obt_marks }}/{{ $combined_total_max_marks }}</span></td>
      </tr>
      <tr>
      <td style="font-size: 13px; width: 30.8091%; text-align: right;">(In Words):</td>
      <td style="padding-left: 10px; font-size: 13px; width: 69.1909%;">
        <span style="display: inline-block; width: 100%; border-bottom: 1px solid #000; text-align: left; font-weight: bold;">
         
         <?php $see = new  App\Models\StudentsExam; ?>
           {{ strtoupper($see->convert_number($combined_total_obt_marks)) }}
       </span></td>
      </tr>
      <tr>
      <td style="font-size: 13px; width: 30.8091%; text-align: right;">General Remarks:</td>
      <td style="padding-left: 10px; font-size: 13px; width: 69.1909%;">
        <span style="display: inline-block; width: 100%; border-bottom: 1px solid #000; text-align: left; font-weight: bold;">
         @if($o_result == 0)
            THE CANDIDATE HAS PASSED AND PLACED IN GRADE {{ $o_grade }}
         @elseif($o_result == 1)
            THE CANDIDATE HAS PROMOTED AND PLACED IN GRADE {{ $o_grade }}
         @else
            THE CANDIDATE HAS BEEN REAPPEARED
         @endif
       </span></td>
      </tr>
      <tr>
      <td style="font-size: 13px; width: 30.8091%; text-align: right;">Date Of Birth (In Figures):</td>
      <td style="padding-left: 10px; font-size: 13px; width: 69.1909%;">
        <span style="display: inline-block; width: 100%; border-bottom: 1px solid #000; text-align: left; font-weight: bold;">
         {{ $student->date_of_birth }}</span></td>
      </tr>
      <tr>
      <td style="font-size: 13px; width: 30.8091%; text-align: right;">(In Words):</td>
      <td style="padding-left: 10px; font-size: 13px; width: 69.1909%;">
        <span style="display: inline-block; width: 100%; border-bottom: 1px solid #000; text-align: left; font-weight: bold;">
         {{ strtoupper($student->dob_in_words) }}</span></td>
      </tr>
      </tbody>
      </table>
      <p>&nbsp;</p>
      <table style="width: 100%; border-collapse: collapse; border-style: none;" border="0">
      <tbody>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align:center;">
          @if($student->class_id == 1001)
            @if($setting->deputy_controller_signature != '')
              <?php $dcsi = ltrim($setting->deputy_controller_signature, $setting->deputy_controller_signature[0]); ?>
              <img style="margin-top:-10px;margin-left: 30px;position: absolute;" src="{{ $dcsi }}" alt="" width="60"/>
            @else
              <img style="margin-top:-10px;margin-left: 30px;position: absolute;" src="img/controller_signature.jpg" alt="" width="60"/>
            @endif
          @else
            @if($setting->controller_signature != '')
              <?php $dcsi = ltrim($setting->controller_signature, $setting->controller_signature[0]); ?>
              <img style="margin-top:0px;margin-left: 30px;position: absolute;" src="{{ $dcsi }}" alt="" width="60"/>
            @else
              <img style="margin-top:0px;margin-left: 30px;position: absolute;" src="img/controller_signature.jpg" alt="" width="60"/>
            @endif
          @endif
        </td>
      </tr>
      <tr>
      <td style="font-size: 11px; width: 5.43276%; border-style: none;">&nbsp;</td>
      <td style="font-size: 11px; width: 75.4234%; border-style: none;">Prepared by:_________________________</td>
      <td style="font-size: 11px; width: 19.1438%; border-style: none;">&nbsp;</td>
      </tr>
      <tr>
      <td style="font-size: 11px; width: 5.43276%; border-style: none;">&nbsp;</td>
      <td style="font-size: 11px; width: 75.4234%; border-style: none;">Result Declaration Date:&nbsp; <strong>{{ date('d F, Y', strtotime($session->result_declaration_date)) }}</strong></td>
      <td style="font-size: 11px; width: 19.1438%; font-weight: bold; border-style: none; text-align: center;">{{ $student->class_id == 1001 ? 'Deputy ': '' }}Controller Of Examinations</td>
      </tr>
      </tbody>
      </table>
    <?php $counter++; ?>
  @endif
@endforeach
  <footer>
    <p style="color:#000;font-size:11px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
  </footer>
</body>
</html>