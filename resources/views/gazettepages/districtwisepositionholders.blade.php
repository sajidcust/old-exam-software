<table width="100%">
  <tr>
      <td style="padding-top:20px;" valign="top" align="center">
        <h1 style="padding:0px;margin:0px;text-align:center;font-size:18px;font-weight:600;">BOARD OF ELEMENTARY EXAMINATION, GB ANNUAL EXAMINATION {{ strtoupper($session->title) }}</h1>
        <h1 style="padding:0px;margin:0px;text-align:center;font-size:15px;font-weight:600;text-decoration:underline;">DISTRICT WISE 1ST THREE POSITION OF CLASS {{ $standard->name }}</h1>
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
    @foreach($districts as $district)
      <?php $gazettes = App\Models\StudentsExam::getToppersGazetteByDistricts($session->id, $standard->id, $district->id); ?>
      @if(count($gazettes)>0)

        <?php $i = 1; ?>
        
        @foreach($gazettes as $gazette)
          <tr>
            <td style="font-size:10px;">{{ $i }}</td>
            <td style="font-size:10px;">{{ $district->name }}</td>
            <td style="font-size:10px;">{{ $gazette->center_id }}</td>
            <td style="font-size:10px;">{{ $gazette->center_name }}</td>
            <td style="font-size:10px;">{{ $gazette->name }}</td>
            <td style="font-size:10px;">{{ $gazette->father_name }}</td>
            <td style="font-size:10px;">{{ $standard->name }}</td>
            <td style="font-size:10px;">{{ $gazette->id }}</td>
            <?php $t_subjects = App\Models\StudentsExam::getSubjectsAndMarksDetailsByDistrictToppers($session->id, $standard->id, $gazette->id); ?>
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

            @if($i == 1)
              <td style="font-size:10px;">1ST</td>
            @elseif($i==2)
              <td style="font-size:10px;">2ND</td>
            @else
              <td style="font-size:10px;">3RD</td>
            @endif
          </tr>
        <!-- HERE !-->
          <?php $i++; ?>
        @endforeach
      @endif
    @endforeach
  </tbody>
</table>
<div class="page_break"></div>