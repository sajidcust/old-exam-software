<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Award Sheet {{ $session->title }} - {{ $semester->title }}-{{ $center->name }}</title>

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
  @if($standard)
    <?php $std_counter = 1; ?>
    @foreach($subjects as $subject)
      <?php $students = App\Models\Student::getStudentsByCAndSubs($center->id, $standard->id, $subject->id, $session->id, $semester->id); ?>
      
      @if($std_counter != 1)
        <div class="page_break"></div>
      @endif

      @if(count($students)>0)
        <table width="100%">
          <tr>
              <td style="padding-top:20px;" valign="top" align="center">
                <h1 style="padding:0px;margin:0px;text-align:center;font-size:18px;font-weight:600;">{{ strtoupper($setting->board_full_name) }} {{ strtoupper($session->title) }}</h1>
                <h1 style="padding:0px;margin:0px;text-align:center;font-size:15px;font-weight:600;text-decoration:underline;">{{ strtoupper($semester->title) }} EXAMINATION ATTENDANCE/AWARD SHEET</h1>
              </td>
          </tr>

        </table>
        <table width="100%">
          <tbody width="100%">
            <tr width="100">
              <td width="10">Center Code:</td>
              <td width="10">
                <p style="font-weight: bold;margin-top:0px; margin-bottom: 0px;"> {{ $center->id }}</p>
              </td>
              <td width="10">Center Name:</td>
              <td width="50">
                <p style="width:100%;font-weight: bold;margin-top:0px; margin-bottom: 0px;"> {{ $center->name }}</p>
              </td>
              <td width="10">Tehsil:</td>
              <td width="10">
                <p style="font-weight: bold;margin-top:0px; margin-bottom: 0px;"> {{ $center->tehsil_name }}</p>
              </td>
            </tr>
            <tr width="100">
              <td width="10">Class:</td>
              <td width="10">
                <p style="font-weight: bold;margin-top:0px; margin-bottom: 0px;"> {{ $standard->name }}</p>
              </td>
              <td width="10">Date:</td>
              <td width="50">
                <p style="width:100%;font-weight: bold;margin-top:0px; margin-bottom: 0px;"> {{ $subject->paper_date }}</p>
              </td>
              <td width="10">Subject:</td>
              <td width="10">
                <p style="font-weight: bold;margin-top:0px; margin-bottom: 0px;"> {{ $subject->name }}</p>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="GeneratedTable">
          <thead>
            <tr>
              <th>S. No</th>
              <th>Roll No</th>
              <th>Name</th>
              <th>Father Name</th>
              <th>Sheet No </th>
              <th>Sign</th>
              <th>Theo</th>
              <th>Hom Exm</th>
              <th>T. Marks</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; ?>
            @foreach($students as $student)
              <tr>
                <td style="text-align: center;">{{ $i }}</td>
                <td style="text-align: center;">{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->father_name }}</td>
                <td></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <?php $i++; ?>
            @endforeach
          </tbody>
        </table> 
        <br><br><br><br>
        <table width="100%">
          <thead width="100%">
            <tr width="100%">
              <td style="text-align: left;font-weight: bold;" width="33">Signature of Superintendent</td>
              <td style="text-align: center;font-weight: bold;" width="30">Signature of Examiner</td>
              <td style="text-align: right;font-weight: bold;" width="37">Signature of Head Examiner</td>
            </tr>
          </thead>
        </table>

        
        
        <?php $std_counter++; ?>
      @endif
    @endforeach
  @endif

  <br/>

  <footer>
    <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
  </footer>

</body>
</html>