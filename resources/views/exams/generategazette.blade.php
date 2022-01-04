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
              <div class="card-header">
                <h3 class="card-title">{{ $card_title }} complete with graphs</small></h3>
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
              <form id="quickForm_complete" method="post" action="{{ route('exams.generatecompletegazette') }}">
                {{ csrf_field() }}
                <div style="padding-left:20px;padding-right: 20px;">
                  <br>    
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="labelInputSelectSessionComplete">Select Session<i class="fa fa-star-of-life required-label"></i></label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectSessionComplete" name="session_id">
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
                    <div class="col-lg-6">
                      <div class="form-group">
                          <label for="labelInputSelectClassComplete">Select Class<i class="fa fa-star-of-life required-label"></i></label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectClassComplete" name="class_id">
                              <option value="">Select Class</option> 
                              @foreach($standards as $standard)
                                  @if($standard->id == Request::old('class_id'))
                                      <option selected value="{{ $standard->id }}">{{ $standard->name }}</option>
                                  @else
                                      <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                  @endif
                              @endforeach
                          </select>
                       </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
                  </div>
                </div>
              </form>
              <br>
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
  $('#quickForm_genbulk select[name="session_id"]').on('change', function(){
    var session_id = $(this).val();

    $('select[name="semester_id"]').select2({
      ajax: {
        url: "{{ route('datesheets.getsemesters') }}",
        dataType: 'json',
        "type" : "POST",
        data: function (params) {
            return {
              _token: '{{ csrf_token() }}',
              session_id:session_id,
              search: params.term // search term
            };
          },
          beforeSend: function()
          {
            Pace.start();
          },
          complete: function() {
            Pace.stop();
          },
          processResults: function (response) {
            console.log(response);
            return {
              results: response
            };
          },
          cache: true
      }
    });
    
  });

  var validate_quickForm_genbulk = $('#quickForm_genbulk').validate({
      rules: {
        session_id: {
          required: true
        },
        semester_id: {
          required: true
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

  $('#quickForm_genbulk .select2').select2({
      theme: 'bootstrap4'
  }).change(function(){
      $('#quickForm_genbulk').valid();
  });


  var validate_quickForm_combined = $('#quickForm_combined').validate({
      rules: {
        session_id: {
          required: true
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

  $('#quickForm_combined .select2').select2({
      theme: 'bootstrap4'
  }).change(function(){
      $('#quickForm_combined').valid();
  });


  var validate_quickForm_complete = $('#quickForm_complete').validate({
      rules: {
        session_id: {
          required: true
        },
        class_id: {
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

  $('#quickForm_complete .select2').select2({
      theme: 'bootstrap4'
  }).change(function(){
      $('#quickForm_complete').valid();
  });

</script>

@endpush