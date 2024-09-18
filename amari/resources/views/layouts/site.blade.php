<!doctype html>
<html lang="en">

<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('css')
    <!-- Specific Meta
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Texicab is a modern presentation HTML5 Car Rent template.">
    <meta name="keywords" content="HTML5, Template, Design, Development, Car Rent" />
    <meta name="author" content="">

    <!-- Titles
    ================================================== -->
    <title>Amari Hitch</title>

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="{{asset('/front/site/assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('/front/site/assets/images/apple-touch-icon.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('/front/site/assets/images/apple-touch-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('/front/site/assets/images/apple-touch-icon-114x114.png')}}">

    <!-- Custom Font
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Exo:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i%7cRoboto+Slab:400,700" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{asset('/front/site/assets/css/plugins.min.css')}}">
    <link rel="stylesheet" href="{{asset('/front/site/assets/css/icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('/front/site/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/front/site/assets/css/color-schemer.css')}}">

     <!-- RS5.4 Main Stylesheet -->
     <link rel="stylesheet" type="text/css" href="{{asset('/front/site/assets/revolution/css/settings.css')}}">
     <!-- RS5.4 Layers and Navigation Styles -->
     <link rel="stylesheet" type="text/css" href="{{asset('/front/site/assets/revolution/css/layers.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('/front/site/assets/revolution/css/navigation.css')}}">
</head>

<body>


       <!-- ====== Header Top Area ====== -->
       <header class="header-top-area bg-nero">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-7 hidden-xs">
                    <div class="header-content-left">
                        <ul class="header-top-menu">
                            <li>
                                <a href="#" class="top-left-menu">
                                    <i class="fa fa-phone"></i>
                                    <span>Call Us - +256778233304</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="top-left-menu">
                                    <i class="fa fa-envelope"></i>
                                    <span>info@amarihitch.co</span>
                                </a>
                            </li>
                        </ul><!-- /.header-top-menu -->
                    </div><!-- /.header-content-left -->
                </div><!-- /.col-md-9 -->

                <div class="col-md-6 col-sm-5">
                    <div class="header-content-right">
						<a href="{{route('track.booking')}}" >

                                   <p style="color:gold;margin-top:15px;"> Track Booking</p>

                                </a>

                        <ul class="header-top-menu">
                           <!-- <li>
                                <a href="#" class="search-open">
                                    <i class="fa fa-search"></i>
                                </a>
                            </li> -->
                           <!-- <li>
                                <a href="{{route('track.booking')}}" class = "track-booking">

                                    Track Booking

                                </a>
                            </li> -->
                          <!--  <li>
                                <a href="#" class="trigger-overlay">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li> -->
                        </ul>
                    </div><!-- /.left-content -->
                </div><!-- /.col-md-3 -->




            </div><!-- /.row -->
        </div><!-- /.container -->
    </header><!-- /.head-area -->

    <!-- ======= Header Modal Area =======-->
    <div class="header-modal-area">
        <!-- Modal Search -->




        <div class="overlay overlay-scale">
            <button type="button" class="overlay-close">&#x2716;</button>
            <div class="overlay__content">
                <form id="search-form" class="search-form outer" action="#" method="post">
                    <div class="input-group">
                        <input type="text" class=" input--full" placeholder="search text here ...">
                    </div>
                    <button class="btn text-uppercase search-button">Search</button>
                </form>
            </div>
        </div>

        {{-- <div class="overlay-sidebar">
            <div class="author-area">
                <a href="#" class="closebtn">&times;</a>
                <div class="author-area-content">
                    <div class="login-author">
                        <div class="author-info">
                            <div class="author-image yellow-border">
                                <img src="{{asset('/front/site/assets/images/driver/driver-03.png')}}" alt="author-image" />
                            </div><!-- /.author-image -->
                            <div class="author-des">
                                <h4 class="author-name">Mr. Johan Smith</h4>
                                <p class="author-description">Programmer</p>
                            </div><!-- /.author-des -->
                        </div><!-- /.author-info -->
                        <div class="author-menu">
                            <ul class="yellow-color">
                                <li><a href=""><i class="fa fa-user-circle-o"></i>Author Dashboard</a></li>
                                <li><a href=""><i class="fa fa-envelope-open"></i>Your Inbox</a></li>
                                <li><a href=""><i class="fa fa-location-arrow"></i>Track your texi</a></li>
                                <li><a href=""><i class="fa fa-area-chart"></i>Your Bookings Status</a></li>
                                <li><a href=""><i class="fa fa-automobile"></i>New Bookings</a></li>
                                <li><a href=""><i class="fa fa-archive"></i>Your Bookings</a></li>
                                <li><a href=""><i class="fa fa-money"></i>Your Deposit - $150.00</a></li>
                                <li><a href=""><i class="fa fa-sign-out"></i>Sign Out</a></li>
                            </ul>
                        </div><!-- /.author-menu -->
                    </div><!-- /.login-author -->
                </div><!-- /.author-area-content -->
            </div><!-- /.author-area -->
        </div><!-- /.overlay-sidebar --> --}}



    </div><!-- /.header-modal-area -->

    <!-- ====== Header Nav Area ====== -->
    <header class="header-nav-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-10 col-xs-10">
                    <div class="site-logo">
                        <a href="{{url('/')}}"><img style="height: 100px;border-radius:7px;border: 2px solid #D7BE69;border-radius:30px;"
                            src="{{asset('/front/site/assets/images/logo2.jpg')}}" alt="logo" /></a>
                    </div><!-- /.logo -->
                </div><!-- /.col-md-3 -->
                <div class="col-md-9 col-sm-2 col-xs-2 pd-right-0">
                    <nav class="site-navigation top-navigation nav-style-one">
                        <div class="menu-wrapper">
                            <div class="menu-content">
                                <ul class="menu-list">
                                    <li>
                                        <a href="{{route('site.home')}}">Home</a>

                                    </li>
                                    <li>
                                        <a href="{{route('site.rental')}}">Car Hire</a>
                                    </li>
                                    <li>
                                        <a href="{{route('site.about')}}">About</a>
                                    </li>

                                    <li>
                                        <a href="{{route('site.contact')}}">Contact</a>
                                    </li>
                                </ul> <!-- /.menu-list -->
                            </div> <!-- /.menu-content-->
                        </div> <!-- /.menu-wrapper -->
                    </nav><!-- /.site-navigation -->
                    <!--Mobile Main Menu-->
                    <div class="mobile-menu-main hidden-md hidden-lg">
                        <div class="menucontent overlaybg"> </div>
                        <div class="menuexpandermain slideRight">
                            <a id="navtoggole-main" class="animated-arrow slideLeft menuclose">
                                <span></span>
                            </a>
                        </div><!--/.menuexpandermain-->

                        <div id="mobile-main-nav" class="mb-navigation slideLeft">
                            <div class="menu-wrapper">
                                <div id="main-mobile-container" class="menu-content clearfix"></div>
                            </div>
                        </div><!--/#mobile-main-nav-->
                    </div><!--/.mobile-menu-main-->
                </div><!-- /.col-md-9 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </header><!-- /.header-bottom-area -->

    <!-- ====== Page Header ====== -->
    @include('sweetalert::alert')

    <!-- ====== About Main Content ====== -->

@yield('content')

    <!-- ======footer area======= -->
    <div class="container footer-top-border">
        <div class="vehicle-multi-border"></div><!-- /.vehicle-multi-border -->
    </div><!-- /.container -->

    <footer class="footer-block bg-black" style="background-image: url(assets/images/footer-bg.png);">
        <div class="container">
            <!-- footer-top-block -->
            <div class="footer-top-block yellow-theme">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget_about">
                            <h3 class="widget-title">
                                About us
                            </h3><!-- /.widget-title -->
                            <div class="widget-about-content">
                                <img style="height: 100px;border-radius: 7px;" src="{{asset('/front/site/assets/images/logo2.jpg')}}" alt="logo" />

                            </div><!-- /.widget-content -->
                        </div><!-- /.widget widget_about -->
                    </div><!-- /.col-md-3 -->
                    <div class="col-md-2 col-sm-6">
                        <div class="widget widget_menu">
                            <h3 class="widget-title">
                                Links
                            </h3><!-- /.widget-title -->
                            <ul>
                                <li><a href="{{route('site.home')}}">Home</a></li>
                                <li><a href="{{route('site.about')}}"> About</a></li>
                                <li><a href="{{route('site.rental')}}">Rental</a></li>
                                <li><a href="{{route('site.contact')}}">Contact</a></li>

                            </ul>
                        </div><!-- /.widget -->
                    </div><!-- /.col-md-3 -->

                    <div class="col-md-3 col-sm-6">
                        <div class="widget widget_hot_contact">
                            <h3 class="widget-title">
                                Contact Info
                            </h3><!-- /.widget-title -->
                            <ul>
                                <li><a href="#"><i class="fa fa-envelope"></i>info@amarihitch.co</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>+256750161774/+256778233304</a></li>
                                <li><a href="#"><i class="fa fa-map-marker"></i>Plot 7 Kent Lane
                                    Kampala,Uganda</a></li>
                            </ul>
                        </div><!-- /.widget -->

                    </div><!-- /.col-md-3 -->

                    <div class="col-md-4 col-sm-6">
                        <div class="widget widget_newsletter">
                            <h3 class="widget-title">Subscribe</h3>
                            <form action="#" class="subscribes-newsletter" method="get">
                                <label>Subscribe to our Newsletters</label>
                                <div class="input-group">
                                    <input type="search" name="s" placeholder="Your email" class="form-controller">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">
                                                <span class="fa fa-paper-plane"></span>
                                        </button>
                                    </span>
                                </div><!-- /. input-group -->
                            </form><!-- /.subscribes-newsletter -->
                        </div><!-- /.widget -->
                    </div><!-- /.col-md-4 -->
                </div><!-- /.row -->
            </div><!-- /.footer-top-block -->

            <!-- footer-bottom-block -->
            <div class="footer-bottom-block">
                <div class="row">
                     <div class="col-md-9">
                        <div class="bottom-content-left">
                            <p class="copyright">Copyright &copy; <script>document.write(new Date().getFullYear())</script> AmariHitch  -  All Right Reserved <a href="tel:+256701361609">Created With love by +256701361609</a></p>
                        </div><!-- /.bottom-top-content -->
                     </div><!-- /.col-md-9 -->
                     <div class="col-md-3">
                        <div class="bottom-content-right">
                            <div class="social-profile">
                                <span class="social-profole-title">Follow Us:</span>
                                <a href="https://instagram.com/amarihitch"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-heart"></i></a>
                                <a href="https://fb.com/amarihitch"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/amarihitch"><i class="fa fa-twitter"></i></a>
                            </div><!-- /.social-profile -->
                        </div><!-- /.bottom-content-right -->
                     </div><!-- /.col-md-3 -->
                </div><!-- /.row -->
            </div><!-- /.footer-bottom-block -->
        </div><!-- /.container -->
    </footer><!-- /.footer-block -->
    @yield('scripts')
    <!-- All The JS Files
    ================================================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>


    <script src="{{asset('/front/site/assets/js/plugins.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/js/carrent.min.js')}}"></script> <!-- main-js -->

    <script src="{{asset('/front/site/assets/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>

    <script>
        jQuery(document).ready(function() {
            var $sliderSelector = jQuery(".carrent-slider");
            $sliderSelector.revolution({
                sliderType: "standard",
                sliderLayout: "fullwidth",
                delay: 9000,
                navigation: {
                    keyboardNavigation: "on",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation: "off",
                    onHoverStop: "on",
                    touch: {
                        touchenabled: "on",
                        swipe_threshold: 75,
                        swipe_min_touches: 1,
                        swipe_direction: "horizontal",
                        drag_block_vertical: false
                    },
                    arrows: {
                        style: "gyges",
                        enable: true,
                        hide_onmobile: false,
                        hide_onleave: true,
                        tmp: '',
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 10,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 10,
                            v_offset: 0
                        }
                    }
                },
                responsiveLevels:[1400,1368,992,480],
                visibilityLevels:[1400,1368,992,480],
                gridwidth:[1400,1368,992,480],
                gridheight:[750,750,900,900],
                disableProgressBar:"on"
            });
        });
    </script>

    <!-- SLIDER REVOLUTION 5.4 EXTENSIONS  (Load Extensions only on Local File Systems! The following part can be removed on Server for On Demand Loading) -->
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.video.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
    <script src="{{asset('/front/site/assets/revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker(
            {
                format:'y-m-d h:m'
            }

            );
        });
     </script>


	<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+256778233304", // WhatsApp number
            call: "+256750161774", // Call phone number
            call_to_action: "Contact Us", // Call to action
            button_color: "#FF6550", // Color of button
            position: "left", // Position may be 'right' or 'left'
            order: "whatsapp,call", // Order of buttons
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"
integrity="sha512-DNeDhsl+FWnx5B1EQzsayHMyP6Xl/Mg+vcnFPXGNjUZrW28hQaa1+A4qL9M+AiOMmkAhKAWYHh1a+t6qxthzUw=="
crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css"
integrity="sha512-yye/u0ehQsrVrfSd6biT17t39Rg9kNc+vENcCXZuMz2a+LWFGvXUnYuWUW6pbfYj1jcBb/C39UZw2ciQvwDDvg=="
crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
integrity="sha512-BNZ1x39RMH+UYylOW419beaGO0wqdSkO7pi1rYDYco9OL3uvXaC/GTqA5O4CVK2j4K9ZkoDNSSHVkEQKkgwdiw=="
crossorigin="anonymous"></script>

<script>
    var countryData = window.intlTelInputGlobals.getCountryData(),
  input = document.querySelector("#phone");


for (var i = 0; i < countryData.length; i++) {
  var country = countryData[i];
  country.name = country.name.replace(/.+\((.+)\)/,"$1");
}

var iti = window.intlTelInput(input, {
  utilsScript: "../../build/js/utils.js?1613236686837" // just for formatting/placeholders etc
});

input.addEventListener("countrychange", function() {
  let countrycode = iti.getSelectedCountryData()

  document.getElementById('ccode').value = '+'+countrycode.dialCode;
  document.getElementById('countryor').value = countrycode.name;

});
</script>







</body>
</html>
