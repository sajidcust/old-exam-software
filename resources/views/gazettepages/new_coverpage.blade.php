<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gazette Cover Page {{ $session->title }} - {{ $standard->name }}</title>

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
  <table style="padding: 5px; width: 100%; height: 680px; border: 2px solid #000;">
<tbody>
<tr>
<td style="border: 1px solid #000;">
<table style="width: 100%; border-collapse: collapse; border-style: none;padding:5px;" border="1">
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
<h1><span style="text-decoration: underline;">RESULT GAZETTE</span></h1>
</td>
</tr>
</tbody>
</table>
<table style="height: 68px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr>
<td style="width: 100%; border-style: none; text-align: center;">
<h1>ANNUAL EXAMINATION {{ strtoupper($session->title) }}</h1>
</td>
</tr>
</tbody>
</table>
<table style="height: 73px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr style="height: 73px;">
<td style="width: 100%; height: 73px; border-style: none; text-align: center;">
<h1>CLASS: {{ strtoupper($standard->name) }}</h1>
</td>
</tr>
</tbody>
</table>
<table style="height: 73px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr style="height: 73px;">
<td style="width: 100%; height: 73px; border-style: none; text-align: center;">
<h1>DIRECTORATE OF EDUCATION GILGIT BALTISTAN</h1>
</td>
</tr>
</tbody>
</table>
<table style="height: 73px; width: 100%; border-collapse: collapse; border-style: none;" border="1">
<tbody>
<tr style="height: 73px;">
<td style="width: 20%; height: 73px; border-style: none; text-align: center; font-weight: bold;">
<h4>PH# 05811-940888</h4>
</td>
<td style="width: 60%; height: 73px; border-style: none; text-align: right; font-weight: bold;">
</td>
<td style="width: 20%; height: 73px; border-style: none; text-align: center; font-weight: bold;">
<h4>E-mail: beegilgit@gmail.com</h4>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<footer>
  <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
</footer>
</body>
</html>