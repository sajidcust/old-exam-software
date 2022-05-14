<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Award Sheet {{ $session->title }} - {{ $standard->name }}</title>

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

    /*table.GeneratedTable {
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
    }*/

    .page_break { page-break-before: always; }
</style>

</head>
<body>
  @include('gazettepages.coverpage', array('session' => $session, 'standard'=>$standard))
  @include('gazettepages.ministermessage')
  @include('gazettepages.controllermessage')
  @include('gazettepages.preamble')
  @include('gazettepages.positionholders')
  @include('gazettepages.districtwisepositionholders', array('session' => $session, 'standard'=>$standard, 'districts'=>$districts))
  @include('gazettepages.overalltoptenpositions', array('session' => $session, 'standard'=>$standard))
  @include('gazettepages.overallresultgraphic')


  <?php //exit; ?>

  @if($districts)
    @foreach($districts as $district)
      <table width="100%">
        <thead>
          <tr>
              <td style="padding-top:20px;" valign="top" align="center">
                <h1 style="padding:0px;margin:0px;text-align:center;font-size:18px;font-weight:600;">BOARD OF ELEMENTARY EXAMINATION, GB CONSOLIDATED ANNUAL EXAMINATION RESULT {{ strtoupper($session->title) }}</h1>
              </td>
          </tr>
        </thead>
      </table>

      <?php $centers = App\Models\StudentsExam::getCenters($session->id, $standard->id, $district->id); ?>
      @if(count($centers)>0)
        @foreach($centers as $center)
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

            <table border="1" style="border-collapse:collapse;" class="GeneratedTable" width="100%">
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
                    @if($gazette->result == 0)
                      <td style="font-size:10px;">PASS</td>
                    @elseif($gazette->result == 1)
                      <td style="font-size:10px;">PROMOTED</td>
                    @else
                      <td style="font-size:10px;">REAPPEAR</td>
                    @endif
                  </tr>
                <!-- HERE !-->
                  <?php $i++; ?>
                @endforeach
              </tbody>
            </table>
          @endif
        @endforeach
      @endif
    @endforeach
  @endif
  <br/>

  <footer>
    <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
  </footer>

</body>
</html>