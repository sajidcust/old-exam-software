<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Roll No Slips</title>

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

    @page { size: legal portrait; }
    .page_break { page-break-before: always; }
</style>

</head>
<body>
  <?php $num = 1; ?>
  <?php @ini_set('max_execution_time', 5000); ?>
  @foreach($students as $student)
    <table width="100%">
    <tr>
        <td valign="top" align="center"><img src="img/g.png" alt="" width="60"/></td>
        <td style="padding-top:20px;" valign="top" align="center">
          <h1 style="padding:0px;margin:0px;text-align:center;font-size:15px;font-weight:600;">{{ strtoupper($setting->board_full_name) }}</h1>
          <h1 style="padding:0px;margin:0px;text-align:center;font-size:13px;font-weight:600;text-decoration:underline;">DATESHEET FOR EXAMINATIONS {{ strtoupper($student->session_title) }}</h1>
        </td>
        <td valign="top" align="center"><img src="img/w.png" alt="" width="60"/></td>
    </tr>

  </table>

  <table width="100%">
    <tbody width="100%">
      <tr width="100%">
        <td style="font-size:12px;" width="100">District</td>
        <td width="100">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:center;">{{ $student->district_name }}</p>
        </td>
        <td width="100"></td>
        <td width="100"></td>
        <?php //$image = ltrim($student->image, $student->image[0]); ?>
        <td width="20" style="padding-left:20px" rowspan="3"><img style="border:2px solid #ccc;" src="{{ $student->image }}" alt="" width="75"/></td>
      </tr>
      <tr width="100%">
        <td style="font-size:12px;" width="100">Roll No:</td>
        <td width="100">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:center;">{{ $student->id }}</p>
          
        </td>
        <td style="font-size:12px;" width="100" style="padding-left:10px;">&nbsp;Center Code</td>
        <td width="100">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:center;">{{ $student->center_id }}</p>
        </td>
      </tr>
      <tr width="100%">
        <td style="font-size:12px;" width="100">Class</td>
        <td width="100">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:center;">{{ $student->class_name }}</p>
        </td>
        <td width="100" style="padding-left:5px;font-size:12px;">Registration No:</td>
        <td width="100">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:center;">{{ $student->registration_no }}</p>
        </td>
      </tr>
      <tr width="100%">
        <td style="font-size:12px;" width="30">Student Name</td>
        <td width="70" colspan="4">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:left;padding-left:5px;">{{ $student->name }}</p>
        </td>
      </tr>
      <tr width="100%">
        <td style="font-size:12px;" width="30">Father's Name</td>
        <td width="70" colspan="4">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:left;padding-left:5px;">{{ $student->father_name }}</p>
        </td>
      </tr>
      <tr width="100%">
        <td style="font-size:12px;" width="30">Instituion</td>
        <td width="70" colspan="4">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:left;padding-left:5px;">{{ $student->institution_name }}</p>
        </td>
      </tr>
      <tr width="100%">
        <td style="font-size:12px;" width="30">Exam Center</td>
        <td width="70" colspan="4">
          <p style="margin:0px;border:1px solid #000;font-size:12px; padding: 0px;text-align:left;padding-left:5px;">{{ $student->center_name }}</p>
        </td>
      </tr>
    </tbody>
  </table>

  <table style="border-collapse: collapse; width: 100%;margin-top:10px;" border="1">
    <thead>
      <tr>
        <th style="text-align:center;font-size:12px;width: 10%;">S. NO</th>
        <th style="text-align:center;font-size:12px;width: 30%;">Subject</th>
        <th style="text-align:center;font-size:12px;width: 35%;">Day and Date</th>
        <th style="text-align:center;font-size:12px;width: 25%;">Time</th>
      </tr>
    </thead>
    <tbody>
        <?php $i=1; ?>
        <?php $subjects = App\Models\Subject::getSubjectDatesheet($student->id, $session_id, $semester_id); ?>
        @foreach($subjects as $subject)
          <tr>
            <td style="text-align:center;font-size:12px;width: 10%;">{{ $i }}</td>
            <td style="text-align:center;font-size:12px;width: 30%;">{{ $subject->subject_name }}</td>
            <td style="text-align:center;font-size:12px;width: 35%;">{{ date_format(date_create($subject->paper_date), "l, d F Y") }}</td>
            <td style="text-align:center;font-size:12px;width: 25%;">{{ date_format(date_create($subject->paper_starting_time), "h:i A") }} to {{ date_format(date_create($subject->paper_ending_time), "h:i A") }}</td>
          </tr>
          <?php $i++; ?>
        @endforeach
    </tbody>
  </table>

    <table width="100%">
      <tbody>
        <tr>
          <td>
            <img src="img/slip_note.jpg" alt="" width="60%"/>
          </td>
          <td>
            <img src="img/controller_signature.jpg" alt="" width="20%"/>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    @if($num%2)
      <hr style="margin-left:-45px;border:none;border-top:2px dashed #000;color:#fff;background-color:#fff;height:1px;width:120%;">
    @endif
    <br/>
    @if(!($num%2) && count($students) != $num)
      <div class="page_break"></div> 
    @endif
    <?php $num++; ?>
  @endforeach

  
  <footer>
    <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
  </footer>
</body>
</html>