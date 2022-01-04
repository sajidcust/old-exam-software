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
              <form id="quickForm" method="post" action="{{ route('classes.update') }}">
              	{{ csrf_field() }}
                <input id="hidden_identifier" type="hidden" value="{{ $standard->id }}" name="standard_id">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputClassName">Class Name<i class="fa fa-star-of-life required-label"></i></label>
                    <input type="text" name="name" class="form-control" id="labelInputClassName" placeholder="Enter class name" value="{{ $standard->name }}" value="{{ Request::old('name') != '' ? Request::old('name'):$standard->name }}">
                  </div>
                  <div class="form-group">
                    <label>Min Subjects To Be Selected<i class="fa fa-star-of-life required-label"></i></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                      </div>
                      <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="min_subjects" value="{{ Request::old('min_subjects')!='' ? Request::old('min_subjects'): $standard->min_subjects }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Min Age To Apply<i class="fa fa-star-of-life required-label"></i></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa fa-mobile-alt"></i></span>
                      </div>
                      <input type="number" class="form-control" data-inputmask="'mask': '9999'" data-mask="" inputmode="text" name="min_age" value="{{ Request::old('min_age')!='' ? Request::old('min_age'): $standard->min_age }}">
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
	      name: {
	        required: true,
	        minlength: 3,
	      },
        min_age: {
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