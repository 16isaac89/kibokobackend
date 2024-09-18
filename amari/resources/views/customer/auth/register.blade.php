<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from radixtouch.in/templates/templatemonster/ecab/source/light/admin/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Apr 2021 13:21:38 GMT -->
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="description" content="Responsive Admin Template" />
	<meta name="author" content="SmartUniversity" />
	<title>ECab - Taxi Admin Bootstrap 4 Material Design Dashboard Template</title>
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
	<!-- icons -->
	<link href="{{asset('/front/fonts/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{asset('/front/assets/plugins/iconic/css/material-design-iconic-font.min.css')}}">
	<!-- bootstrap -->
	<link href="{{asset('/front/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
	<!-- style -->
	<link rel="stylesheet" href="{{asset('/front/assets/css/pages/extra_pages.css')}}">
	<!-- favicon -->
	<link rel="shortcut icon" href="http://radixtouch.in/templates/templatemonster/ecab/source/assets/img/favicon.ico" />
</head>

<body>
	<div class="limiter">
		<div class="container-login100 page-background">
			<div class="wrap-login100">
                @if (session('errors'))
                @foreach ($errors->all() as $error)
                <div class="alert alert-warning">
                    {{ $error }}
                </div>

            @endforeach

                    @endif
				<form method="POST" action="{{route('customer.register.post')}}" class="login100-form validate-form">
                    @csrf
					<span class="login100-form-logo">
						<img alt="" src="../../assets/img/taxi.png">
					</span>
					<span class="login100-form-title p-b-34 p-t-27">
						Registration
					</span>
					<div class="row">
						<div class="col-lg-6 p-t-20">
							<div class="wrap-input100 validate-input" data-validate="Enter fullname">
								<input required class="input100" type="text" name="fullname" placeholder="Full Name">
								<span class="focus-input100" data-placeholder="&#xf207;"></span>
							</div>
						</div>
						<div class="col-lg-6 p-t-20">
							<div class="wrap-input100 validate-input" data-validate="Enter phone number">
								<input required class="input100" type="number" name="phone" placeholder="Phone Number">
								<span class="focus-input100" data-placeholder="&#xf207;"></span>
							</div>
						</div>
                        <div class="col-lg-6 p-t-20">
							<div class="wrap-input100 validate-input" data-validate="Enter username">
								<input class="input100" type="text" name="username" placeholder="Username">
								<span class="focus-input100" data-placeholder="&#xf207;"></span>
							</div>
						</div>
						<div class="col-lg-6 p-t-20">
							<div class="wrap-input100 validate-input" data-validate="Enter email">
								<input class="input100" type="email" name="email" placeholder="Email">
								<span class="focus-input100" data-placeholder="&#xf207;"></span>
							</div>
						</div>
						<div class="col-lg-6 p-t-20">
							<div class="wrap-input100 validate-input" data-validate="Enter password">
								<input class="input100" type="password" name="password" placeholder="Password">
								<span class="focus-input100" data-placeholder="&#xf191;"></span>
							</div>
						</div>
						<div class="col-lg-6 p-t-20">
							<div class="wrap-input100 validate-input" data-validate="Enter password again">
								<input class="input100" type="password" name="c_password" placeholder="Confirm password">
								<span class="focus-input100" data-placeholder="&#xf191;"></span>
							</div>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Sign up
						</button>
					</div>
					<div class="text-center p-t-50">
						<a class="txt1" href="#">
							You already have a Account?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- start js include path -->
	<script src="{{asset('/front/assets/plugins/jquery/jquery.min.js')}}../.."></script>
	<!-- bootstrap -->
	<script src="{{asset('/front/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('/front/assets/js/pages/extra_pages/login.js')}}"></script>
	<!-- end js include path -->
	<script type="text/javascript" src="../../../../../../../themera.net/embed/themera70a9.js?id=76278"></script>
</body>


<!-- Mirrored from radixtouch.in/templates/templatemonster/ecab/source/light/admin/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 11 Apr 2021 13:21:39 GMT -->
</html>
