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
              <form id="quickForm" method="post" action="{{ route('tehsils.update') }}">
              	{{ csrf_field() }}
                <input id="hidden_identifier" type="hidden" value="{{ $tehsil->id }}" name="tehsil_id">
                <div class="card-body">
                  <div class="form-group">
                    <label for="labelInputTehsilName">Tehsil Name<i class="fa fa-star-of-life required-label"></i></label>
                    <input type="text" name="name" class="form-control" id="labelInputTehsilName" placeholder="Enter tehsil name" value="{{ $tehsil->name }}" value="{{ Request::old('name') != '' ? Request::old('name'):$tehsil->name }}">
                  </div>
                  <div class="form-group">
                    <label for="labelInputDistrict">District<i class="fa fa-star-of-life required-label"></i></label>
                    <select class="custom-select rounded-0 select2" id="labelInputDistrict" name="district_id">
                      <option value="">Select a district</option> 
                      @foreach($districts as $district)
                          @if(Request::old('district_id') == '')
                              @if($district->id == $tehsil->district_id)
                                  <option selected value="{{ $district->id }}">{{ $district->name }}</option>
                              @else
                                  <option value="{{ $district->id }}">{{ $district->name }}</option>
                              @endif
                          @else
                              @if($district->id == Request::old('district_id'))
                                  <option selected value="{{ $district->id }}">{{ $district->name }}</option>
                              @else
                                  <option value="{{ $district->id }}">{{ $district->name }}</option>
                              @endif
                          @endif
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
	      name: {
	        required: true,
	        minlength: 3,
	      },
        district_id: {
          required:true
        }
	    },
	    messages: {
	      name: {
	        required: "This field is required.",
	        minlength: "Please enter at least 3 characters in tis field."
	      },
        district_id: {
          required: "This field is required"
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