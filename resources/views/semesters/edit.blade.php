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
              <form id="quickForm" method="post" action="{{ route('semesters.update') }}">
              	{{ csrf_field() }}
                <input id="hidden_identifier" type="hidden" value="{{ $semester->id }}" name="semester_id">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputSemesterTitle">Semester Title<i class="fa fa-star-of-life required-label"></i></label>
                    <input type="text" name="title" class="form-control" id="labelInputSemesterTitle" placeholder="Enter semester title" value="{{ $semester->title }}" value="{{ Request::old('title') != '' ? Request::old('title'):$semester->title }}">
                  </div>
                  <div class="form-group">
                    <label for="labelInputSelectSession">Select Session<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0 select2" id="labelInputSelectSession" name="session_id">
                      <option value="">Select Session</option> 
                      @foreach($sessions as $session)
                          @if(Request::old('session_id') == '')
                              @if($session->id == $semester->session_id)
                                  <option selected value="{{ $session->id }}">{{ $session->title }}</option>
                              @else
                                  <option value="{{ $session->id }}">{{ $session->title }}</option>
                              @endif
                          @else
                              @if($session->id == Request::old('session_id'))
                                  <option selected value="{{ $session->id }}">{{ $session->title }}</option>
                              @else
                                  <option value="{{ $session->id }}">{{ $session->title }}</option>
                              @endif
                          @endif
                      @endforeach
                    </select>
                   </div>
                   <div class="form-group">
                    <label>Division Percentage<i class="fa fa-star-of-life required-label"></i></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                      </div>
                      <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="division_percentage" value="{{ Request::old('division_percentage') != '' ? Request::old('division_percentage') : $semester->division_percentage }}">
                    </div>
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
	var validatevar = $('#quickForm').validate({
	    rules: {
	      title: {
	        required: true,
	        minlength: 3,
	      },
        session_id: {
          required:true
        },
        division_percentage: {
          required: true,
          number: true
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