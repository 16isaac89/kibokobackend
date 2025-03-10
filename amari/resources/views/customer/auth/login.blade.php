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
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
				<form class="login100-form validate-form" method="POST" action="{{route('customer.login.post')}}">
                    @csrf
					<span class="login100-form-logo">
						<img alt="" src="../../assets/img/taxi.png">
					</span>
					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>
					<div class="wrap-input100 validate-input" data-validate="Enter email address">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					<div class="text-center p-t-50">
						<a class="txt1" href="forgot_password.html">
							Forgot Password?
						</a>
                        <a href="{{route('customer.register')}}" style="margin-left:30px;" class="txt1" href="forgot_password.html">
							Don't Have Account Register
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
