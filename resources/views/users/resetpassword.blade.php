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
        <p class="login-box-msg">Please enter your new password</p>

        <form id="quickForm" action="{{ route('users.setnewpassword') }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="email" value="{{ $email }}">
          <div class="input-group mb-3">
            <input type="password" id="password" class="form-control" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Retype password" name="confirm_password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Continue</button>
          </div>
          <!-- /.col -->

        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
@stop

@push('scripts')
<script>
  $.validator.addMethod("pwcheck", function(value) {
     return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
         && /[a-z]/.test(value) // has a lowercase letter
         && /\d/.test(value) // has a digit
  }, "This field must contain a a number as well. e.g 'password123'");

  var validatevar = $('#quickForm').validate({
      rules: {
        password: {
          required:true,
          minlength:8,
          pwcheck:true
        },
        confirm_password:{
          required:true,
          minlength:8,
          equalTo:'#password'
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