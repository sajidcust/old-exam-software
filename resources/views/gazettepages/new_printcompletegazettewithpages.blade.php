<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gazette {{ $session->title }} - {{ $standard->name }} - {{ $district->name }}</title>

<style type="text/css">
    body{
        margin-left: 2cm;
        margin-right: 2cm;
    }
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
  @include('gazettepages.new_coverpage_district', array('session' => $session, 'standard'=>$standard, 'district'=>$district, 'setting'=>$setting))

  <script type="text/php">
      if ( isset($pdf) ) {
          $pdf->page_script('
            if ($PAGE_COUNT) {
                $page_no = (int)"<?php echo $page_no; ?>";
                $plused_page = $page_no+(int)$PAGE_NUM;
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 12;
                //$pageText = "Page " . $plused_page . " of " . $PAGE_COUNT;
                $pageText = "Page " . $plused_page;
                $y = 580;
                $x = $pdf->get_width()-140;
                $pdf->text($x, $y, $pageText, $font, $size);
            } 
        ');
      }
  </script>

  @if($district)
  <?php App\Models\TableOfContent::where("session_id", $session->id)->where("class_id", $standard->id)->where("district_id", $district->id)->delete(); ?>
      <table width="100%">
        <thead>
          <tr>
              <td style="padding-top:20px;" valign="top" align="center">
                <h1 style="padding:0px;margin:0px;text-align:center;font-size:18px;font-weight:600;">{{ strtoupper($setting->board_full_name) }} CONSOLIDATED ANNUAL EXAMINATION RESULT {{ strtoupper($session->title) }}</h1>
              </td>
          </tr>
        </thead>
      </table>

      <?php $centers = App\Models\StudentsExam::getCenters($session->id, $standard->id, $district->id); ?>
      @if(count($centers)>0)

      <?php

        $g_total_students = 0;
        $g_pass_students = 0;
        $g_promoted_students = 0;
        $g_reappear_students = 0;
        $g_total_a_plus = 0;
        $g_total_a = 0;
        $g_total_b = 0;
        $g_total_c = 0;
        $g_total_d = 0;
        $g_total_e = 0;
        $g_total_f = 0;

      ?>

        @foreach($centers as $center)

        <script type="text/php">

          $session_id = (int)"<?php echo $session->id; ?>";
          $standard_id = (int)"<?php echo $standard->id; ?>";
          $district_id = (int)"<?php echo $district->id; ?>";
          $center_id = (int)"<?php echo $center->id; ?>";

          App\Models\TableOfContent::where("session_id", $session_id)->where("class_id", $standard_id)->where("district_id", $district_id)->where("center_id", $center_id)->delete();

          $table_of_content = new App\Models\TableOfContent;
          $table_of_content->session_id = $session_id;
          $table_of_content->class_id = $standard_id;
          $table_of_content->district_id = $district_id;
          $table_of_content->center_id = $center_id;
          $table_of_content->page_no = $pdf->get_page_number()+(int)"<?php echo $page_no; ?>";
          $table_of_content->save();

        </script>
        

        <?php
          $total_students = 0;
          $pass_students = 0;
          $promoted_students = 0;
          $reappear_students = 0;
          $total_a_plus = 0;
          $total_a = 0;
          $total_b = 0;
          $total_c = 0;
          $total_d = 0;
          $total_e = 0;
          $total_f = 0;

        ?>

        <?php $gazettes = App\Models\StudentsExam::getGazettes($session->id, $district->id, $center->id, $standard->id); ?>

          @if(count($gazettes)>0)
            <table width="100%">
              <thead>
                <tr>
                  <td style="text-align: right;">District:</td>
                  <td style="text-align: left; font-weight: bold; text-decoration: underline;">{{ $center->district_name }}</td>
                  <td style="text-align: right;">Code:</td>
                  <td style="text-align: left; font-weight: bold; text-decoration: underline;">{{ $center->id }}</td>
                  <td style="text-align: right;">Name:</td>
                  <td style="text-align: left; font-weight: bold; text-decoration: underline;">{{ $center->name }}</td>
                  <td style="text-align: right;">Class:</td>
                  <td style="text-align: left; font-weight: bold; text-decoration: underline;">{{ $standard->name }}</td>
                </tr>
              </thead>
            </table>

            <table class="GeneratedTable" width="100%">
              <thead>
                <?php $subjects = App\Models\StudentsExam::getSubjectsCombined($session->id, $center->id, $standard->id); ?>
                <tr>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">S. No</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Roll No</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Name of School</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Name of Student</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Father's Name</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Date of Birth</th>
                  <?php $subs_ids = array(); $index = 0; ?>
                  @foreach($subjects as $subject)
                    <?php $subs_ids[$index] = $subject->id; ?>
                    <th style="font-size:10px;font-weight: bold;background:#ccc;">{{ $subject->short_name }}</th>
                    <?php $index++; ?>
                  @endforeach
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Obt</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Grade</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">%age</th>
                  <th style="font-size:10px;font-weight: bold;background:#ccc;">Result</th>
              </thead>
              <tbody>
                <?php $i = 1; ?>

                @foreach($gazettes as $gazette)
                  <tr>
                    <td style="font-size:10px;">{{ $i }}</td>
                    <td style="font-size:10px;">{{ $gazette->id }}</td>
                    <td style="font-size:10px;">{{ $gazette->institution_name }}</td>
                    <td style="font-size:10px;">{{ $gazette->name }}</td>
                    <td style="font-size:10px;">{{ $gazette->father_name }}</td>
                    <td style="font-size:10px;">{{ $gazette->date_of_birth }}</td>
                    <?php $t_subjects = App\Models\StudentsExam::getSubjectsAndMarksDetailsCombined($session->id, $center->id, $standard->id, $gazette->id); ?>
                    <?php 
                      $j=0;
                      $total_obtained_marks = 0;
                      $total_maximum_marks = 0;
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
                    <td style="font-size:10px;">{{ $total_obtained_marks }}</td>
                    <td style="font-size:10px;text-align: center;">{{ $gazette->grade }}</td>
                    <?php
                      if($gazette->grade == 'A+') {
                        $total_a_plus++;
                      } else if($gazette->grade == 'A') {
                        $total_a++;
                      } else if($gazette->grade == 'B') {
                        $total_b++;
                      } else if($gazette->grade == 'C') {
                        $total_c++;
                      } else if($gazette->grade == 'D') {
                        $total_d++;
                      } else if($gazette->grade == 'E') {
                        $total_e++;
                      } else {
                        $total_f++;
                      }

                    ?>
                    <td style="font-size:10px;text-align: center;">{{ $gazette->percentage_marks }}</td>
                    @if($gazette->result == 0)
                      <?php $pass_students++; ?>
                      <td style="font-size:10px;">PASS</td>
                    @elseif($gazette->result == 1)
                      <?php $promoted_students++; ?>
                      <td style="font-size:10px;">PROMOTED</td>
                    @else
                      <?php $reappear_students++; ?>
                      <td style="font-size:10px;">REAPPEAR</td>
                    @endif
                  </tr>
                <!-- HERE !-->
                  <?php $i++; $total_students++; ?>
                @endforeach
              </tbody>
            </table>
          

          <h4 style="font-size:12px;text-align: left; margin-bottom: 5px;">{{ $center->name }}, Combined Result Summary</h4>
          <table style="border-collapse: collapse; width: 100%;margin-bottom:5px;" border="1">
          <tbody>
          <tr>
          <td style="width: 12.5%; text-align: left;font-size:10px;">TOTAL:</td>
          <td style="width: 12.5%; text-align: left;font-size:10px;">{{ $total_students }}</td>
          <td style="width: 12.5%; text-align: left;font-size:10px;">PASS:</td>
          <td style="width: 12.5%; text-align: left;font-size:10px;">{{ $pass_students; }}</td>
          <td style="width: 12.5%; text-align: left;font-size:10px;">PROMOTED:</td>
          <td style="width: 12.5%; text-align: left;font-size:10px;">{{ $promoted_students; }}</td>
          <td style="width: 12.5%; text-align: left;font-size:10px;">REAPPEAR</td>
          <td style="width: 12.5%; text-align: left;font-size:10px;">{{ $reappear_students; }}</td>
          </tr>
          <tr>
          <td style="font-size:10px;width: 25%; text-align: left;" colspan="2">PERCENTAGE:</td>
          <td style="font-size:10px;width: 12.5%; text-align: left;">PASS %:</td>
          <td style="font-size:10px;width: 12.5%; text-align: left;">
          @if($pass_students != 0)
             {{ round((($pass_students/$total_students)*100), 2) }}
          @else
            0.00
          @endif
          </td>
          <td style="font-size:10px;width: 12.5%; text-align: left;">PROMOTED %:</td>
          <td style="font-size:10px;width: 12.5%; text-align: left;">
          @if($promoted_students != 0)
            {{ round((($promoted_students/$total_students)*100), 2) }}
          @else
            0.00
          @endif
          </td>
          <td style="font-size:10px;width: 12.5%; text-align: left;">REAPPEAR %</td>
          <td style="font-size:10px;width: 12.5%; text-align: left;">
          @if($reappear_students != 0)
            {{ round((($reappear_students/$total_students)*100), 2) }}
          @else
            0.00
          @endif
          </td>
          </tr>
          </tbody>
          </table>
          <table style="width: 100%; margin-bottom: 10px; border-collapse: collapse; border-style: none;" border="1">
          <tbody>
          <tr>
          <td style="font-size:10px;width: 7.14%; text-align: center;">A+:</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">{{ $total_a_plus }}</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">A:</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">{{ $total_a }}</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">B:</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">{{ $total_b }}</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">C:</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">{{ $total_c }}</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">D:</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">{{ $total_d }}</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">E:</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">{{ $total_e }}</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">F:</td>
          <td style="font-size:10px;width: 7.14%; text-align: center;">{{ $total_f }}</td>
          </tr>
          </tbody>
          </table>
          @endif

          <?php

            $g_total_students += $total_students;
            $g_pass_students += $pass_students;
            $g_promoted_students += $promoted_students;
            $g_reappear_students += $reappear_students;
            $g_total_a_plus += $total_a_plus;
            $g_total_a += $total_a;
            $g_total_b += $total_b;
            $g_total_c += $total_c;
            $g_total_d += $total_d;
            $g_total_e += $total_e;
            $g_total_f += $total_f;

          ?>

        <div class="page_break"></div>
        @endforeach
      @endif

      <h4 style="font-size:15px;text-align: center; margin-bottom: 5px;">District {{ $district->name }}, Combined Result Summary</h4>
      <table style="border-collapse: collapse; width: 100%;margin-bottom:5px;" border="1">
      <tbody>
      <tr>
      <td style="width: 12.5%; text-align: left;font-size:10px;">TOTAL:</td>
      <td style="width: 12.5%; text-align: left;font-size:10px;"><strong><strong>{{ $g_total_students }}</strong></td>
      <td style="width: 12.5%; text-align: left;font-size:10px;">PASS:</td>
      <td style="width: 12.5%; text-align: left;font-size:10px;"><strong>{{ $g_pass_students }}</td>
      <td style="width: 12.5%; text-align: left;font-size:10px;">PROMOTED:</td>
      <td style="width: 12.5%; text-align: left;font-size:10px;"><strong><strong>{{ $g_promoted_students }}</strong></td>
      <td style="width: 12.5%; text-align: left;font-size:10px;">REAPPEAR</td>
      <td style="width: 12.5%; text-align: left;font-size:10px;"><strong><strong>{{ $g_reappear_students }}</strong></td>
      </tr>
      <tr>
      <td style="font-size:10px;width: 25%; text-align: left;" colspan="2">PERCENTAGE:</td>
      <td style="font-size:10px;width: 12.5%; text-align: left;">PASS %:</td>
      <td style="font-size:10px;width: 12.5%; text-align: left;"><strong>
      @if($g_pass_students != 0)
         {{ round((($g_pass_students/$g_total_students)*100), 2) }}
      @else
        0.00
      @endif
      </strong>
      </td>
      <td style="font-size:10px;width: 12.5%; text-align: left;">PROMOTED %:</td>
      <td style="font-size:10px;width: 12.5%; text-align: left;"><strong>
      @if($g_promoted_students != 0)
        {{ round((($g_promoted_students/$g_total_students)*100), 2) }}
      @else
        0.00
      @endif
      </strong>
      </td>
      <td style="font-size:10px;width: 12.5%; text-align: left;">REAPPEAR %</td>
      <td style="font-size:10px;width: 12.5%; text-align: left;"><strong>
      @if($g_reappear_students != 0)
        {{ round((($g_reappear_students/$g_total_students)*100), 2) }}
      @else
        0.00
      @endif
      </strong>
      </td>
      </tr>
      </tbody>
      </table>
      <table style="width: 100%; margin-bottom: 10px; border-collapse: collapse; border-style: none;" border="1">
      <tbody>
      <tr>
      <td style="font-size:10px;width: 7.14%; text-align: center;">A+:</td>
      <td style="font-size:10px;width: 7.14%; text-align: center;"><strong>{{ $g_total_a_plus }}</strong></td>
      <td style="font-size:10px;width: 7.14%; text-align: center;">A:</td>
      <td style="font-size:10px;width: 7.14%; text-align: center;"><strong>{{ $g_total_a }}</strong></td>
      <td style="font-size:10px;width: 7.14%; text-align: center;">B:</td>
      <td style="font-size:10px;width: 7.14%; text-align: center;"><strong>{{ $g_total_b }}</strong></td>
      <td style="font-size:10px;width: 7.14%; text-align: center;">C:</td>
      <td style="font-size:10px;width: 7.14%; text-align: center;"><strong>{{ $g_total_c }}</strong></td>
      <td style="font-size:10px;width: 7.14%; text-align: center;">D:</td>
      <td style="font-size:10px;width: 7.14%; text-align: center;"><strong>{{ $g_total_d }}</strong></td>
      <td style="font-size:10px;width: 7.14%; text-align: center;">E:</td>
      <td style="font-size:10px;width: 7.14%; text-align: center;"><strong>{{ $g_total_e }}</strong></td>
      <td style="font-size:10px;width: 7.14%; text-align: center;">F:</td>
      <td style="font-size:10px;width: 7.14%; text-align: center;"><strong>{{ $g_total_f }}</strong></td>
      </tr>
      </tbody>
      </table>
    
  @endif

<footer>
  <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
</footer>
</body>
</html>