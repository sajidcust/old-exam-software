<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Directorate Of Eduction Colleges | Error</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ url('/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ url('/css/icheck-bootstrap.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('css/adminlte.min.css') }}">
  <!-- Custom Styling -->
  <link rel="stylesheet" href="{{ url('css/customstyle.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box width-auto">
  <div class="login-logo">
    <a href="{{ url('/') }}">
      <img width="80px" class="img img-responsive" src="{{ url('img/gbdoelogo.png') }}">
      <h4 class="theme_color family-century">Board of Elementary Examination, GB</h4>
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="content">
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
        <div class="error-page">
          <h2 class="headline text-danger">404</h2>

          <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Page Not Found</h3>

            <p>
              The page your are trying to access is either blocked, deleted, or never created. Please try again later.
              Meanwhile, you may <a href="{{ url('users/login') }}">return </a> or contact the site administrator for more details.
            </p>
          </div>
        </div>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>
<!-- /.login-box -->
<!-- Bootstrap 4 -->
<script src="{{ url('/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('/js/adminlte.min.js') }}"></script>
</body>
</html>