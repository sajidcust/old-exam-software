<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Date Sheet {{ $session->title }} - {{ $semester->title }}-{{ $standard->name }}</title>

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

    .page_break { page-break-before: always; }
</style>

</head>
<body>
  <table style="margin-bottom:15px;" width="100%">
    <tr>
        <td style="padding-top:20px;" valign="top" align="center">
          <h1 style="padding:0px;margin:0px;text-align:center;font-size:18px;font-weight:600;">{{ strtoupper($setting->board_full_name) }}</h1>
          <h1 style="padding:0px;margin:0px;text-align:center;font-size:15px;font-weight:600;text-decoration:underline;">{{ strtoupper($semester->title) }} EXAMINATION DATESHEET CLASS {{ strtoupper($standard->name) }} FOR {{ strtoupper($session->title) }}</h1>
        </td>
    </tr>

  </table>

  <table class="GeneratedTable">
    <thead>
      <tr>
        <th style="font-size:13px;width:5%">S. No</th>
        <th style="font-size:13px;width:5%">Subject Code</th>
        <th style="font-size:13px;width:25%">Subject</th>
        <th style="font-size:13px;width:35%">Date</th>
        <th style="font-size:13px;width:15%">Starting Time</th>
        <th style="font-size:13px;width:15%">Ending Time</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; ?>
      @foreach($subjects as $subject)
        <tr>
          <td style="font-size:13px; text-align: center;">{{ $i }}</td>
          <td style="font-size:13px; text-align: center;">{{ $subject->id }}</td>
          <td style="font-size:13px;">{{ $subject->subject_name }}</td>
          <td style="font-size:13px;">{{ $subject->paper_date }}</td>
          <td style="font-size:13px;">{{ $subject->paper_starting_time }}</td>
          <td style="font-size:13px;">{{ $subject->paper_ending_time }}</td>
        </tr>
        <?php $i++; ?>
      @endforeach
    </tbody>
  </table>

  <footer>
    <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
  </footer>

</body>
</html>