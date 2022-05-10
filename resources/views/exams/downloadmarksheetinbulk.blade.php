<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Mark Sheets</title>

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

    .gray {
        background-color: lightgray
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
      <div style="height:160px;" ></div>
      <table style="height: 36px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
      <tbody>
      <tr style="height: 18px;">
      <td style="width: 100%; height: 18px; border-style: none; text-align: center;"><span style="text-decoration: underline;font-weight: bold;">ELEMENTARY SCHOOL CERTIFICATE ANNUAL EXAMINATION {{ strtoupper($student->session_title) }}</span></td>
      </tr>
      </tbody>
      </table>

        <table style="width: 102.573%; height: 60px;">
        <tbody>
        <tr style="height: 37px;">
        <td style="font-size: 15px; width: 1.63682%; text-align: right; height: 10px;">&nbsp;</td>
        <td style="font-size: 15px; width: 20.2551%; text-align: right; height: 10px;">Roll Number:</td>
        <td style="font-size: 15px; width: 20.925%; text-align: left; padding-left:10px; height: 10px;">
          <span style="text-decoration: underline;"><strong>{{ $student->id }}</strong></span></td>
        <td style="font-size: 15px; width: 2.98243%; text-align: right; height: 10px;">&nbsp;</td>
        <td style="font-size: 15px; width: 23.6042%; text-align: right; height: 10px;">Class:</td>
        <td style="font-size: 15px; width: 15.8565%; text-align: left; padding-left:10px; height: 10px;">
          <span style="text-decoration: underline;"><strong>{{ strtoupper($student->class_name) }}</strong></span></td>
        <td style="height: 30px; width: 18.711%;" rowspan="3">
          @if($student->image != '')
          <?php $image = ltrim($student->image, $student->image[0]); ?>
            <img style="margin-left: 10px; border: 3px double #000;" src="{{ $image }}" alt="" width="70" />
          @endif
        </td>
        <td style="width: 3.56315%; height: 30px;" rowspan="3">&nbsp;</td>
        </tr>
        <tr style="height: 37px;">
        <td style="font-size: 15px; width: 1.63682%; text-align: right; height: 10px;">&nbsp;</td>
        <td style="font-size: 15px; width: 20.2551%; text-align: right; height: 10px;">Registration No:</td>
        <td style="font-size: 15px; width: 20.925%; text-align: left; padding-left:10px; height: 10px;">
          <span style="text-decoration: underline;"><strong>{{ $student->registration_no }}</strong></span></td>
        <td style="font-size: 15px; width: 2.98243%; text-align: right; height: 10px;">&nbsp;</td>
        <td style="font-size: 15px; width: 23.6042%; text-align: right; height: 10px;">Center ID:</td>
        <td style="font-size: 15px; width: 15.8565%; text-align: left; padding-left:10px; height: 10px;">
          <span style="text-decoration: underline;"><strong>{{ $student->center_id }}</strong></span></td>
        </tr>
        <tr style="height: 37px;">
        <td style="font-size: 15px; width: 1.63682%; text-align: right;"></td>
        <td style="font-size: 15px; width: 20.2551%; text-align: right;"></td>
        <td style="font-size: 15px; width: 20.925%; text-align: center;"><span style=""><strong></strong></span></td>
        <td style="font-size: 15px; width: 2.98243%; text-align: right; "></td>
        <td style="font-size: 15px; width: 23.6042%; text-align: right;"></td>
        <td style="font-size: 15px; width: 15.8565%; text-align: left; padding-left:10px;">
          <span style=""><strong></strong></span></td>
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

        <table style="width: 100%; border-collapse: collapse; border: 2px double #000; margin-top: 10px;">
        <thead style="border: 1px double #000;">
        <tr>
        <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 5.17404%;">S.No</th>
        <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 53.8099%;">Subjects</th>
        <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 15.5222%;">Maximum Marks</th>
        <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 14.7695%;">Marks Obtained</th>
        <th style="font-size: 13px; border: 1px double #000000; padding: 10px; width: 10.6303%;">Remarks</th>
        </tr>
        </thead>
        <tbody>
        <?php $sno=1;$j=0;$found = true;$total_obt_marks = 0; $total_max_marks = 0; $o_result = 0; $o_grade = ''; $percentage_marks = 0; ?>
        
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
          <td style="font-size: 13px; border: 1px solid #000000; text-align: center; width: 5.17404%;">{{ $sno }}</td>
          <td style="font-size: 13px; border: 1px solid #000000; width: 53.8099%;">{{ $subject->name }}</td>
          <td style="font-size: 13px; border: 1px solid #000000; text-align: center; width: 15.5222%;">{{ $subject->total_max_marks }}</td>
          <td style="font-size: 13px; border: 1px solid #000000; text-align: center; width: 14.7695%;">{{ $subject->total_obt_marks }}</td>
          <td style="font-size: 13px; border: 1px solid #000000; text-align: center; width: 10.6303%;">
          @if((($subject->total_obt_marks/$subject->total_max_marks)*100) >= 33)  
            PASS
          @else
            FAIL
          @endif
          </td>
          </tr>
          <?php $sno++; ?>
        @endforeach

        </tbody>
        </table>
        <table style="width: 100%; margin-top: 10px;" border="0">
        <tbody>
        <tr>
        <td style="font-size: 13px; width: 30.8091%; text-align: right;">Total Marks (In Figures):</td>
        <td style="padding-left: 10px; font-size: 13px; width: 69.1909%;">
          <span style="display: inline-block; width: 100%; border-bottom: 1px solid #000; text-align: left; font-weight: bold;">
           {{ $total_obt_marks }}/{{ $total_max_marks }}</span></td>
        </tr>
        <tr>
        <td style="font-size: 13px; width: 30.8091%; text-align: right;">(In Words):</td>
        <td style="padding-left: 10px; font-size: 13px; width: 69.1909%;">
          <span style="display: inline-block; width: 100%; border-bottom: 1px solid #000; text-align: left; font-weight: bold;">
            <?php $see = new  App\Models\StudentsExam; ?>
           {{ strtoupper($see->convert_number($total_obt_marks)) }}
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