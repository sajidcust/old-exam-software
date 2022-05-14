@extends('layouts.main')


@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $main_title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ $breadcrumb_title }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header row">
                <div class="col-lg-6">
                  <h3 class="card-title custom-card-title">{{ $card_title }}</h3>
                </div>
                <div class="col-lg-6">
                  <!-- <button id="add_in_chunks_btn" class="btn btn-info custom-pull-right margin-left-right-5px"><span class="fa fa-random"></span>&nbsp;&nbsp;Start In Chunks</button> -->
                  <button id="add_btn" class="btn btn-info custom-pull-right margin-left-right-5px"><span class="fa fa-random"></span>&nbsp;&nbsp;Start Now</button>
                  <button id="reset_btn" class="btn btn-danger custom-pull-right margin-left-right-5px"><span class="fa fa-redo-alt"></span>&nbsp;&nbsp;Reset</button>
                </div>
              </div>
              <?php $isDataSetted = App\Models\Gazette::where('session_id', $session_id)->where('class_id', $class_id)->count(); ?>
              <!-- form start -->
              <div class="dynamic_wrapper">
                <br>
                @if($isDataSetted > 0)
                <div class="card-header">
                  <h3 class="card-title"><strong>Print Cover Page</strong></h3>
                </div>
                <form id="quickForm_complete" method="post" action="{{ route('exams.downloadgazettecoverpage') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div style="padding-left:20px;padding-right: 20px;">
                  <br>    
                  <div class="row">
                    <div class="col-lg-12">
                      <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                    </div>
                  </div>
                </div>
              </form>
              <br>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Ministers Message</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_minister_message" method="post" action="{{ route('exams.downloadministermessagepage') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Secretary's Message</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_secretary_message" method="post" action="{{ route('exams.downloadsecretarymessage') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Controllers Message</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_controller_message" method="post" action="{{ route('exams.downloadcontrollermessage') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Preamble</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_preamble" method="post" action="{{ route('exams.downloadpreamble') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Position Holders Page</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_position_holders" method="post" action="{{ route('exams.downloadpositionholders') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Districtwise Position Holders</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_district_wise_position_holders" method="post" action="{{ route('exams.downloaddistrictwisepositionholders') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Overall Top 10 Position Holders</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_over_all_top_ten_position_holders" method="post" action="{{ route('exams.overalltoptenpositionholders') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Districtwise Top 10 Position Holders</strong></h3>
              </div>

              <form id="quickForm_district_top_10_position_holders" method="post" action="{{ route('exams.districtwisetop10positionholders') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">

                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                        <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                       </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="labelInputDisrtict">District<i class="fa fa-star-of-life required-label"></i></label>
                          <select class="custom-select rounded-0 select2" id="labelInputDisrtict" name="district_id">
                              <option value="">Select a district</option> 
                              @foreach($districts as $district)
                                @if($district->id == Request::old('district_id'))
                                    <option selected value="{{ $district->id }}">{{ $district->name }}</option>
                                @else
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Pie Graph Overall Result Summary</strong></h3>
              </div>
              <!-- form start -->
              <div style="text-align:center;width: 100%;" class="center">
                <div style="display: inline-block;margin:0 auto;padding:3px;" id="chart_div"></div>
              </div>
              <?php $result_pie_graph = App\Models\StudentsExam::getTotalPassFailStudents($session_id, $class_id); ?>
              <?php $result_bar_graph = App\Models\StudentsExam::getTotalPassFailStudentsByDistricts($session_id, $class_id); ?>
              <?php $result_bar_graph_subjects = App\Models\StudentsExam::getTotalPassFailStudentsBySubjects($session_id, $class_id); ?>
              <form id="quickForm_pie_graph_overall_result_summary" method="post" action="{{ route('exams.downloadpiegraphoverallsummary') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <input type="hidden" name="total_students_appeared" value="{{ $result_pie_graph['results_arr']['total_students_appeared'] }}">
                <input type="hidden" name="pass_students" value="{{ $result_pie_graph['results_arr']['pass_students'] }}">
                <input type="hidden" name="promoted_students" value="{{ $result_pie_graph['results_arr']['promoted_students'] }}">
                <input type="hidden" name="reappear_students" value="{{ $result_pie_graph['results_arr']['reappear_students'] }}">
                <input id="pie_data_input" type="hidden" name="pie_graph_image" value="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>
              <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

              <script type="text/javascript">
                google.charts.load('current', {packages:['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                  var arr = [];

                  var json_arr = <?php echo $result_pie_graph["percentages_arr"]; ?>

                  for(var i in json_arr){
                    arr.push([i, json_arr [i]]);
                  }

                  var data = new google.visualization.DataTable();

                  data.addColumn('string','Days');
                  data.addColumn('number','Income');
                  data.addRows(arr);

                  var options = {
                    title:'Overall Summary of Result',
                    width:800,
                    height:500,
                    is3D:true
                  };

                  var chart_div = document.getElementById('chart_div');
                  var chart = new google.visualization.PieChart(chart_div);
                  google.visualization.events.addListener(chart, 'ready', function () {
                    chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
                    document.getElementById('pie_data_input').value = chart.getImageURI();
                    console.log(chart_div.innerHTML);
                  });

                  chart.draw(data, options);


                  // District wise summary chart.

                  var dd_data = [];

                  var json_arr_dd = <?php echo $result_bar_graph["percentages_arr"]; ?>

                  var data2 = new google.visualization.DataTable(json_arr_dd);

                  var options2 = {
                    title:'Districtwise Percentages of Result Summary.',
                    width:1000,
                    height:500
                  };

                  var view2 = new google.visualization.DataView(data2);
                  view2.setColumns([0, 1,
                                   { calc: 'stringify',
                                     sourceColumn: 1,
                                     type: 'string',
                                     role: 'annotation' },
                                   2,
                                   { calc: 'stringify',
                                     sourceColumn: 2,
                                     type: 'string',
                                     role: 'annotation' },
                                   3, 
                                    { calc: 'stringify',
                                     sourceColumn: 3,
                                     type: 'string',
                                     role: 'annotation' },
                                   ]);

                  var chart_div_bar = document.getElementById('chart_div_bar');
                  var chart_bar = new google.visualization.ColumnChart(chart_div_bar);

                  google.visualization.events.addListener(chart_bar, 'ready', function () {
                    chart_div_bar.innerHTML = '<img src="' + chart_bar.getImageURI() + '">';
                    document.getElementById('bar_data_input').value = chart_bar.getImageURI();
                    console.log(chart_div_bar.innerHTML);
                  });

                  chart_bar.draw(view2, options2);


                  //subjectwise bar chart data
                  <?php
                    $standard = App\Models\Standard::find($class_id);
                  ?>

                  var sd_data = <?php echo $result_bar_graph_subjects["percentages_arr"]; ?>

                  var data3 = new google.visualization.DataTable(sd_data);

                  var options3 = {
                    title:"Subjectwise Result Summary Class {{ $standard->name }}.",
                    width:1200,
                    height:500
                  };

                  var view3 = new google.visualization.DataView(data3);
                  view3.setColumns([0, 1,
                                   { calc: "stringify",
                                     sourceColumn: 1,
                                     type: "string",
                                     role: "annotation" },
                                   2,
                                   { calc: "stringify",
                                     sourceColumn: 2,
                                     type: "string",
                                     role: "annotation" },
                                   ]);

                  var chart_div_bar_subject = document.getElementById('chart_div_bar_subject');
                  var chart_bar_subject = new google.visualization.ColumnChart(chart_div_bar_subject);

                  google.visualization.events.addListener(chart_bar_subject, 'ready', function () {
                    chart_div_bar_subject.innerHTML = '<img src="' + chart_bar_subject.getImageURI() + '">';
                    document.getElementById('bar_subject_data_input').value = chart_bar_subject.getImageURI();
                    console.log(chart_div_bar_subject.innerHTML);
                  });

                  chart_bar_subject.draw(view3, options3);



                  //subjectwise bar chart data district 1

                  <?php 
                    foreach($districts as $district) { 
                      $result_bar_graph_subjects_and_districts = App\Models\StudentsExam::getTotalPassFailStudentsBySubjectsAndDistricts($session_id, $class_id, $district->id);
                      //dd($result_bar_graph_subjects_and_districts);
                  ?>

                      var json_data = <?php echo $result_bar_graph_subjects_and_districts['percentages_arr']; ?>;

                      var data = new google.visualization.DataTable(json_data);

                      var options = {
                        title:"Subjectwise Result Summary {{ $district->name }} Class {{ $standard->name }}.",
                        width:500,
                        height:300
                      };

                      var view = new google.visualization.DataView(data);
                      view.setColumns([0, 1,
                                       { calc: "stringify",
                                         sourceColumn: 1,
                                         type: "string",
                                         role: "annotation" },
                                       2,
                                       { calc: "stringify",
                                         sourceColumn: 2,
                                         type: "string",
                                         role: "annotation" },
                                       ]);

                      var chart_div_bar_subject_district = document.getElementById('chart_div_bar_subject_{{ $district->id }}');
                      var chart_bar_subject_district = new google.visualization.ColumnChart(chart_div_bar_subject_district);

                      google.visualization.events.addListener(chart_bar_subject_district, 'ready', function () {
                        chart_div_bar_subject_district.innerHTML = '<img src="' + chart_bar_subject_district.getImageURI() + '">';
                        document.getElementById('bar_subject_data_input_{{ $district->id }}').value = chart_bar_subject_district.getImageURI();
                      });

                      chart_bar_subject_district.draw(view, options);


                  <?php
                      }

                  ?>

              }
              </script>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Bar Graph Districtwise Summary</strong></h3>
              </div>
              <!-- form start -->
              <div style="text-align:center;width: 100%;" class="center">
                <div style="display: inline-block;margin:0 auto;padding:3px;" id="chart_div_bar"></div>
              </div>
              <form id="quickForm_bar_graph_districtwise_summary" method="post" action="{{ route('exams.downloadbargraphdistrictwisesummary') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <input type="hidden" name="table_data" value="{{ $result_bar_graph['results'] }}">
                <input id="bar_data_input" type="hidden" name="bar_graph_image" value="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Bar Graph Overall Subjectwise Result</strong></h3>
              </div>
              <!-- form start -->
              <div style="text-align:center;width: 100%;" class="center">
                <div style="display: inline-block;margin:0 auto;padding:3px;" id="chart_div_bar_subject"></div>
              </div>
              <form id="quickForm_subjectwise_result_percentage" method="post" action="{{ route('exams.downloadsubjectwiseresultpercentage') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <input id="bar_subject_data_input" type="hidden" name="bar_graph_image" value="">
                <input type="hidden" name="table_data" value="{{ $result_bar_graph_subjects['results'] }}">

                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Bar Graph Subjectwise District Summary</strong></h3>
              </div>
              <!-- form start -->
              <div class="row">
                @foreach($districts as $district)
                  <div class="col-lg-6">
                    <div style="text-align:center;width: 100%;" class="center">
                      <div style="display: inline-block;margin:0 auto;padding:3px;" id="chart_div_bar_subject_{{ $district->id }}"></div>
                    </div>
                  </div>
                @endforeach
              </div>
              <form id="quickForm_bar_graph_subjectwise_district_summary" method="post" action="{{ route('exams.bargraphsubjectwisedistrictsummary') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                @foreach($districts as $district)
                  <input id="bar_subject_data_input_{{ $district->id }}" type="hidden" name="bar_graph_image[]" value="">
                @endforeach
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                   </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Complete Gazette</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_print_complete_gazette" method="post" action="{{ route('exams.printcompletegazettewithpages') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">

                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                        <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                       </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="labelInputDisrtict">District<i class="fa fa-star-of-life required-label"></i></label>
                          <select class="custom-select rounded-0 select2" id="labelInputDisrtict" name="district_id">
                              <option value="">Select a district</option> 
                              @foreach($districts as $district)
                                @if($district->id == Request::old('district_id'))
                                    <option selected value="{{ $district->id }}">{{ $district->name }}</option>
                                @else
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Centerwise Gazette</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm_print_centerwise_gazette" method="post" action="{{ route('exams.printcenterwisegazettewithpages') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">

                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="labelInputPageNo">Previous Page No<i class="fa fa-star-of-life required-label"></i></i></label>
                        <input type="number" name="page_no" class="form-control" id="labelInputPageNo" placeholder="Enter page no" value="">
                       </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="labelInputCenter">Center<i class="fa fa-star-of-life required-label"></i></label>
                          <select class="custom-select rounded-0 select2" id="labelInputCenter" name="center_id">
                              <option value="">Select a center</option> 
                              @foreach($centers as $center)
                                @if($center->id == Request::old('center_id'))
                                    <option selected value="{{ $center->id }}">{{ $center->id. " - ". $center->name }}</option>
                                @else
                                    <option value="{{ $center->id }}">{{ $center->id. " - ". $center->name }}</option>
                                @endif
                              @endforeach
                          </select>
                       </div>
                      </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>

              <div class="card-header">
                <h3 class="card-title"><strong>Print Table of Contents</strong></h3>
              </div>
              <!-- form start -->
              <form id="quickForm" method="post" action="{{ route('exams.generatetableofcontents') }}">
                {{ csrf_field() }}
                <input type="hidden" name="session_id" value="{{ $session_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="card-body">
                  
                  <div class="form-group">
                      <label for="labelInputMinisterPageNo">Page No For Minister's Message<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="minister_page_no" class="form-control" id="labelInputMinisterPageNo" placeholder="Enter Page No For Minister's Message" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputSecretaryPageNo">Page No For Secretary's Message<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="secretary_page_no" class="form-control" id="labelInputSecretaryPageNo" placeholder="Enter Page No For Secretary's Message" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputControllerPageNo">Page No For Controller's Message<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="controller_page_no" class="form-control" id="labelInputControllerPageNo" placeholder="Enter Page No For Controller's Message" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputPreamblePageNo">Page No For Preamble Page<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="preamble_page_no" class="form-control" id="labelInputPreamblePageNo" placeholder="Enter Page No For Preamble Page" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputTopPositionHoldersPageNo">Page No For Top Position Holders<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="top_position_holders_page_no" class="form-control" id="labelInputTopPositionHoldersPageNo" placeholder="Enter Page No For Top Position Holders" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputTopDistrictwisePositionHoldersPageNo">Page No For Districtwise 1st Three Positions<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="top_district_wise_position_holders_page_no" class="form-control" id="labelInputTopDistrictwisePositionHoldersPageNo" placeholder="Enter Page No For Districtwise 1st Three Positions" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputOverallTop10PositionHoldersPageNo">Page No For Overall Top 10 Positions<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="overall_top_ten_position_holders_page_no" class="form-control" id="labelInputOverallTop10PositionHoldersPageNo" placeholder="Enter Page No For Overall Top 10 Positions" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputOverallTop10PositionHoldersPageNo">Page No For Districtwise Top 10 Position Holders First Page<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="districtwise_top_ten_position_holders_page_no" class="form-control" id="labelInputDistrictwiseTop10PositionHoldersPageNo" placeholder="Enter Page No For Districtwise Top 10 Positions First Page" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputOverallResultPieGraphSummaryPageNo">Page No For Overall Pie Graph Summary<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="pie_graph_overall_result_summary_page_no" class="form-control" id="labelInputOverallResultPieGraphSummaryPageNo" placeholder="Enter Page No For Overall Pie Graph Summary" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputDistrictwiseResultBarGraphSummaryPageNo">Page No For Districtwise Bar Graph Summary<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="bar_graph_districtwise_result_summary_page_no" class="form-control" id="labelInputDistrictwiseResultBarGraphSummaryPageNo" placeholder="Enter Page No For Districtwise Bar Graph Summary" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputSubjectwiseResultBarGraphSummaryPageNo">Page No For Subjectwise Bar Graph Summary<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="bar_graph_subjectwise_result_summary_page_no" class="form-control" id="labelInputSubjectwiseResultBarGraphSummaryPageNo" placeholder="Enter Page No For Subjectwise Bar Graph Summary" value="">
                  </div>
                  <div class="form-group">
                      <label for="labelInputSubjectwiseAndDistrictwiseResultBarGraphSummaryPageNo">Page No For Subjectwise And Districtwise Bar Graph Summary<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="number" name="bar_graph_subjectwise_districtwise_result_summary_page_no" class="form-control" id="labelInputSubjectwiseAndDistrictwiseResultBarGraphSummaryPageNo" placeholder="Enter Page No For Subjectwise And Districtwise Bar Graph Summary" value="">
                  </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Download">
                </div>
              </form>
              @endif
              </div>
              <br>
            </div>
            <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@stop


@push('scripts')
<script>

  $.validator.addMethod('minStrict', function (value, el, param) {
    if(value < 1){
      return false;
    }

    return true;
  }, "Enter a value greater than 0.");

  var validatevar = $('#quickForm_print_complete_gazette').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        },
        district_id: {
          required: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_print_centerwise_gazette').validate({
      rules: {
        page_no: {
          required: true,
          number: true
        },
        center_id: {
          required: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_district_top_10_position_holders').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        },
        district_id: {
          required: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_bar_graph_subjectwise_district_summary').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_subjectwise_result_percentage').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_bar_graph_districtwise_summary').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_pie_graph_overall_result_summary').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_over_all_top_ten_position_holders').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_district_wise_position_holders').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_preamble').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_controller_message').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_secretary_message').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_minister_message').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  var validatevar = $('#quickForm_position_holders').validate({
      rules: {
        page_no: {
          required: true,
          number: true,
          minStrict:true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        $(element).removeClass('is-valid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        $(element).addClass('is-valid');
      },
      submitHandler: function(form) {
        form.submit();
      }
   });

  $(document).ready(function(){
    $('body').on('click', '#reset_btn', function (){
      var session_id = "{{ $session_id }}";
      var class_id = "{{ $class_id }}";
      url = "{{ route('exams.resetautgeneratedmeritlist') }}";

      $.confirm({
          title: 'Are you sure?',
          content: 'Simple confirm!',
          buttons: {
              yes: {
                  text: 'Yes',
                  btnClass: 'btn-red',
                  keys: ['enter', 'shift'],
                  action: function(){
                      Pace.track(function(){
                        $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                          type: "POST",
                          url: url,
                          data: {
                            session_id:session_id,
                            class_id:class_id
                          },
                          beforeSend: function()
                          {
                            Pace.start();
                          },
                          complete: function() {
                            Pace.stop();
                          },
                          success: function(data)
                          {
                            if(data['success'] == 'true'){
                              var successToast = $(document).Toasts('create', {
                                class: 'bg-success',
                                    title: 'Success!',
                                    autohide: true,
                                    delay: 2000,
                                    body: data['message']
                              });
                              window.location.reload();
                            } else {
                              var errorToast = $(document).Toasts('create', {
                                class: 'bg-danger',
                                    title: 'Oops!',
                                    autohide: true,
                                    delay: 2000,
                                    body: data['message']
                              });
                            }
                          }
                      });
                    });
                  }
              },
              no: {
                  text: 'No',
                  btnClass: 'btn-grey',
                  keys: ['enter', 'shift'],
                  action: function(){

                  }
              }
          }
      });
    });
  });

  $(document).ready(function(){
    $('body').on('click', '#add_btn', function (){
      var session_id = "{{ $session_id }}";
      var class_id = "{{ $class_id }}";
      url = "{{ route('exams.startautogeneration') }}";

      $.confirm({
          title: 'Are you sure?',
          content: 'Simple confirm!',
          buttons: {
              yes: {
                  text: 'Yes',
                  btnClass: 'btn-red',
                  keys: ['enter', 'shift'],
                  action: function(){
                      Pace.track(function(){
                        $.ajax({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          type: "POST",
                          url: url,
                          data: {
                            session_id:session_id,
                            class_id:class_id
                          },
                          beforeSend: function()
                          {
                            //$('#modal-danger').modal('hide');
                            Pace.start();

                            var toaster = $(document).Toasts('create', {
                              class: 'bg-warning',
                                  title: 'Processing!',
                                  autohide: false,
                                  close: false,
                                  body: '<div id="loading_toast" class="spinner-border" role="status"><span class="sr-only">Loading...</span></div><span style="position: relative;top:-8px;left: 3px;"><strong>Please wait for the success meassage</strong></span>'
                            });
                          },
                          complete: function() {
                            Pace.stop();
                            //$('#modal-danger').modal('hide');
                            $(document).find('#loading_toast').closest('.bg-warning').fadeOut(100);
                          },
                          success: function(data)
                          {
                            if(data['success'] == 'true'){
                              var successToast = $(document).Toasts('create', {
                                class: 'bg-success',
                                    title: 'Success!',
                                    autohide: true,
                                    delay: 2000,
                                    body: data['message']
                              });
                              window.location.reload();
                            } else {
                              var errorToast = $(document).Toasts('create', {
                                class: 'bg-danger',
                                    title: 'Oops!',
                                    autohide: true,
                                    delay: 2000,
                                    body: data['message']
                              });
                            }
                          }
                      });
                    });
                  }
              },
              no: {
                  text: 'No',
                  btnClass: 'btn-grey',
                  keys: ['enter', 'shift'],
                  action: function(){

                  }
              }
          }
      });
    });
  });


  $('.select2').select2({
      theme: 'bootstrap4'
  }).change(function(){
      $('#quickForm').valid();
  });
</script>

@endpush