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
                  <button id="add_btn" class="btn btn-info custom-pull-right margin-left-right-5px"><span class="fa fa-random"></span>&nbsp;&nbsp;Set Data</button>
                  <button id="reset_btn" class="btn btn-danger custom-pull-right margin-left-right-5px"><span class="fa fa-redo-alt"></span>&nbsp;&nbsp;Reset Data</button>
                </div>
              </div>
              <!-- /.card-header -->
                @if($errors->any())
                <div class="">
                  <div class="alert alert-danger" role="alert">The following errors have occured:<br>
                     @foreach($errors->all() as $error)
                        <li>{{ $error }} </li>
                     @endforeach
                  </div>
                </div>
              @endif

              <?php 

                Config::set("database.connections.sqlite", [
                    "driver" => "sqlite",
                    "url" => '',
                    "database" => database_path('database.sqlite'),
                    "prefix" => '',
                    'foreign_key_constraints' => ''
                ]);

              ?>

              <?php $ins = DB::connection('sqlite')->select("SELECT * FROM institutions;"); ?>
              <!-- form start -->
              @if(count($ins) > 0)
                <form id="quickForm" method="post" action="{{ route('banks.store') }}">
                  {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                            <label for="labelInputSelectSession">Select Session</label>
                            <select class="custom-select rounded-0 select2" id="labelInputSelectSession" name="session_id">
                                <option value="">Select Session</option> 
                                @foreach($sessions as $session)
                                    @if($session->id == Request::old('session_id'))
                                        <option selected value="{{ $session->id }}">{{ $session->title }}</option>
                                    @else
                                        <option value="{{ $session->id }}">{{ $session->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                         </div>
                        </div>
                        <div class="col-lg-3">
                        <div class="form-group">
                            <label for="labelInputSelectDistrict">Select District</label>
                            <select class="custom-select rounded-0 select2" id="labelInputSelectDistrict" name="district_id">
                                <option value="">Select District</option> 
                                @foreach($districts as $district)
                                    @if($district->id == Request::old('district_id'))
                                        <option selected value="{{ $district->id }}">{{ $district->name }}&nbsp;&nbsp;&nbsp;({{ $district->getTotalStudents($district->id) }})</option>
                                    @else
                                        <option value="{{ $district->id }}">{{ $district->name }}&nbsp;&nbsp;&nbsp;({{ $district->getTotalStudents($district->id) }})</option>
                                    @endif
                                @endforeach
                            </select>
                         </div>
                        </div>
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label>Skip Records<i class="fa fa-star-of-life required-label"></i></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                              </div>
                              <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="skip_records" value="{{ Request::old('skip_records') }}">
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <div class="form-group">
                            <label>Limit Records<i class="fa fa-star-of-life required-label"></i></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                              </div>
                              <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="limit_records" value="{{ Request::old('limit_records') }}">
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                    <button type="button" id="reset_btn_stds" class="btn btn-danger">Reset</button>
                    <?php $stds = DB::connection('sqlite')->select("SELECT * FROM students;"); ?>

                    <h4 class="custom-pull-right">Total Records: <span id="total_records">{{ count($stds) }}</span></h4>
                  </div>
                </form>
              @endif
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header row">
                <div class="col-lg-12">
                  <h3 class="card-title custom-card-title">Exported Records Shown here.</h3>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="buttons_container">
                  <table id="manageDatatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Roll No</th>
                      <th>Name</th>
                      <th>Father Name</th>
                      <th>District</th>
                      <th>Class</th>
                      <th>Institution</th>
                      <th>Center</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                  </table>
               </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal" id="modal-danger" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Are you sure?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer">
          <button type="button" id="yes-btn" class="btn btn-danger">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>

@stop


@push('scripts')
<script>

  $(document).ready(function(){
    $('body').on('click', '#dlt_button', function (){
      id = $(this).data('districtid');
      url = $(this).data('url');

      $.confirm({
          title: 'Are you sure?',
          content: 'Simple confirm!',
          buttons: {
              yes: {
                  text: 'Yes',
                  btnClass: 'btn-red',
                  keys: ['enter', 'shift'],
                  action: function(){
                      $.ajax({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                        type: "POST",
                        url: url,
                        data: {id:id},

                        beforeSend: function()
                        {
                          $('#modal-danger').modal('hide');
                          Pace.start();
                        },
                        complete: function() {
                          Pace.stop();
                          $('#modal-danger').modal('hide');
                        },
                        success: function(data)
                        {
                          if(data['success'] == 'true'){

                            $('input[name="skip_records"]').val(data['total_students']);
                            $('#total_records').text(data['total_students']);

                            var oTable = $('#manageDatatable').dataTable(); 
                            oTable.fnDraw(false);

                            var successToast = $(document).Toasts('create', {
                              class: 'bg-success',
                                  title: 'Success!',
                                  autohide: true,
                                  delay: 2000,
                                  body: data['message']
                            });
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

    $(document).ready(function() {
        $('#manageDatatable').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
              url: "{{ route('importsexports.getexporteddata') }}",
            },
            columns:[
              {
                data: 'id',
                name: 'id'
              },
              {
                data: 'name',
                name: 'name'
              },
              {
                data: 'father_name',
                name: 'father_name'
              },
              {
                data: 'district_name',
                name: 'district_name'
              },
              {
                data: 'class_name',
                name: 'class_name'
              },
              {
                data: 'institution_name',
                name: 'institution_name'
              },
              {
                data: 'center_name',
                name: 'center_name'
              },
              {
                data: 'action',
                name: 'action',
                orderable:false
              }
            ],
            "order": [[ 0, "desc" ]]
        });
    });

  $(document).ready(function(){
    $('body').on('click', '#reset_btn_stds', function (){
      url = "{{ route('importsexports.resetstudents') }}";

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
    $('body').on('click', '#reset_btn', function (){
      url = "{{ route('importsexports.reset') }}";

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
      url = "{{ route('importsexports.set') }}";

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

  $('#quickForm').on('click', '#submitBtn', function(e){
    e.preventDefault();

    if($('#quickForm').valid()){

      var session_id = $('select[name="session_id"]').val();
      var district_id = $('select[name="district_id"]').val();
      var limit_records = $('input[name="limit_records"]').val();
      var skip_records = $('input[name="skip_records"]').val();
      var count_records = $('#total_records').text();

      var url = "{{ route('importsexports.exportstudents') }}";

      Pace.track(function(){
        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: url,
          data: {
              session_id:session_id,
              district_id:district_id,
              limit_records:limit_records,
              skip_records:skip_records,
              count_records:count_records
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

              var oTable = $('#manageDatatable').dataTable(); 
              oTable.fnDraw(false);

              $('input[name="skip_records"]').val(data['skip_records']);
              $('input[name="limit_records"]').val(data['limit_records']);
              $('#total_records').text(data['total_records']);

              var successToast = $(document).Toasts('create', {
                class: 'bg-success',
                    title: 'Success!',
                    autohide: true,
                    delay: 2000,
                    body: data['message']
              });
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

  });

  var validatevar = $('#quickForm').validate({
      rules: {
        session_id: {
          required: true
        },
        limit_records: {
          required: true,
          integer: true
        },
        skip_records: {
          required: true,
          integer: true
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
</script>

@endpush