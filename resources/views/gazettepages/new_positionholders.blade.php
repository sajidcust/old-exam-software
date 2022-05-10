<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gazette Position Holders Page {{ $session->title }} - {{ $standard->name }}</title>

<style type="text/css">
    body {
      margin-left: 4cm;
      margin-right: 4cm;
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

<table style="padding: 5px; width: 100%;">
<tbody>
<tr>
<td style="">
<table style="width: 100%; border-collapse: collapse; border-style: none; padding: 5px;" border="1">
<tbody>
<tr>
<td style="width: 20%; border-style: none; text-align: center;"><img src="img/g.png" alt="" width="100" /></td>
<td style="width: 60%; border-style: none;">
<h1 style="text-align: center;">{{ strtoupper($setting->board_full_name) }}</h1>
</td>
<td style="width: 20%; border-style: none; text-align: center;"><img src="img/w.png" alt="" width="100" /></td>
</tr>
</tbody>
</table>
<table style="height: 68px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr>
<td style="width: 100%; border-style: none; text-align: center;">
<h2><span style="text-decoration: underline;">Position Holders of Class {{ $standard->name }}</span></h2>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

<table style="border-collapse: collapse; width: 95%;" border="1">
<thead>
  <tr>
    <th style="text-align:center; width: 12%;">Image</th>
    <th style="text-align:center; width: 5%;">Roll No</th>
    <th style="text-align:center; width: 15%;">Name</th>
    <th style="text-align:center; width: 15%;">F. Name</th>
    <th style="text-align:center; width: 28%;">Institution</th>
    <th style="text-align:center; width: 10%;">District</th>
    <th style="text-align:center; width: 5%;">Obt Marks</th>
    <th style="text-align:center; width: 5%;">%age</th>
    <th style="text-align:center; width: 5%;">Position</th>
  </tr>
</thead>
<tbody>
  @foreach($position_holders as $holders)
    @foreach($holders as $position)
        <tr>
          <td style="padding:10px;text-align:center;">
          @if($position["image"] != '')
            <?php $image = ltrim($position["image"], $position["image"][0]); ?>
            <img alt="" width="100" src="{{ $image }}" alt="" width="70"/>
          @endif
          </td>
          <td style="padding:10px;text-align:center;">{{ $position["id"] }}</td>
          <td style="padding:10px;text-align:center;">{{ $position["name"] }}</td>
          <td style="padding:10px;text-align:center;">{{ $position["father_name"] }}</td>
          <td style="padding:10px;text-align:center;">{{ $position["institution_name"] }}</td>
          <td style="padding:10px;text-align:center;">{{ $position["district_name"] }}</td>
          <td style="padding:10px;text-align:center;">{{ $position["total_obt_marks"] }}</td>
          <td style="padding:10px;text-align:center;">{{ $position["marks_percentage"] }}</td>
          <td style="padding:10px;text-align:center;">
            @if($position["position"] == 1)
              <h1 style="font-size:50px;color:blue">1st</h1>
            @elseif($position["position"] == 2)
              <h1 style="font-size:50px;color:green;">2nd</h1>
            @else
              <h1 style="font-size:50px;color:red;">3rd</h1>
            @endif
          </td>
        </tr>
    @endforeach
  @endforeach
</tbody>
</table>

<footer>
  <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
</footer>
</body>
</html>