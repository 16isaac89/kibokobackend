<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Amanda">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/amanda/img/amanda-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/amanda">
    <meta property="og:title" content="Bracket">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/amanda/img/amanda-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/amanda/img/amanda-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">


    <title>EFDS EXQUISITE DIGITAL SYSTEMS</title>

    <!-- vendor css -->
    <link href="{{asset('subd/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('subd/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('subd/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="{{asset('subd/css/amanda.css')}}">
  </head>

  <body>

    <div class="am-signin-wrapper">
      <div class="am-signin-box">
        <div class="row no-gutters">
          <div class="col-lg-5">
            <div>
               <div class="card-header bg-primary text-white text-center py-4" style="border-bottom: none;">
            <img src="{{ asset('/images/logo/kiboko.jpg') }}" alt="Kiboko Enterprises" class="img-fluid mb-3" style="max-height: 80px;">
            <h3 class="mb-0">Welcome Back</h3>
            <p class="mb-0 text-white-50">Sign in to your account</p>
        </div>
              {{-- <p>The Responsive Bootstrap 4 Admin Template</p>
              <p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate.</p>

              <hr>
              <p>Don't have an account? <br> <a href="page-signup.html">Sign up Now</a></p> --}}
            </div>
          </div>
          <div class="col-lg-7">
            <h5 class="tx-gray-800 mg-b-25">Signin to Your Account</h5>
            @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<form method="post" action="{{route('dealer.login.post')}}">
    @csrf
            <div class="form-group">
              <label class="form-control-label">User Name:</label>
              <input type="text" name="username" class="form-control" placeholder="Enter your user name">
            </div><!-- form-group -->

            <div class="form-group">
              <label class="form-control-label">Password:</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password">
            </div><!-- form-group -->

            <div class="form-group mg-b-20"><a href="">Reset password</a></div>

           <button type="submit" id="loginButton" class="btn btn-block btn-primary">
  <span id="loginButtonText">Sign In</span>
  <span id="loginButtonSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
</button>


</form>
          </div><!-- col-7 -->
        </div><!-- row -->
        <p class="tx-center tx-white-5 tx-12 mg-t-15">Copyright &copy; 2017. All Rights Reserved. EFDS by EXD SYSTEMS</p>
      </div><!-- signin-box -->
    </div><!-- am-signin-wrapper -->

    <script src="{{asset('subd/lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('subd/lib/bootstrap/bootstrap.js')}}"></script>



    <script>
  $(document).ready(function () {
    $('form').on('submit', function () {
      $('#loginButton').attr('disabled', true);
      $('#loginButtonText').addClass('d-none');
      $('#loginButtonSpinner').removeClass('d-none');
    });
  });
</script>

  </body>
</html>
