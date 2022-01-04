<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gazette Overall Top Ten Position Holders Page {{ $session->title }} - {{ $standard->name }}</title>

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
        bottom: 15px; 
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
                $x = $pdf->get_width()-90;
                $pdf->text($x, $y, $pageText, $font, $size);
            } 
        ');
      }
  </script>

<table width="100%">
  <tr>
      <td style="padding-top:20px;" valign="top" align="center">
        <h1 style="padding:0px;margin:0px;text-align:center;font-size:18px;font-weight:600;">{{ strtoupper($setting->board_full_name) }}, ANNUAL EXAMINATION {{ strtoupper($session->title) }}</h1>
        <h1 style="padding:0px;margin:0px;text-align:center;font-size:15px;font-weight:600;text-decoration:underline;">OVERALL TOP 10 POSITIONS OF CLASS {{ strtoupper($standard->name) }}</h1>
      </td>
  </tr>

</table>

<table class="GeneratedTable">
  <thead>
    <?php $subjects = App\Models\StudentsExam::getSubjectsByDistrictToppersCombined($session->id,  $standard->id); ?>
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
      <th style="font-size:10px;font-weight: bold;background:#ccc;">Position</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=1; ?>
    <?php $gazettes = App\Models\StudentsExam::getToppersByOverAllClass($session->id, $standard->id); ?>
    @if(count($gazettes)>0)
      @foreach($gazettes as $position_holders)
        @foreach($position_holders as $gazette)  
          <tr>
            <td style="font-size:10px;">{{ $i }}</td>
            <td style="font-size:10px;">{{ $gazette["district_name"] }}</td>
            <td style="font-size:10px;">{{ $gazette["center_code"] }}</td>
            <td style="font-size:10px;">{{ $gazette["center_name"] }}</td>
            <td style="font-size:10px;">{{ $gazette["name"] }}</td>
            <td style="font-size:10px;">{{ $gazette["father_name"] }}</td>
            <td style="font-size:10px;">{{ $standard->name }}</td>
            <td style="font-size:10px;">{{ $gazette["id"] }}</td>
            <?php $t_subjects = App\Models\StudentsExam::getSubjectsAndMarksDetailsByDistrictToppers($session->id, $standard->id, $gazette["id"]); ?>
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
            @if($gazette["result"] == 0)
              <td style="font-size:10px;">PASS</td>
            @elseif($gazette["result"] == 1)
              <td style="font-size:10px;">PROMOTED</td>
            @else
              <td style="font-size:10px;">REAPPEAR</td>
            @endif

            @if($gazette["position"] == 1)
              <td style="font-size:10px;">1ST</td>
            @elseif($gazette["position"] == 2)
              <td style="font-size:10px;">2ND</td>
            @elseif($gazette["position"] == 3)
              <td style="font-size:10px;">3RD</td>
            @elseif($gazette["position"] == 4)
              <td style="font-size:10px;">4TH</td>
            @elseif($gazette["position"] == 5)
              <td style="font-size:10px;">5TH</td>
            @elseif($gazette["position"] == 6)
              <td style="font-size:10px;">6TH</td>
            @elseif($gazette["position"] == 7)
              <td style="font-size:10px;">7TH</td>
            @elseif($gazette["position"] == 8)
              <td style="font-size:10px;">8TH</td>
            @elseif($gazette["position"] == 9)
              <td style="font-size:10px;">9TH</td>
            @else
              <td style="font-size:10px;">10TH</td>
            @endif
          </tr>
        <?php $i++; ?>
        @endforeach
      <!-- HERE !-->
      @endforeach
    @endif
  </tbody>
</table>

<footer>
  <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
</footer>
</body>
</html>