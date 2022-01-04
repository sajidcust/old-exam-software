@extends('layouts.sub')


@section('content')
	<div class="card">
      @if(Session::has('message'))
        <div class="alert alert-info alert-dismissible font-size-12px">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <p class="error-title-styling"><i class="icon fas fa-check"></i> Message!</p>
          <hr class="error-hr">
          {{ Session::get('message') }}
        </div>
        @endif 

      @if($errors->has('message'))
        <div class="alert alert-danger alert-dismissible font-size-12px">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <p class="error-title-styling"><i class="icon fas fa-ban"></i> Error!</p>
          <hr class="error-hr">
          {{ $errors->first('message') }}
        </div>
        @endif 
      <div class="card-body login-card-body">
        <p class="login-box-msg">Enter your email to proceed</p>

        <form id="quickForm" action="{{ route('users.verifyemail') }}" method="post">
          {{ csrf_field() }}
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ Request::old('email') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Continue</button>
            </div>
            <!-- /.col -->
          </div>

        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
@stop

@push('scripts')
<script>
  var validatevar = $('#quickForm').validate({
      rules: {
        email: {
          required: true,
          email: true
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
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