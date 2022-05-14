<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gazette Table Of Contents Page {{ $session->title }} - {{ $standard->name }}</title>

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
  <table style="width: 100%; border-collapse: collapse; border-style: none;" border="1">
    <tbody>
    <tr>
    <td style="width: 100%; border-style: none; text-align: center;">
    <h1 style="font-size: 35px;">TABLE OF CONTENTS</h1>
    </td>
    </tr>
    </tbody>
    </table>
    <table style="border-collapse: collapse; width: 100%;" border="1">
      <thead>
        <tr>
          <th style="width: 7.96947%;">S.#</th>
          <th style="width: 79.695%;">Contents</th>
          <th style="width: 12.3354%;">Page #</th>
        </tr>
      </thead>
      <tbody>

        <?php $i=1; ?>

        @if($minister_page_no != NULL || $minister_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">MESSAGE FROM THE HONORABLE MINISTER {{ strtoupper($setting->minister_name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $minister_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($secretary_page_no != NULL || $secretary_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">MESSAGE FROM THE HONORABLE SECRETARY {{ strtoupper($setting->secretary_name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $secretary_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($controller_page_no != NULL || $controller_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">MESSAGE FROM THE HONORABLE CONTROLLER {{ strtoupper($setting->controller_name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $controller_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($preamble_page_no != NULL || $preamble_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">PREAMBLE</td>
            <td style="width: 12.3354%; text-align: center;">{{ $preamble_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($top_position_holders_page_no != NULL || $top_position_holders_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">OVERALL TOP THREE POSITION HOLDERS OF {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $top_position_holders_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($top_district_wise_position_holders_page_no != NULL || $top_district_wise_position_holders_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">DISTRICTWISE TOP THREE POSITION HOLDERS OF {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $top_district_wise_position_holders_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($overall_top_ten_position_holders_page_no != NULL || $overall_top_ten_position_holders_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">OVERALL TOP TEN POSITION HOLDERS OF {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $overall_top_ten_position_holders_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($districtwise_top_ten_position_holders_page_no != NULL || $districtwise_top_ten_position_holders_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">DISTRICTWISE TOP TEN POSITION HOLDERS OF {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $districtwise_top_ten_position_holders_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($pie_graph_overall_result_summary_page_no != NULL || $pie_graph_overall_result_summary_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">PIE GRAPH REPRESENTATION OF OVERALL RESULT SUMMARY OF  {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $pie_graph_overall_result_summary_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($bar_graph_districtwise_result_summary_page_no != NULL || $bar_graph_districtwise_result_summary_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">BAR GRAPH REPRESENTATION OF DISTRICTWISE RESULT SUMMARY OF  {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $bar_graph_districtwise_result_summary_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($bar_graph_subjectwise_result_summary_page_no != NULL || $bar_graph_subjectwise_result_summary_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">BAR GRAPH REPRESENTATION OF SUBJECTWISE RESULT PERCENTAGE OF  {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $bar_graph_subjectwise_result_summary_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        @if($bar_graph_subjectwise_districtwise_result_summary_page_no != NULL || $bar_graph_subjectwise_districtwise_result_summary_page_no != '')
          <tr>
            <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
            <td style="padding-left:10px; width: 79.695%;">BAR GRAPH REPRESENTATION OF DISTRICTWISE AND SUBJECTWISE RESULT PERCENTAGE OF  {{ strtoupper($standard->name) }}</td>
            <td style="width: 12.3354%; text-align: center;">{{ $bar_graph_subjectwise_districtwise_result_summary_page_no }}</td>
          </tr>
          <?php $i++; ?>
        @endif

        <?php
          $current_district = NULL;
          $previous_district = NULL;
        ?>

        @foreach($districts as $district)

          <?php $table_of_contents = App\Models\TableOfContent::join('institutions', 'institutions.id', '=', 'table_of_contents.center_id')->where('session_id', $session->id)->where('class_id', $standard->id)->where('district_id', $district->id)->orderBy('table_of_contents.center_id', 'ASC')->get(['institutions.name', 'table_of_contents.page_no']); ?>

          @foreach($table_of_contents as $table_of_content)

          @if($previous_district == $current_district)
            <?php $current_district = $district->id ?>
            <tr>
              <td style="width: 7.96947%; text-align: center;"><strong>{{ $i }}</strong></td>
              <td style="padding-left:10px; width: 79.695%;"><strong>DISTRICT {{ strtoupper($district->name) }} GAZETTE</strong></td>
              <td style="width: 12.3354%; text-align: center;"><strong>{{ $table_of_content->page_no-1 }}</strong></td>
            </tr>
            <?php $i++; ?>
          @endif

            <tr>
              <td style="width: 7.96947%; text-align: center;">{{ $i }}</td>
              <td style="padding-left:10px; width: 79.695%;">{{ strtoupper($table_of_content->name) }}</td>
              <td style="width: 12.3354%; text-align: center;">{{ $table_of_content->page_no }}</td>
            </tr>
            <?php $i++; ?>
          @endforeach
          <?php
            $previous_district = $current_district;
          ?>
        @endforeach

      </tbody>
    </table>


<footer>
  <p style="font-size:13px;text-align: center;">Powered By Highlander Connection © Heli Chowk, Near FCNA HQ, Jutial Gilgit</p>
</footer>
</body>
</html>