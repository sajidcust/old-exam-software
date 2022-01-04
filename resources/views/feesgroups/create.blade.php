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
              <form id="quickForm" method="post" action="{{ route('feegroups.store') }}"enctype="multipart/form-data">
              	{{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                      <label for="labelInputFeeGroupName">Fee Group Name<i class="fa fa-star-of-life required-label"></i></i></label>
                      <input type="text" name="fee_group_name" class="form-control" id="labelInputFeeGroupName" placeholder="Enter fee group name" value="{{ Request::old('fee_group_name') }}">
                   </div>
                    <div class="form-group">
                      <label for="labelSelectClass">Select Class<i class="fa fa-star-of-life required-label"></i></label>
                      <select class="custom-select rounded-0 select2" id="labelSelectClass" name="class_id">
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
                      <label for="fee_id">Select Fee<i class="fa fa-star-of-life required-label select_input"></i></label>
                      <select class="custom-select rounded-0 select2" id="fee_id" name="fee_id[]" multiple="true">
                        @foreach($fees as $fee)
                          <option value="{{ $fee->id }}">{{ $fee->title }}</option>
                        @endforeach
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
        fee_group_name: {
          required: true
        },
        class_id: {
          required: true
        },
        "fee_id[]": {
          required: true,
          minlength: 1
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