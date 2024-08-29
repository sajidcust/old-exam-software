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
                <div class="col-lg-12">
                  <h3 class="card-title custom-card-title">{{ $card_title }} (Students)</h3>
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
              <!-- form start -->
                <form id="quickForm" method="post" action="">
                  {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                    <input id="submitBtn" type="submit" class="btn btn-success" value="Import">

                    <?php $stds = App\Models\Student::all(); ?>

                    <?php 

                      Config::set("database.connections.sqlite", [
                          "driver" => "sqlite",
                          "url" => '',
                          "database" => database_path('db_imports\database.sqlite'),
                          "prefix" => '',
                          'foreign_key_constraints' => ''
                      ]);

                    ?>

                    <?php $stds_external = DB::connection('sqlite')->select("SELECT * FROM students;"); ?>

                    <p class="custom-pull-right">Total Records Internal: <span id="total_records">{{ count($stds) }}</span></p>
                    <p class="custom-pull-right">Total Records External: <span id="total_records">{{ count($stds_external) }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                  </div>
                </form>
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
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header row">
                <div class="col-lg-12">
                  <h3 class="card-title custom-card-title">{{ $card_title }} (Exams Data)</h3>
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

                <!-- form start -->
                <form id="quickForm2" method="post" action="">
                  {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
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
                    <input id="submitBtn2" type="submit" class="btn btn-success" value="Import">

                    <?php $stds_exams = App\Models\StudentsExam::all(); ?>

                    <?php 

                      Config::set("database.connections.sqlite", [
                          "driver" => "sqlite",
                          "url" => '',
                          "database" => database_path('db_imports\database.sqlite'),
                          "prefix" => '',
                          'foreign_key_constraints' => ''
                      ]);

                    ?>

                    <?php $stds_exams_external = DB::connection('sqlite')->select("SELECT * FROM students_exams;"); ?>

                    <p class="custom-pull-right">Total Records Internal: <span id="total_records">{{ count($stds_exams) }}</span></p>
                    <p class="custom-pull-right">Total Records External: <span id="total_records">{{ count($stds_exams_external) }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                  </div>
                </form>
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


  $('#quickForm').on('click', '#submitBtn', function(e){
    e.preventDefault();

    if($('#quickForm').valid()){

      var limit_records = $('#quickForm input[name="limit_records"]').val();
      var skip_records = $('#quickForm input[name="skip_records"]').val();
      var count_records = $('#quickForm #total_records').text();

      var url = "{{ route('importsexports.importstudents') }}";

      Pace.track(function(){
        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: url,
          data: {
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

              $('#quickForm input[name="skip_records"]').val(data['skip_records']);
              $('#quickForm input[name="limit_records"]').val(data['limit_records']);
              $('#quickForm #total_records').text(data['total_records']);

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

  $('#quickForm2').on('click', '#submitBtn2', function(e){
    e.preventDefault();

    if($('#quickForm2').valid()){

      var limit_records = $('#quickForm2 input[name="limit_records"]').val();
      var skip_records = $('#quickForm2 input[name="skip_records"]').val();
      var count_records = $('#quickForm2 #total_records').text();

      var url = "{{ route('importsexports.importexamdata') }}";

      Pace.track(function(){
        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: url,
          data: {
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

              $('#quickForm2 input[name="skip_records"]').val(data['skip_records']);
              $('#quickForm2 input[name="limit_records"]').val(data['limit_records']);
              $('#quickForm2 #total_records').text(data['total_records']);

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

  var validatevar = $('#quickForm2').validate({
      rules: {
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