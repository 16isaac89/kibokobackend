<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Gostart - Startup Landing Page Template">

    <!-- ========== Page Title ========== -->
    <title>EFDS - Electronic Field Management System</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{ asset('front/landing/assets/img/favicon.png')}}" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link href="{{ asset('front/landing/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/themify-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/flaticon-set.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/magnific-popup.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/animate.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/assets/css/bootsnav.css')}}" rel="stylesheet" />
    <link href="{{ asset('front/landing/style.css')}}" rel="stylesheet">
    <link href="{{ asset('front/landing/assets/css/responsive.css')}}" rel="stylesheet" />
    <!-- ========== End Stylesheet ========== -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5/html5shiv.min.js"></script>
      <script src="assets/js/html5/respond.min.js"></script>
    <![endif]-->

    <!-- ========== Google Fonts ========== -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
<style>
    #toast-container {
    position: sticky;
    z-index: 1055;
    top: 0
}

#toast-wrapper {
    position: absolute;
    top: 0;
    right: 0;
    margin: 5px
}

#toast-container > #toast-wrapper > .toast {
    min-width: 150px
}

#toast-container > #toast-wrapper > .toast >.toast-header strong {
    padding-right: 20px
}
</style>
</head>

<body>

    <!-- Preloader Start -->
    <div class="se-pre-con"></div>
    <!-- Preloader Ends -->

    <!-- Header
    ============================================= -->
    <header id="home">

        <!-- Start Navigation -->
        <nav class="navbar navbar-default navbar-fixed white no-background bootsnav">

            <div class="container-full">

                <!-- Start Atribute Navigation -->
                <div class="attr-nav button fixed-nav">
                    <ul>
                        <li>
                            <a href="{{route('dealer.login.view')}}">Login</a>
                        </li>
                        {{-- <li>
                            <a href="#">Sign Up</a>
                        </li> --}}
                    </ul>
                </div>
                <!-- End Atribute Navigation -->

                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.html">
                        <img src="{{ asset('front/landing/assets/img/logo-light.png')}}" class="logo logo-display" alt="Logo">
                        <img src="{{ asset('front/landing/assets/img/logo.png')}}" class="logo logo-scrolled" alt="Logo">
                    </a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-center" data-in="#" data-out="#">
                        <li class="dropdown active dropdown-right">
                            <a href="#home" class="dropdown-toggle smooth-menu" data-toggle="dropdown" >Home</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#features">Features</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#about">About</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#overview">Overview</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#pricing">Pricing</a>
                        </li>

                        <li>
                            <a class="smooth-menu" href="#contact">contact</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
        <!-- End Navigation -->

    </header>
    <!-- End Header -->

    <!-- Start Banner
    ============================================= -->
    <div class="banner-area bottom-shape bg-gradient-dark video-info">
        <div class="container">
            <div class="row">
                <div class="double-items text-light">
                    <div class="info col-md-7">
                        <h4 class="wow slideInLeft">Electronic Field Management System</h4>
                        <p class="wow fadeInLeft">
                            This system allows businesses to efficiently track inventory, monitor shipments, and coordinate the
                             movement of goods. Field agents can use the mobile app to access real-time information, update
                             inventory levels, and receive task assignments on the go
                        </p>
                        <a class="wow fadeInDown btn btn-light border btn-md" href="#">Learn more</a>
                        <a href="https://www.youtube.com/watch?v=owhuBrGIOsE" class="popup-youtube light video-play-button video-inline">
                            <i class="fa fa-play"></i>
                        </a>
                    </div>
                    <!-- Banner thumb -->
                    <div class="thumb col-md-5">
                        <img src="{{ asset('front/landing/assets/img/illustrations/1.png')}}" alt="thumb">
                    </div>
                    <!-- End thumb -->
                </div>
            </div>
        </div>
        <!-- Shape -->
        <div class="shape">
            <img src="{{ asset('front/landing/assets/img/shape/3.svg')}}" alt="thumb">
        </div>
        <!-- Shape -->
    </div>
    <!-- End Banner -->



    <!-- Start Our About
    ============================================= -->
    <div id="about" class="about-area bg-gray inc-thumb default-padding">
        <div class="container">
            <div class="row">
                <!-- Start About Content -->
                <div class="about-content">
                    <div class="col-md-12 info">
                        <div class="content-info">
                            <div class="row">
                                <div class="col-md-6 thumb-left wow slideInUp" data-wow-delay="400ms">
                                    <img src="{{ asset('images/about.png')}}" alt="Thumb" style="height:500px;">
                                </div>
                                <div class="col-md-6 left-info wow fadeInLeft">
                                    <h4>About The System</h4>
                                    <h2>Electronic Field Management System</h2>
                                    <p>
                                        This system allows businesses to efficiently track inventory, monitor shipments, and coordinate the movement of goods. Field agents can use the mobile app to access real-time information, update inventory levels, and receive task assignments on the go, ensuring a seamless and responsive distribution process. This technology enhances operational efficiency, reduces errors, and improves communication between the central hub and field teams, ultimately leading to a more agile and effective distribution network.
                                    </p>
                                    <ul>
                                        <li>Manage Inventory</li>
                                        <li>Manage Vans and Field Agents.</li>
                                        <li>Manage Sales</li>
                                        <li>Efris Integrated for Ugandan Businesses</li>
                                        <li>Many More Features</li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End About -->

            </div>
        </div>
    </div>
    <!-- End Our About -->

    <!-- Start Work Process
    ============================================= -->
    <div id="overview" class="work-pro-area default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">

                        <h2> <strong>Features</strong></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="work-pro-items">
                        <!-- Single Iitem -->
                        <div class="single-item wow fadeInUp">
                            <div class="row">
                                <div class="col-md-6 thumb">
                                    <img src="{{ asset('front/landing/assets/img/illustrations/7.svg')}}" alt="Thumb">
                                </div>
                                <div class="col-md-6 info">
                                    <h3>Optimization</h3>
                                    <p>
                                        In summary,EFDs empowers
                                        distributors to streamline their operations, reduce costs, enhance customer service, and
                                        adapt to changing market conditions. By leveraging technology to improve efficiency and
                                        decision-making, distributors can better achieve their business goals, whether it's
                                        increasing revenue, improving customer satisfaction, or expanding their market presence.
                                    </p>
                                    <ul>
                                        <li>
                                            <h5>Real-time Inventory Management:</h5>
                                            The system provides distributors with up-to-the-minute visibility into their inventory levels. This helps in reducing overstock or understock situations, minimizing carrying costs, and ensuring that products are always available to meet customer demand.
                                        </li>
                                        <li>
                                            <h5>Route Optimization</h5>
                                            The DMS can optimize delivery routes, helping field agents to reach their destinations more efficiently. This reduces fuel costs, minimizes delivery times, and improves overall delivery performance.
                                        </li>
                                        <li>
                                            <h5>Data Analytics</h5>
                                            The system collects valuable data on sales, inventory, and distribution operations. Distributors can use this data for analytics and reporting, enabling them to make informed decisions, identify trends, and improve their overall business strategies.
                                        </li>
                                        <li>
                                            <h5>Data Analytics</h5>
                                            The system collects valuable data on sales, inventory, and distribution operations. Distributors can use this data for analytics and reporting, enabling them to make informed decisions, identify trends, and improve their overall business strategies.
                                        </li>
                                        <li>
                                            <h5>Compliance and Reporting</h5>
                                        systems can help distributors comply with industry regulations and reporting requirements. This reduces the risk of fines or penalties and ensures that the business operates within legal boundaries.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Iitem -->
                        <!-- Single Iitem -->
                        {{-- <div class="single-item reverse wow fadeInUp">
                            <div class="row">
                                <div class="col-md-6 thumb">
                                    <img src="{{ asset('front/landing/assets/img/illustrations/6.svg')}}" alt="Thumb">
                                </div>
                                <div class="col-md-6 info">
                                    <h3>Integration</h3>
                                    <p>
                                        Celebrated conviction stimulated principles day. Sure fail or in said west. Right my front it wound cause fully am sorry if. She jointure goodness interest debating did outweigh. Is time from them.
                                    </p>
                                    <ul>
                                        <li>
                                            <h5>Amazingly Simple Use</h5>
                                            Certainty arranging am smallness by conveying
                                        </li>
                                        <li>
                                            <h5>Clear Documentation</h5>
                                            Frankness pronounce daughters remainder extensive
                                        </li>
                                        <li>
                                            <h5>Flexible user interface</h5>
                                            Outward general passage another as it. Very his are come man walk one next. Delighted prevailed supported
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                        <!-- End Single Iitem -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Work Process -->



    <!-- Start Testimonials Area
    ============================================= -->
    {{-- <div class="testimonials-area default-padding bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h4>What people says</h4>
                        <h2>Customer <strong>Review</strong></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="testimonial-items testimonial-carousel owl-carousel owl-theme">
                        <!-- Single Item -->
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{ asset('front/landing/assets/img/800x800.png')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <i class="ti-quote-left"></i>
                                <h4>Jessica Jones</h4>
                                <span>Market researcher</span>
                                <p>
                                    Music leave say doors him. Tore bred form if sigh case as do. Staying he no looking if do opinion. Sentiments way understood end partiality and his.
                                </p>
                            </div>
                        </div>
                        <!-- End Single Item -->
                        <!-- Single Item -->
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{ asset('front/landing/assets/img/800x800.png')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <i class="ti-quote-left"></i>
                                <h4>Jessica Jones</h4>
                                <span>Market researcher</span>
                                <p>
                                    Music leave say doors him. Tore bred form if sigh case as do. Staying he no looking if do opinion. Sentiments way understood end partiality and his.
                                </p>
                            </div>
                        </div>
                        <!-- End Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Testimonials Area -->

    <!-- Start Contact Area
    ============================================= -->
    <div id="contact" class="contact-area default-padding">
        <div class="container">
            <div class="contact-items">
                <div class="row">
                    <div class="col-md-6 faq">
                        <div class="heading">
                            <h2>FAQ</h2>
                        </div>
                        <div class="acd-items acd-arrow">
                            <div class="panel-group symb" id="accordion">

                                <!-- Single Item -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#ac1">
                                                <strong>01</strong>Can Any one join Efield Sales ?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="ac1" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <p>
                                              If you have a distribution business or sale products in the field, you can join for a monthly fee or one off with a yearly fee
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Item -->

                                <!-- Single Item -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#ac2">
                                                <strong>02</strong> Why choose us ?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="ac2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p>
                                               1. Respond to ever changing customer needs and stay ahead of the competition.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Item -->

                                <!-- Single Item -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#ac4">
                                               <strong>03</strong> What is the cost of using this platform ?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="ac4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p>
                                        We have options of monthly ranging from 10-30USD and a one time pay ment with annual subscription fees.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Item -->
                            </div>
                        </div>
                        <!-- End Faq -->
                        {{-- <a class="btn btn-theme effect btn-sm" href="#">more questions ?</a> --}}
                    </div>
                    <div class="col-md-6 contact-forms">
                        <div class="form-items bg-cover shadow dark-hard text-light" style="background-image: url(assets/img/2440x1578.png);">
                            <h2>Do You Have Any <strong>Questions?</strong></h2>

                            <form action="{{ route('contactus.save') }}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <input class="form-control" required id="name" name="name" placeholder="Name" type="text">
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control"  id="email" name="email" placeholder="Email*" type="email">
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" required id="phone" name="phone" placeholder="Phone" type="text">
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group comments">
                                            <textarea class="form-control" required id="message" name="message" placeholder="Tell Us About Project *"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit">
                                    SEND
                                </button>
                                <div class="col-md-12">
                                    <div class="row">
                                        <button type="submit">
                                            Send Message
                                        </button>
                                    </div>
                                </div>
                                <!-- Alert Message -->
                                <div class="col-md-12 alert-notification">
                                    <div id="message" class="alert-msg"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Area -->

    <!-- Start Companies Area
    ============================================= -->
    {{-- <div class="companies-area bg-gray text-center default-padding">
        <div class="container">
            <div class="companies-items">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="heading">
                            <h4>We're thrusted by</h4>
                            <h2><strong>12k+</strong> Customer</h2>
                            <p>
                                Perceive screened throwing met not eat distance. Viewing hastily or written dearest elderly up weather it as. So direction so sweetness or extremity at daughters. Provided put unpacked now but bringing.
                            </p>
                        </div>
                        <div class="item-list companies-carousel owl-carousel owl-theme">
                            <div class="item">
                                <img src="{{ asset('front/landing/assets/img/150x80.png')}}" alt="Thumb">
                            </div>
                            <div class="item">
                                <img src="{{ asset('front/landing/assets/img/150x80.png')}}" alt="Thumb">
                            </div>
                            <div class="item">
                                <img src="{{ asset('front/landing/assets/img/150x80.png')}}" alt="Thumb">
                            </div>
                            <div class="item">
                                <img src="{{ asset('front/landing/assets/img/150x80.png')}}" alt="Thumb">
                            </div>
                            <div class="item">
                                <img src="{{ asset('front/landing/assets/img/150x80.png')}}" alt="Thumb">
                            </div>
                            <div class="item">
                                <img src="{{ asset('front/landing/assets/img/150x80.png')}}" alt="Thumb">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Companies Area -->

    <!-- Start Google Maps
    ============================================= -->
    <div class="maps-area">
        <div class="row">
            <div class="google-maps">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.747819081709!2d32.58653727485845!3d0.34061216398864297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbbaf4de17ec3%3A0xeb00fba826446243!2s17%20Bukoto%20St%2C%20Kampala!5e0!3m2!1sen!2sug!4v1697726022866!5m2!1sen!2sug" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </div>
    </div>
    <!-- End Google Maps -->

    <!-- Start Footer
    ============================================= -->
    <footer>
        <div class="container">
            <div class="f-items default-padding">
                <div class="row">
                    <div class="col-md-4 col-sm-6 equal-height item">
                        <div class="f-item about">
                            <img src="{{ asset('front/landing/assets/img/logo.png')}}" alt="Logo">
                            <p>
                                Celebrated conviction stimulated principles day. Sure fail or in said west. Right my front it wound cause fully am sorry if. She jointure goodness interest debating did outweigh.
                            </p>
                            <h5>Stay Update With Us</h5>
                            <form action="#">
                                <div class="input-group stylish-input-group">
                                    <input type="email" placeholder="Enter your e-mail here" class="form-control" name="email">
                                    <span class="input-group-addon">
                                        <button type="submit">
                                            <i class="fa fa-paper-plane"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 equal-height item">
                        <div class="f-item link">
                            <h4>Company</h4>
                            <ul>
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li>
                                    <a href="#">About us</a>
                                </li>
                                <li>
                                    <a href="#">Compnay History</a>
                                </li>
                                <li>
                                    <a href="#">Features</a>
                                </li>
                                <li>
                                    <a href="#">Blog Page</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 equal-height item">
                        <div class="f-item link">
                            <h4>Resources</h4>
                            <ul>
                                <li>
                                    <a href="#">Career</a>
                                </li>
                                <li>
                                    <a href="#">Leadership</a>
                                </li>
                                <li>
                                    <a href="#">Strategy</a>
                                </li>
                                <li>
                                    <a href="#">Services</a>
                                </li>
                                <li>
                                    <a href="#">History</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 equal-height item">
                        <div class="f-item twitter-widget">
                            <h4>Contact Info</h4>
                            <p>
                                 Possible offering at contempt mr distance stronger an. Attachment excellence announcing
                            </p>
                            <div class="address">
                                <ul>
                                    <li>
                                        <div class="info">
                                            <h5>Email:</h5>
                                            <span>support@validtheme.com</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info">
                                            <h5>Phone:</h5>
                                            <span>+44-20-7328-4499</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Footer Bottom -->
        <div class="footer-bottom bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p style="text-align: center"> Copyright © 2018-<script>document.write(new Date().getFullYear())</script> E-FDSales All Rights Reserved</p>
                    </div>
                    <div class="col-md-6 text-right link">
                        <ul>
                            <li>
                                <a href="#">Terms</a>
                            </li>
                            <li>
                                <a href="#">Privacy</a>
                            </li>
                            <li>
                                <a href="#">Support</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!-- End Footer -->

    <!-- jQuery Frameworks
    ============================================= -->
    <script src="{{ asset('front/landing/assets/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('front/landing/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/equal-height.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/jquery.appear.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/modernizr.custom.13711.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/wow.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/progress-bar.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/count-to.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/YTPlayer.min.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/circle-progress.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/bootsnav.js')}}"></script>
    <script src="{{ asset('front/landing/assets/js/main.js')}}"></script>
    <script>
        (function(b){b.toast=function(a,h,g,l,k){b("#toast-container").length||(b("body").prepend('<div id="toast-container" aria-live="polite" aria-atomic="true"></div>'),b("#toast-container").append('<div id="toast-wrapper"></div>'));var c="",d="",e="text-muted",f="",m="object"===typeof a?a.title||"":a||"Notice!";h="object"===typeof a?a.subtitle||"":h||"";g="object"===typeof a?a.content||"":g||"";k="object"===typeof a?a.delay||3E3:k||3E3;switch("object"===typeof a?a.type||"":l||"info"){case "info":c="bg-info";
f=e=d="text-white";break;case "success":c="bg-success";f=e=d="text-white";break;case "warning":case "warn":c="bg-warning";f=e=d="text-white";break;case "error":case "danger":c="bg-danger",f=e=d="text-white"}a='<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="'+k+'">'+('<div class="toast-header '+c+" "+d+'">')+('<strong class="mr-auto">'+m+"</strong>");a+='<small class="'+e+'">'+h+"</small>";a+='<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">';
a+='<span aria-hidden="true" class="'+f+'">&times;</span>';a+="</button>";a+="</div>";""!==g&&(a+='<div class="toast-body">',a+=g,a+="</div>");a+="</div>";b("#toast-wrapper").append(a);b("#toast-wrapper .toast:last").toast("show")}})(jQuery);


const TYPES = ['info', 'warning', 'success', 'error'],
      TITLES = {
        'info': 'Notice!',
        'success': 'Awesome!',
        'warning': 'Watch Out!',
        'error': 'Doh!'
      },
      CONTENT = {
        'info': 'Message sent successfully.',
        'success': 'The action has been completed.',
        'warning': 'It\'s all about to go wrong',
        'error': 'It all went wrong.'
      };
        let succ = "{{ \Session::has('success') }}"
        if (succ){
        let type = TYPES[Math.floor(Math.random() * TYPES.length)],
      content = CONTENT[type].replace('toast', 'snack');

  $.toast({
    title: content,
    type: type,
    delay: 5000
  });
}
    </script>

</body>
</html>
