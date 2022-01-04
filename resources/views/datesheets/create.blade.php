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
                <h3 class="card-title">{{ $card_title }}</small></h3>
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
              <form id="quickForm" method="post" action="{{ route('datesheets.store') }}">
              	{{ csrf_field() }}
                <div class="card-body">
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
                   <div class="form-group">
                      <label for="labelInputSelectSemester">Select Semester</label>
                      <select class="custom-select rounded-0 select2" id="labelInputSelectSemester" name="semester_id">
                          <option selected value="">Select Semester</option>
                      </select>
                   </div>
                   <div class="form-group">
                      <label for="labelInputSelectSubject">Select Subject</label>
                      <select class="custom-select rounded-0 select2" id="labelInputSelectSubject" name="subject_id">
                          <option value="">Select Subject</option> 
                          @foreach($subjects as $subject)
                              @if($subject->id == Request::old('subject_id'))
                                  <option selected value="{{ $subject->id }}">{{ $subject->name }}</option>
                              @else
                                  <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                              @endif
                          @endforeach
                      </select>
                   </div>
                   <div class="form-group">
                      <label for="labelInputSelectClass">Select Class</label>
                      <select class="custom-select rounded-0 select2" id="labelInputSelectClass" name="class_id">
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
                   <div class="form-group">
                      <label>Date<i class="fa fa-star-of-life required-label"></i></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input id="datemask" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" inputmode="numeric" name="paper_date" value="{{ Request::old('paper_date') }}">
                      </div>
                    </div>
                   <div class="form-group">
                    <label>Starting Time:</label>

                    <div class="input-group date" id="paper_starting_time" data-target-input="nearest">
                      <div class="input-group-append" data-target="#paper_starting_time" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                      <input type="text" class="form-control datetimepicker-input" data-target="#paper_starting_time" name="paper_starting_time" data-inputmask-alias="datetime" data-inputmask-inputformat="HH:MM TT" data-mask="" inputmode="numeric" value="{{ Request::old('paper_starting_time') }}">
                      </div>
                    <!-- /.input group -->
                  </div>
                  <div class="form-group">
                    <label>Ending Time:</label>

                    <div class="input-group date" id="paper_ending_time" data-target-input="nearest">
                      <div class="input-group-append" data-target="#paper_ending_time" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                      <input type="text" class="form-control datetimepicker-input" data-target="#paper_ending_time" data-target="#paper_starting_time" name="paper_ending_time" data-inputmask-alias="datetime" data-inputmask-inputformat="HH:MM TT" data-mask="" inputmode="numeric" name="paper_ending_time" value="{{ Request::old('paper_ending_time') }}">
                      </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input id="submitBtn" type="submit" class="btn btn-success" value="Submit">
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

  $('#quickForm select[name="session_id"]').on('change', function(){
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

  $('#paper_starting_time').datetimepicker({
    format: 'LT'
  });

  $('#paper_ending_time').datetimepicker({
    format: 'LT'
  });

  $('input[name="paper_date"]').datepicker({
    format: 'dd-mm-yyyy'
  });

  $('[data-mask]').inputmask();

	var validatevar = $('#quickForm').validate({
      rules: {
        session_id: {
          required: true
        },
        semester_id: {
          required: true
        },
        subject_id: {
          required: true
        },
        class_id: {
          required: true
        },
        paper_date: {
          required: true
        },
        paper_starting_time: {
          required: true
        },
        paper_ending_time: {
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

  $('.select2').select2({
      theme: 'bootstrap4'
  }).change(function(){
      $('#quickForm').valid();
  });
</script>

@endpush