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

    <link href="{{asset('subd/lib/select2/css/select2.min.css')}}" rel="stylesheet">

    <title>EFDs</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@yield('styles')
    <!-- vendor css -->
    <link href="{{asset('subd/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('subd/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('subd/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('subd/lib/jquery-toggles/toggles-full.css')}}" rel="stylesheet">
    <link href="{{asset('subd/lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />

    <link href="{{asset('subd/lib/highlightjs/github.css')}}" rel="stylesheet">
    <link href="{{asset('subd/lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">



    <link href="{{asset('subd/lib/select2/css/select2.min.css')}}" rel="stylesheet">

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="{{asset('subd/css/amanda.css')}}">
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

    <style type="text/css">
      #map {
        width: 100%;
        height: 570px;
      }


td a, td input, td img {
    vertical-align: middle;
    display: inline-block;
}

        /* setting the text-align property to center*/
        td,th {
            padding: 5px;
            text-align: center;
        }
    </style>


    <link rel="stylesheet" href="{{asset('css/pos/style.css')}}">


<link rel="stylesheet" href="{{asset('css/pos/animate.css')}}">

<link rel="stylesheet" href="{{asset('css/pos/plugins/owlcarousel/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('css/pos/plugins/owlcarousel/owl.theme.default.min.css')}}">

<link rel="stylesheet" href="{{asset('css/pos/plugins/select2/css/select2.min.css')}}">

<link rel="stylesheet" href="{{asset('css/pos/bootstrap-datetimepicker.min.css')}}">

<link rel="stylesheet" href="{{asset('css/pos/plugins/fontawesome/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{asset('css/pos/plugins/fontawesome/css/all.min.css')}}">

<script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
@yield('styles')
  </head>

  <body>

    <div class="am-header">
      <div class="am-header-left">
        <a id="naviconLeft" href="" class="am-navicon d-none d-lg-flex"><i class="icon ion-navicon-round"></i></a>
        <a id="naviconLeftMobile" href="" class="am-navicon d-lg-none"><i class="icon ion-navicon-round"></i></a>
        <a href="index.html" class="am-logo">SFA</a>
      </div><!-- am-header-left -->

      <div class="am-header-right">
        <div class="dropdown dropdown-notification">
          <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
            <i class="icon ion-ios-bell-outline tx-24"></i>
            <!-- start: if statement -->
            <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span>
            <!-- end: if statement -->
          </a>

        </div><!-- dropdown -->
        <div class="dropdown dropdown-profile">
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <img src="../img/img3.jpg" class="wd-32 rounded-circle" alt="">
            <span class="logged-name"><span class="hidden-xs-down">
                {{Auth::guard('dealer')->user() ? Auth::guard('dealer')->user()->username : ""}}</span> <i class="fa fa-angle-down mg-l-3"></i></span>
          </a>
          <div class="dropdown-menu wd-200">
            <ul class="list-unstyled user-profile-nav">
              <li><a href="{{ route('user.edit.profile') }}"><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>
              <!-- <li><a href=""><i class="icon ion-ios-gear-outline"></i> Settings</a></li>
              <li><a href=""><i class="icon ion-ios-download-outline"></i> Downloads</a></li>
              <li><a href=""><i class="icon ion-ios-star-outline"></i> Favorites</a></li>
              <li><a href=""><i class="icon ion-ios-folder-outline"></i> Collections</a></li> -->
              <li><a href="{{route('dealer.signout.post')}}"><i class="icon ion-power"></i> Sign Out</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </div><!-- am-header-right -->
    </div><!-- am-header -->

   @include('partials.distmenu')

    <div class="am-mainpanel">
      <div class="am-pagetitle">
        <h5 class="am-title">{{ \Auth::guard('dealer')->user()->dealer->tradename }}</h5>
        <form id="searchBar" class="search-bar" action="index.html">
          <div class="form-control-wrapper">
            <input type="search" class="form-control bd-0" placeholder="Search...">
          </div><!-- form-control-wrapper -->
          <button id="searchBtn" class="btn btn-orange"><i class="fa fa-search"></i></button>
        </form><!-- search-bar -->
      </div><!-- am-pagetitle -->

      @yield('content')



      <div class="modal fade activityindicator" data-backdrop="static" id="activityindicator" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="width: 48px">
                <span class="fa fa-spinner fa-spin fa-3x"></span>
            </div>
        </div>
    </div>

      </div><!-- am-pagebody -->

    </div><!-- am-mainpanel -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <script src="{{asset('subd/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    <script src="{{asset('subd/lib/jquery-toggles/toggles.min.js')}}"></script>
    <script src="{{asset('subd/lib/d3/d3.js')}}"></script>
    <script src="{{asset('subd/lib/rickshaw/rickshaw.min.js')}}"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAEt_DBLTknLexNbTVwbXyq2HSf2UbRBU8"></script>
    <script src="{{asset('subd/lib/gmaps/gmaps.js')}}"></script>
    <script src="{{asset('subd/lib/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('subd/lib/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('subd/lib/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('subd/lib/flot-spline/jquery.flot.spline.js')}}"></script>

    <script src="{{asset('subd/js/amanda.js')}}"></script>
    <script src="{{asset('subd/js/ResizeSensor.js')}}"></script>
    <script src="{{asset('subd/js/dashboard.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="{{asset('subd/lib/highlightjs/highlight.pack.js')}}"></script>
    <script src="{{asset('subd/lib/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('subd/lib/datatables-responsive/dataTables.responsive.js')}}"></script>


    <script src="{{asset('subd/lib/select2/js/select2.min.js')}}"></script>

    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>

    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    @yield('scripts')

    <script>
        (function() {

          'use strict';

          $('.select2').select2({
            minimumResultsForSearch: Infinity
          });

          // Select2 by showing the search
          $('.select2-show-search').select2({
            minimumResultsForSearch: '',
            dropdownAutoWidth : false
          });
        //   $('.brand').select2({
        //     minimumResultsForSearch: '',
        //     dropdownAutoWidth : false
        //   });
        //   $('.product').select2({
        //     minimumResultsForSearch: '',
        //     dropdownAutoWidth : false
        //   });
          $('.select-route').select2({
            minimumResultsForSearch: ''
          });

          // Select2 with tagging support
          $('.select2-tag').select2({
            tags: true,
            tokenSeparators: [',', ' ']
          });



        })();
      </script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>

     @if(session('message'))
     Toastify({
text: "{{ session('message') }}",
duration: 10000,
destination: "https://github.com/apvarun/toastify-js",
newWindow: true,
close: true,
gravity: "top", // `top` or `bottom`
position: "right", // `left`, `center` or `right`
stopOnFocus: true, // Prevents dismissing of toast on hover
offset: {
x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
},
style: {
background: "linear-gradient(to right, #00b09b, #96c93d)",
},
onClick: function(){} // Callback after click
}).showToast();
    @endif
            @if(session('error'))
            Toastify({
text: "{{ session('error') }}",
duration: 3000,
destination: "https://github.com/apvarun/toastify-js",
newWindow: true,
close: true,
gravity: "top", // `top` or `bottom`
position: "right", // `left`, `center` or `right`
offset: {
x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
},
stopOnFocus: true, // Prevents dismissing of toast on hover
style: {
background: "linear-gradient(to right, #EE4B2B, #A52A2A)",
},
onClick: function(){} // Callback after click
}).showToast();
            @endif
</script>
  </body>
</html>
