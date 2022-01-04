<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Award Sheet {{ $session->title }} - {{ $center->name }}</title>

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

    @page { size: legal landscape; }

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

    .page_break { page-break-before: always; }
</style>

</head>
<body>

  <?php $std_counter = 1; ?>
  @foreach($standards as $standard)

    <table width="100%">
      <tr>
          <td style="padding-top:20px;" valign="top" align="center">
            <h1 style="padding:0px;margin:0px;text-align:center;font-size:18px;font-weight:600;">BOARD OF ELEMENTARY EXAMINATION, GB {{ strtoupper($session->title) }}</h1>
            <h1 style="padding:0px;margin:0px;text-align:center;font-size:15px;font-weight:600;text-decoration:underline;">ANNUAL EXAMINATION GAZETTE OF {{ strtoupper($center->name) }} FOR {{ strtoupper($session->title) }} (CLASS {{ strtoupper($standard->name) }})</h1>
          </td>
      </tr>

    </table>


    <table class="GeneratedTable">
      <thead>
        <?php $subjects = App\Models\StudentsExam::getSubjectsCombined($session->id, $center_id, $standard->id); ?>
        <tr>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">S. No</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">District</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Center Code</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Center Name</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Name</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Father Name</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Class</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Roll No</th>
          
          <?php $subs_ids = array(); $index = 0; ?>
          @foreach($subjects as $subject)
            <?php $subs_ids[$index] = $subject->id; ?>
            <th style="font-size:10px;font-weight: bold;background:#ccc;">{{ $subject->short_name }}</th>
            <?php $index++; ?>
          @endforeach
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Total</th>
          <th style="font-size:10px;font-weight: bold;background:#ccc;">Result</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; ?>
        <?php $students = App\Models\StudentsExam::getStudentsCombined($session->id, $standard->id, $center_id); ?>
        @foreach($students as $student)
          <tr>
            <td style="font-size:10px;">{{ $i }}</td>
            <td style="font-size:10px;">{{ $student->district_name }}</td>
            <td style="font-size:10px;">{{ $student->center_id }}</td>
            <td style="font-size:10px;">{{ $student->center_name }}</td>
            <td style="font-size:10px;">{{ $student->student_name }}</td>
            <td style="font-size:10px;">{{ $student->father_name }}</td>
            <td style="font-size:10px;">{{ $student->class_name }}</td>
            <td style="font-size:10px;">{{ $student->roll_no }}</td>
            <?php $t_subjects = App\Models\StudentsExam::getSubjectsAndMarksDetailsCombined($session->id, $center_id, $standard->id, $student->roll_no); ?>

            <?php  ?>

              <?php $j = 0; ?>
              <?php $found = false; ?>
              <?php $total_obtained_marks = 0; ?>
              <?php $total_maximum_marks = 0; ?>
              <?php $all_subjects_pass_arr = array(); ?>
              <?php 
                $all_subjects_pass_arr['optional_fails'] = array();
                $all_subjects_pass_arr['compulsory_fails'] = array();
                $all_subjects_pass_arr['less_than_10_optional_fails'] = array();
                $all_subjects_pass_arr['less_than_10_compulsory_fails'] = array();
              ?>
              @foreach($subs_ids as $sub_id)
                @foreach($t_subjects['id'] as $t_id)

                  @if($t_id == $sub_id)
                    @if(!($t_subjects['is_absent'][$j]))
                      @if((($t_subjects['total_obt_marks'][$j]/$t_subjects['total_max_marks'][$j])*100) >= 33)
                        <td style="font-size:10px;">{{ $t_subjects['total_obt_marks'][$j] }}</td>
                      @else
                        <td style="font-size:10px;background: #ccc;">{{ $t_subjects['total_obt_marks'][$j] }}</td>
                      @endif
                    @else
                      <td style="font-size:10px;background: #ccc;">A</td>
                    @endif
                    <?php $found = true; ?>
                    <?php $total_obtained_marks += $t_subjects['total_obt_marks'][$j]; ?>
                    <?php $total_maximum_marks += $t_subjects['total_max_marks'][$j]; ?>

                    <?php
                      if(!($t_subjects['is_absent'][$j])) {
                        if((($t_subjects['total_obt_marks'][$j]/$t_subjects['total_max_marks'][$j])*100) >= 33) {

                          $all_subjects_pass_arr['all_pass'][$j] = true;

                        } else {
                          $all_subjects_pass_arr['all_pass'][$j] = false;

                          if($t_subjects['is_optional'][$j] == true){

                            $all_subjects_pass_arr['optional_fails'][$j] = true;

                            if((($t_subjects['total_obt_marks'][$j]/$t_subjects['total_max_marks'][$j])*100) < 10) {
                                $all_subjects_pass_arr['less_than_10_optional_fails'][$j] = true;
                            }
                          } else {
                            $all_subjects_pass_arr['compulsory_fails'][$j] = true;

                            if((($t_subjects['total_obt_marks'][$j]/$t_subjects['total_max_marks'][$j])*100) < 10) {

                                $all_subjects_pass_arr['less_than_10_compulsory_fails'][$j] = true;
                            }
                          }
                        }
                      } else {
                        $all_subjects_pass_arr['all_pass'][$j] = false;

                        if($t_subjects['is_optional'][$j] == true){
                          $all_subjects_pass_arr['optional_fails'][$j] = true;
                          $all_subjects_pass_arr['less_than_10_optional_fails'][$j] = true;
                        } else {
                          $all_subjects_pass_arr['compulsory_fails'][$j] = true;
                          $all_subjects_pass_arr['less_than_10_compulsory_fails'][$j] = true;
                        }

                      }
                    ?>

                    <?php $j++; ?>
                    <?php break; ?>
                  @else
                    <?php $found = false; ?>
                  @endif

                @endforeach

                @if(!$found)
                  <td style="font-size:10px;"></td>
                @endif

              @endforeach

              <?php //dd($all_subjects_pass_arr['all_pass']); ?>
              <td style="font-size:10px;">{{ $total_obtained_marks }}</td>
              @if(!in_array(0, $all_subjects_pass_arr['all_pass']))
                <td style="font-size:10px;">PASS</td>
              @else
                @if(count($all_subjects_pass_arr['optional_fails']) == 1 && count($all_subjects_pass_arr['compulsory_fails']) == 0)

                  <td style="font-size:10px;">PROMOTED</td>

                @elseif(count($all_subjects_pass_arr['compulsory_fails']) == 1 && count($all_subjects_pass_arr['less_than_10_compulsory_fails']) == 0 && count($all_subjects_pass_arr['optional_fails']) == 0)

                  <td style="font-size:10px;">PROMOTED</td>

                @elseif(count($all_subjects_pass_arr['compulsory_fails']) == 0 && count($all_subjects_pass_arr['optional_fails']) == 2 && count($all_subjects_pass_arr['less_than_10_optional_fails']) == 0)

                  <td style="font-size:10px;">PROMOTED</td>

                @elseif(count($all_subjects_pass_arr['compulsory_fails']) == 1 && count($all_subjects_pass_arr['optional_fails']) == 1 && count($all_subjects_pass_arr['less_than_10_optional_fails']) == 0 && count($all_subjects_pass_arr['less_than_10_compulsory_fails']) == 0)

                  <td style="font-size:10px;">PROMOTED</td>

                @else

                  <td style="font-size:10px;">REAPPEAR</td>

                @endif
              @endif
          </tr>
          <?php $i++; ?>
        @endforeach
      </tbody>
    </table> 

    @if($std_counter != count($standards))
      <div class="page_break"></div>
    @endif
    <?php $std_counter++; ?>
  @endforeach
  <br/>

  <footer>
    <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
  </footer>

</body>
</html>