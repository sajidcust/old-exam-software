@extends('layouts.sub')


@section('content')
	<div class="card">
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible font-size-12px">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <p class="error-title-styling"><i class="icon fas fa-ban"></i> Error!</p>
          <hr class="error-hr">
          @foreach($errors->all() as $error)
            <li>{{ $error }} </li>
          @endforeach
        </div>
        @endif 
      <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form id="quickForm" action="{{ route('users.storeuser') }}" method="post">
        {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="name" value="{{ Request::old('name') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select class="form-control" name="district_id">
            <option value="">Select a district</option> 
            @foreach($districts as $district)
              @if($district->id == Request::old('district_id'))
                  <option selected value="{{ $district->id }}">{{ $district->district_name }}</option>
              @else
                  <option value="{{ $district->id }}">{{ $district->district_name }}</option>
              @endif
            @endforeach
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-cheese"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" value="{{ Request::old('email') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
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
        <div class="row">
          <div class="col-8">
            <div class="input-group">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                 I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <br>
      <a href="{{ url('users/login') }}" class="text-center">I already have a membership</a>
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
        name:{
          required:true,
          minlength:3
        },
        district_id:{
          required:true
        },
        email: {
          required: true,
          email: true
        },
        password: {
          required:true,
          minlength:8,
          pwcheck:true
        },
        confirm_password:{
          required:true,
          minlength:8,
          equalTo:'#password'
        },
        terms:{
          required:true
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