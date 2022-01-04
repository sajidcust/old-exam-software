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
                      <div class="col-lg-6">
                        <div class="form-group">
                            <label for="labelInputSelectDistrict">Select Session</label>
                            <select class="custom-select rounded-0 select2" id="labelInputSelectDistrict" name="session_id">
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

@stop


@push('scripts')
<script>

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
                                  body: '<span id="loading_toast">Please wait until the success message appears</span>'
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
                  body: '<span id="loading_toast">Please wait until the success message appears</span>'
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