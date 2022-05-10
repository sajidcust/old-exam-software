<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gazette Preamble Page {{ $session->title }} - {{ $standard->name }}</title>

<style type="text/css">
  body{
        margin-left: 4cm;
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
                $x = $pdf->get_width()-140;
                $pdf->text($x, $y, $pageText, $font, $size);
            } 
        ');
      }
  </script>

<table style="height: 107px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr style="height: 50px;">
<td style="width: 100%; height: 50px; border-style: none; text-align: center;"><strong><h1>PREAMBLE</h1></strong></td>
</tr>
<tr style="height: 18px;">
<td style="width: 100%; height: 18px; border-style: none; text-align: center;">
<p style="text-align: left;">&nbsp; &nbsp; The {{ $setting->board_full_name }} conducted the Annual Examination of Class <span style="text-decoration: underline;"><strong>{{ $standard->name }}</strong></span> for <span style="text-decoration: underline;"><strong>{{ $session->title }}</strong></span> from 

<?php
  $semesters = App\Models\Semester::where('session_id', $session->id)->get();
  $i = 0;
  foreach($semesters as $semester){
    $starting_date = App\Models\Datesheet::where('datesheets.session_id', $session->id)->where('datesheets.class_id', $standard->id)->where('datesheets.semester_id', $semester->id)->orderBy('datesheets.paper_date', 'ASC')->first([DB::raw('DATE_FORMAT(datesheets.paper_date, "%W, %d %M %Y") AS paper_date')]);
    $ending_date = App\Models\Datesheet::where('datesheets.session_id', $session->id)->where('datesheets.class_id', $standard->id)->where('datesheets.semester_id', $semester->id)->orderBy('datesheets.paper_date', 'ASC')->get([DB::raw('DATE_FORMAT(datesheets.paper_date, "%W, %d %M %Y") AS paper_date')])->last();

    if($starting_date && $ending_date && $i == 0){
      echo "<span style='text-decoration: underline;'><strong>". $starting_date->paper_date ."</strong></span>";
      echo " which continued upto <span style='text-decoration: underline;'><strong>".$ending_date->paper_date."</strong></span>";
    } else if($starting_date && $ending_date) {
      echo "for ". $semester->name ." and <span style='text-decoration: underline;'><strong>".$starting_date->paper_date."</strong></span>";
      echo " which continued upto <span style='text-decoration: underline;'><strong>".$ending_date->paper_date."</strong></span> for ".$semester->name;
    }
    $i++;
  }
?>
</p>
<p style="text-align: left;">&nbsp; &nbsp; &nbsp;The total number of students in class <span style="text-decoration: underline;"><strong>{{ $standard->name }}</strong></span> were <span style="text-decoration: underline;"><strong>{{ $result->total_students }}</strong></span>, out of which <span style="text-decoration: underline;"><strong>{{ $result->pass_students }}</strong></span> were declared <strong>Pass</strong> whereas <span style="text-decoration: underline;"><strong>{{ $result->promoted_students }}</strong></span> were declared as <strong>Promoted</strong> and <span style="text-decoration: underline;"><strong>{{ $result->reappear_students }}</strong></span> were considered as <strong>Reappear</strong> and the pass percentage is <span style="text-decoration: underline;"><strong>{{ round(((($result->pass_students+$result->promoted_students)/$result->total_students)*100), 2) }}%</strong></span>.</p>

<p style="text-align: left;">&nbsp; &nbsp; &nbsp; The table below shows a complete representation of result detail of Class {{ $standard->name }}:-
  <table style="border-collapse: collapse; width: 100%;margin-bottom:5px;" border="1">
      <tbody>
      <tr>
      <td style="font-size:13px;width: 12.5%; text-align: left;">TOTAL:</td>
      <td style="font-size:13px;width: 12.5%; text-align: center;"><strong><strong>{{ $result->total_students }}</strong></td>
      <td style="font-size:13px;width: 12.5%; text-align: left;">PASS:</td>
      <td style="font-size:13px;width: 12.5%; text-align: center;"><strong>{{ $result->pass_students }}</td>
      <td style="font-size:13px;width: 12.5%; text-align: left;">PROMOTED:</td>
      <td style="font-size:13px;width: 12.5%; text-align: center;"><strong><strong>{{ $result->promoted_students }}</strong></td>
      <td style="font-size:13px;width: 12.5%; text-align: left;">REAPPEAR</td>
      <td style="font-size:13px;width: 12.5%; text-align: center;"><strong><strong>{{ $result->reappear_students }}</strong></td>
      </tr>
      <tr>
      <td style="font-size:13px;width: 25%; text-align: left;" colspan="2">PERCENTAGE:</td>
      <td style="font-size:13px;width: 12.5%; text-align: left;">PASS %:</td>
      <td style="font-size:13px;width: 12.5%; text-align: center;"><strong>
      @if($result->pass_students != 0)
         {{ round((($result->pass_students/$result->total_students)*100), 2) }}
      @else
        0.00
      @endif
      </strong>
      </td>
      <td style="font-size:13px;width: 12.5%; text-align: left;">PROMOTED %:</td>
      <td style="font-size:13px;width: 12.5%; text-align: center;"><strong>
      @if($result->promoted_students != 0)
        {{ round((($result->promoted_students/$result->total_students)*100), 2) }}
      @else
        0.00
      @endif
      </strong>
      </td>
      <td style="font-size:13px;width: 12.5%; text-align: left;">REAPPEAR %</td>
      <td style="font-size:13px;width: 12.5%; text-align: center;"><strong>
      @if($result->reappear_students != 0)
        {{ round((($result->reappear_students/$result->total_students)*100), 2) }}
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
      <td style="font-size:13px;width: 7.14%; text-align: center;">A+:</td>
      <td style="font-size:13px;width: 7.14%; text-align: center;"><strong>{{ $result->a_plus_students }}</strong></td>
      <td style="font-size:13px;width: 7.14%; text-align: center;">A:</td>
      <td style="font-size:13px;width: 7.14%; text-align: center;"><strong>{{ $result->a_students }}</strong></td>
      <td style="font-size:13px;width: 7.14%; text-align: center;">B:</td>
      <td style="font-size:13px;width: 7.14%; text-align: center;"><strong>{{ $result->b_students }}</strong></td>
      <td style="font-size:13px;width: 7.14%; text-align: center;">C:</td>
      <td style="font-size:13px;width: 7.14%; text-align: center;"><strong>{{ $result->c_students }}</strong></td>
      <td style="font-size:13px;width: 7.14%; text-align: center;">D:</td>
      <td style="font-size:13px;width: 7.14%; text-align: center;"><strong>{{ $result->d_students }}</strong></td>
      <td style="font-size:13px;width: 7.14%; text-align: center;">E:</td>
      <td style="font-size:13px;width: 7.14%; text-align: center;"><strong>{{ $result->e_students }}</strong></td>
      <td style="font-size:13px;width: 7.14%; text-align: center;">F:</td>
      <td style="font-size:13px;width: 7.14%; text-align: center;"><strong>{{ $result->f_students }}</strong></td>
      </tr>
      </tbody>
      </table>
</p>

<p style="text-align: left;">&nbsp; &nbsp; During the exam process every possible care has been taken to make the result more transparent and accurate. However, errors and omissions are expected and the Board of Elementary Examination reserves the right of subsequent rectifications based on evidences and orignal record. Sugestions/better ideas will provide us energy and clear direction to make this process more transparent and effective.</p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table style="width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr>
<td style="width: 20%; border-style: none; text-align: center;"><strong>({{ $setting->deputy_controller_name }})</strong><br />Deputy Controller<br />{{ $setting->board_full_name }}</td>
<td style="width: 60%; border-style: none;">&nbsp;</td>
<td style="width: 20%; border-style: none; text-align: center;"><strong>({{ $setting->controller_name }})</strong><br />Controller BEEG/Director<br />Education (Academics)<br />Gilgit Division</td>
</tr>
</tbody>
</table>

<footer>
  <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
</footer>
</body>
</html>