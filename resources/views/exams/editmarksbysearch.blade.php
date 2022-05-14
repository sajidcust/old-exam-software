@extends('layouts.main')


@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      @if (Session::has('message'))
          <div class="callout callout-success" role="alert">{{ Session::get('message') }}</div>
      @endif
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
              <form id="quickForm_genbulk" method="get" action="{{ route('exams.index') }}">
                {{ csrf_field() }}
                <div style="padding-left:20px;padding-right: 20px;">
                  <br>    
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                          <label for="labelInputSelectSession">Select Session<i class="fa fa-star-of-life required-label"></i></label>
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
                    <div class="col-lg-4">
                      <div class="form-group">
                          <label for="labelInputSelectClass">Select Class<i class="fa fa-star-of-life required-label"></i></label>
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
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                          <label for="labelInputSelectCenter">Select Center<i class="fa fa-star-of-life required-label"></i></label>
                          <select class="custom-select rounded-0 select2" id="labelInputSelectCenter" name="center_id">
                              <option value="">Select Center</option> 
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

  var validatevar = $('#quickForm_genbulk').validate({
      rules: {
        session_id: {
          required: true
        },
        center_id: {
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

  $('.select2').select2({
      theme: 'bootstrap4'
  }).change(function(){
      $('#quickForm_genbulk').valid();
  });
</script>

@endpush