@extends('layouts.customer')
@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <div class="page-title-breadcrumb">
                <div class=" pull-left">
                    <div class="page-title">User Profile</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                            href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li><a class="parent-item" href="#">Extra</a>&nbsp;<i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">User Profile</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar">
                    <div class="card card-topline-aqua">
                        <div class="card-body no-padding height-9">
                            <div class="row">
                                <div class="profile-userpic">
                                    <img src="../../assets/img/dp.jpg" class="img-responsive" alt=""> </div>
                            </div>
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name"> {{Auth::guard('customers')->user()->fullname}} </div>
                                <div class="profile-usertitle-job"> Email: {{Auth::guard('customers')->user()->email}} </div>
                                <div class="profile-usertitle-job"> Member Since: {{Auth::guard('customers')->user()->created_at}} </div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Bookings</b> <a class="pull-right">{{$count}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Completed</b> <a class="pull-right">{{$completed}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Canceled</b> <a class="pull-right">{{$cancelled}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Upcoming</b> <a class="pull-right">{{$upcoming}}</a>
                                </li>
                            </ul>
                            <!-- END SIDEBAR USER TITLE -->
                            <!-- SIDEBAR BUTTONS -->
                            <div class="profile-userbuttons">
                                <button type="button"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-circle btn-primary">Follow</button>
                                <button type="button"
                                    class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-circle btn-pink">Message</button>
                            </div>
                            <!-- END SIDEBAR BUTTONS -->
                        </div>
                    </div>
             <!--About me -->
       <!--ADDRESSCRD HERE -->
<!--WORK EXPERTISE CRD HERE -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="profile-tab-box">
                            <div class="p-l-20">
                                <ul class="nav ">
                                    <li class="nav-item tab-all"><a class="nav-link active show"
                                            href="#tab1" data-toggle="tab">Edit Password</a></li>
                                    <li class="nav-item tab-all p-l-20"><a class="nav-link" href="#tab2"
                                            data-toggle="tab">Edit Profile</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="white-box">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active fontawesome-demo" id="tab1">
                                    <div id="biography">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="card-head">
                                                        <header>Password Change</header>
                                                    </div>
                                                    <div class="card-body " id="bar-parent1">
                                                        <form method="POST" action="{{route('customer.password.change')}}">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="simpleFormEmail">Email</label>
                                                                <input type="email" class="form-control"
                                                                    id="simpleFormEmail"
                                                                    name="email"
                                                                    placeholder="Enter email address">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="simpleFormPassword">Current
                                                                    Password</label>
                                                                <input type="password" class="form-control"
                                                                name="oldpassword"
                                                                    id="simpleFormPassword"
                                                                    placeholder="Current Password">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="simpleFormPassword">New Password</label>
                                                                <input type="password" class="form-control"
                                                                name="password"
                                                                    id="newpassword" placeholder="New Password">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="simpleFormPassword">Confirm Password</label>
                                                                <input type="password" class="form-control"
                                                                name="c_password"
                                                                    id="newpassword" placeholder="Confirm Password">
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="card-head">
                                                    <header>Change Profile</header>
                                                </div>
                                                <div class="card-body " id="bar-parent1">
                                     <form method="POST" action="{{route('customer.profile.change')}}">
                                                        <div class="form-group">
                                                            <label for="simpleFormEmail">Email</label>
                                                            <input type="email" class="form-control"
                                                            name="email"
                                                                id="simpleFormEmail"
                                                                placeholder="Enter Email Address">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="simpleFormPassword">Full Name
                                                                </label>
                                                            <input type="text" class="form-control"
                                                            name="fullname"
                                                                id="simpleFormPassword"
                                                                placeholder="Full Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="simpleFormPassword">Phone Number</label>
                                                            <input type="text" class="form-control"
                                                            name="phone"
                                                                id="newpassword" placeholder="Phone Number">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="simpleFormPassword">Home Address</label>
                                                            <input type="text" class="form-control"
                                                            name="home"
                                                                id="newpassword" placeholder="Home Address">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="simpleFormPassword">Office Address</label>
                                                            <input type="text" class="form-control"
                                                            name="office"
                                                                id="newpassword" placeholder="Office Address">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="simpleFormPassword">User Name</label>
                                                            <input type="text" class="form-control"
                                                            name="username"
                                                                id="newpassword" placeholder="User Name">
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-primary">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
    </div>
    <!-- end page content -->
    <!-- start chat sidebar -->
    <div class="chat-sidebar-container" data-close-on-body-click="false">
        <div class="chat-sidebar">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#quick_sidebar_tab_1" class="nav-link active tab-icon" data-toggle="tab">Theme
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#quick_sidebar_tab_2" class="nav-link tab-icon" data-toggle="tab"> Settings
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane chat-sidebar-settings in show active animated shake" role="tabpanel"
                    id="quick_sidebar_tab_1">
                    <div class="slimscroll-style">
                        <div class="theme-light-dark">
                            <h6>Sidebar Theme</h6>
                            <button type="button" data-theme="white"
                                class="btn lightColor btn-outline btn-circle m-b-10 theme-button">Light
                                Sidebar</button>
                            <button type="button" data-theme="dark"
                                class="btn dark btn-outline btn-circle m-b-10 theme-button">Dark
                                Sidebar</button>
                        </div>
                        <div class="theme-light-dark">
                            <h6>Sidebar Color</h6>
                            <ul class="list-unstyled">
                                <li class="complete">
                                    <div class="theme-color sidebar-theme">
                                        <a href="#" data-theme="white"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="dark"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="blue"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="indigo"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="cyan"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="green"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="red"><span class="head"></span><span
                                                class="cont"></span></a>
                                    </div>
                                </li>
                            </ul>
                            <h6>Header Brand color</h6>
                            <ul class="list-unstyled">
                                <li class="theme-option">
                                    <div class="theme-color logo-theme">
                                        <a href="#" data-theme="logo-white"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="logo-dark"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="logo-blue"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="logo-indigo"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="logo-cyan"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="logo-green"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="logo-red"><span class="head"></span><span
                                                class="cont"></span></a>
                                    </div>
                                </li>
                            </ul>
                            <h6>Header color</h6>
                            <ul class="list-unstyled">
                                <li class="theme-option">
                                    <div class="theme-color header-theme">
                                        <a href="#" data-theme="header-white"><span
                                                class="head"></span><span class="cont"></span></a>
                                        <a href="#" data-theme="header-dark"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="header-blue"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="header-indigo"><span
                                                class="head"></span><span class="cont"></span></a>
                                        <a href="#" data-theme="header-cyan"><span class="head"></span><span
                                                class="cont"></span></a>
                                        <a href="#" data-theme="header-green"><span
                                                class="head"></span><span class="cont"></span></a>
                                        <a href="#" data-theme="header-red"><span class="head"></span><span
                                                class="cont"></span></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Start Setting Panel -->
                <div class="tab-pane chat-sidebar-settings animated slideInUp" id="quick_sidebar_tab_2">
                    <div class="chat-sidebar-settings-list slimscroll-style">
                        <div class="chat-header">
                            <h5 class="list-heading">Layout Settings</h5>
                        </div>
                        <div class="chatpane inner-content ">
                            <div class="settings-list">
                                <div class="setting-item">
                                    <div class="setting-text">Sidebar Position</div>
                                    <div class="setting-set">
                                        <select
                                            class="sidebar-pos-option form-control input-inline input-sm input-small ">
                                            <option value="left" selected="selected">Left</option>
                                            <option value="right">Right</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">Header</div>
                                    <div class="setting-set">
                                        <select
                                            class="page-header-option form-control input-inline input-sm input-small ">
                                            <option value="fixed" selected="selected">Fixed</option>
                                            <option value="default">Default</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">Sidebar Menu </div>
                                    <div class="setting-set">
                                        <select
                                            class="sidebar-menu-option form-control input-inline input-sm input-small ">
                                            <option value="accordion" selected="selected">Accordion</option>
                                            <option value="hover">Hover</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">Footer</div>
                                    <div class="setting-set">
                                        <select
                                            class="page-footer-option form-control input-inline input-sm input-small ">
                                            <option value="fixed">Fixed</option>
                                            <option value="default" selected="selected">Default</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-header">
                                <h5 class="list-heading">Account Settings</h5>
                            </div>
                            <div class="settings-list">
                                <div class="setting-item">
                                    <div class="setting-text">Notifications</div>
                                    <div class="setting-set">
                                        <div class="switch">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                                for="switch-1">
                                                <input type="checkbox" id="switch-1"
                                                    class="mdl-switch__input" checked>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">Show Online</div>
                                    <div class="setting-set">
                                        <div class="switch">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                                for="switch-7">
                                                <input type="checkbox" id="switch-7"
                                                    class="mdl-switch__input" checked>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">Status</div>
                                    <div class="setting-set">
                                        <div class="switch">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                                for="switch-2">
                                                <input type="checkbox" id="switch-2"
                                                    class="mdl-switch__input" checked>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">2 Steps Verification</div>
                                    <div class="setting-set">
                                        <div class="switch">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                                for="switch-3">
                                                <input type="checkbox" id="switch-3"
                                                    class="mdl-switch__input" checked>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-header">
                                <h5 class="list-heading">General Settings</h5>
                            </div>
                            <div class="settings-list">
                                <div class="setting-item">
                                    <div class="setting-text">Location</div>
                                    <div class="setting-set">
                                        <div class="switch">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                                for="switch-4">
                                                <input type="checkbox" id="switch-4"
                                                    class="mdl-switch__input" checked>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">Save Histry</div>
                                    <div class="setting-set">
                                        <div class="switch">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                                for="switch-5">
                                                <input type="checkbox" id="switch-5"
                                                    class="mdl-switch__input" checked>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-item">
                                    <div class="setting-text">Auto Updates</div>
                                    <div class="setting-set">
                                        <div class="switch">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                                for="switch-6">
                                                <input type="checkbox" id="switch-6"
                                                    class="mdl-switch__input" checked>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end chat sidebar -->
</div>
@endsection
