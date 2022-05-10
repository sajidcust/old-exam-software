<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gazette Bar Graph Subject Wise Result Summary Page {{ $session->title }} - {{ $standard->name }}</title>

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

<table style="width: 100%; border-collapse: collapse; border-style: none;padding:5px;" border="1">
<tbody>
<tr>
<td style="width: 20%; border-style: none; text-align: center;"><img src="img/g.png" alt="" width="100" /></td>
<td style="width: 60%; border-style: none;">
<h1 style="text-align: center;">{{ strtoupper($setting->board_full_name) }}</h1>
<h3 style="text-align: center;">SUBJECT WISE RESULT SUMMARY GRAPHICAL VIEW</h3>
</td>
<td style="width: 20%; border-style: none; text-align: center;"><img src="img/w.png" alt="" width="100" /></td>
</tr>
</tbody>
</table>

<table style="width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr>
<td style="width: 100%; border-style: none;"><img src="{{ $image_address }}" alt="" width="900" height="500" /></td>
</tr>
</tbody>
</table>

<footer>
  <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
</footer>
</body>
</html>