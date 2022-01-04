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
              <form id="quickForm" method="post" action="{{ route('subjects.store') }}">
              	{{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputSubjectName">Subject Name<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="text" name="name" class="form-control" id="labelInputSubjectName" placeholder="Enter subject name" value="{{ Request::old('name') }}">
                   </div>
                   <div class="form-group">
                    <label for="labelInputShortName">Short Name<i class="fa fa-star-of-life required-label"></i></i></label>
                    <input type="text" name="short_name" class="form-control" id="labelInputShortName" placeholder="Enter short name" value="{{ Request::old('short_name') }}">
                   </div>
                   <div class="form-group">
                    <label for="labelInputIsOptional">Is Optional<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0" id="labelInputIsOptional" name="is_optional">
                      <option value="1" {{ Request::old('is_optional') == 1 ? 'selected':'' }}>YES</option>
                      <option value="0" {{ Request::old('is_optional') == 0 ? 'selected':'' }}>NO</option>
                    </select>
                   </div>
                   <div class="form-group">
                    <label for="labelInputHasPractical">Has Practical<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0" id="labelInputHasPractical" name="has_practical">
                      <option value="1" {{ Request::old('has_practical') == 1 ? 'selected':'' }}>YES</option>
                      <option value="0" {{ Request::old('has_practical') == 0 ? 'selected':'' }}>NO</option>
                    </select>
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
        short_name: {
          required: true,
          minlength: 1,
        },
        is_optional: {
          required: true
        },
        has_practical: {
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