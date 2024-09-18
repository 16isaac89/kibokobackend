<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Material Bootstrap Wizard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<link href="{{asset('front/website/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
	<link href="{{asset('front/website/assets/css/material-bootstrap-wizard.css')}}" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="{{asset('front/website/assets/css/demo.css')}}" rel="stylesheet" />



<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />

<script type="text/javascript"
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSGXiLg9kRk_93B-s_2VFkrnqHfULeZtI&callback=initialize&libraries=places&v=weekly"
async
></script>
</head>

<body>
	<div class="image-container set-full-height" style="background-image: url('assets/img/wizard-book.jpg')">
	    <!--   Creative Tim Branding   -->
	    <a href="http://creative-tim.com">
	         <div class="logo-container">
	            <div class="logo">
	                <img src="assets/img/new_logo.png">
	            </div>
	            <div class="brand">
	                Creative Tim
	            </div>
	        </div>
	    </a>

		<!--  Made With Material Kit  -->
		{{-- <a href="http://demos.creative-tim.com/material-kit/index.html?ref=material-bootstrap-wizard" class="made-with-mk">
			<div class="brand">MK</div>
			<div class="made-with">Made with <strong>Material Kit</strong></div>
		</a> --}}

	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-8 col-sm-offset-2">
		            <!--      Wizard container        -->
		            <div class="wizard-container">
		                <div class="card wizard-card" data-color="orange" id="wizard">
		                    <form action="POST" method="{{route('customer.save.booking')}}">
                                @csrf
		                <!--        You can switch " data-color="blue" "  with one of the next bright colors: "green", "orange", "red", "purple"             -->

		                    	<div class="wizard-header">
		                        	<h3 class="wizard-title">
		                        		Book Your Ride
		                        	</h3>
									<h5>On the Dot Around the clock.</h5>
		                    	</div>
								<div class="wizard-navigation">
									<ul>
			                            <li><a href="#details" data-toggle="tab">Booking</a></li>
			                            <li><a href="#captain" data-toggle="tab">User</a></li>
			                            <li><a href="#description" data-toggle="tab">Summary</a></li>

			                        </ul>
								</div>

		                        <div class="tab-content">
		                            <div class="tab-pane" id="details">
		                            	<div class="row">
			                            	<div class="col-sm-12">
			                                	<h4 class="info-text"> Let's start with the Booking Information.</h4>
			                            	</div>
		                                	<div class="col-sm-6">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">travel_explore</i>
													</span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Click To Select Booking Type</label>
                                                        <select class="form-control"  name="triptype" id="triptype">
                                                            <option readonly>Select Booking Type</option>
                                                          <option value="pickup">From Airport</option>
                                                          <option value="dropoff">To Airport</option>
                                                          <option value="townrun">Town Run</option>
                                                          <option value="hire">Delivery</option>
                                                          <option value="delivery">Car Hire</option>
                                                        </select>
                                                      </div>
												</div>

                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">local_shipping</i>
													</span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Click To Select Car Type</label>
                                                        <select class="form-control" name="car_type_id" id="car_type_id">
                                                        <option readonly>Select Car Type</option>
                                                        @foreach ($car_types as $item)
                                                        <option value="{{$item->id}}">{{$item->name}} {{$item->passengers}}PAX</option>
                                                        @endforeach
                                                        </select>
                                                      </div>
												</div>

                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">read_more</i>
													</span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Any additional Services </label>
                                                        <select class="form-control" name="services[]" id="services" multiple>
                                                            <option disabled="" selected="">Select Service</option>
                                                        @foreach ($services as $item)
                                                        <option value="{{$item->id}}">{{$item->name}} {{$item->value}}UGX</option>
                                                        @endforeach
                                                        </select>
                                                      </div>
												</div>

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">watch_later</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Number Of Days</label>
			                                          	<input name="days" id="days" type="number" class="form-control">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">fitness_center</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Tonnage</label>
			                                          	<input name="tonnage" id="tonnage" type="number" class="form-control">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">near_me</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Pickup Location</label>
			                                          	<input id="from" name="from" type="text" class="form-control">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">navigation</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Drop Off Location</label>
			                                          	<input name="to" id="to" type="text" class="form-control">
			                                        </div>
												</div>
		                                	</div>
		                            	</div>
		                            </div>
		                            <div class="tab-pane" id="captain">
		                                <h4 class="info-text">About You </h4>
                                        <div class="row">

		                                	<div class="col-sm-6">

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">account_circle</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Full Name</label>
			                                          	<input name="fullname" id="fullname" type="text" class="form-control">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">email</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Email</label>
			                                          	<input name="email" id="email" type="email" class="form-control">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">phone</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Phone Number</label>
			                                          	<input id="phonenumber" name="phonenumber" type="number" class="form-control">
			                                        </div>
												</div>
                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">flight_takeoff</i>
													</span>
													<div class="form-group label-floating">
			                                          	<label class="control-label">Flight Number</label>
			                                          	<input name="to" id="to" type="text" class="form-control">
			                                        </div>
												</div>

                                                <div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">event</i>
													</span>

			                                          	<div class='input-group date' id='datetimepicker2'>
                                                            <input type='text' class="form-control" />
                                                            <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                         </div>

												</div>


		                                	</div>
		                            	</div>
		                            </div>
		                            <div class="tab-pane" id="description">
		                                <div class="row">

		                                    <div class="col-sm-4">
                                                <div id="map" style="height: 400px; width: 400px" ></div>
                                               </div>
		                                    <div class="col-sm-4" style="margin-left: 160px">
		                                    	<div class="form-group">
                                                    <div class="column">
                                                        {{-- <label>Miles</label>
                                                        <input type="text" class="list-group-item d-flex justify-content-between align-items-center" disabled  id="in_mile"> --}}

                                                        Distance: <input type="text" style="border-top-style: hidden;
                                                        border-right-style: hidden;
                                                        border-left-style: hidden;
                                                        border-bottom-style: groove;
                                                        background-color: #eee; margin:15px;"   readonly name="distance"  id="in_kilo">


                                                        Duration: <input style="border-top-style: hidden;
                                                        border-right-style: hidden;
                                                        border-left-style: hidden;
                                                        border-bottom-style: groove;
                                                        background-color: #eee; margin:15px;"  type="text"  readonly name="duration" id="duration">


                                                        Zone: <input style="border-top-style: hidden;
                                                        border-right-style: hidden;
                                                        border-left-style: hidden;
                                                        border-bottom-style: groove;
                                                        background-color: #eee; margin:15px;"   type="text" name="zone"  readonly  id="zone">


                                                        Price: <input style="border-top-style: hidden;
                                                        border-right-style: hidden;
                                                        border-left-style: hidden;
                                                        border-bottom-style: groove;
                                                        background-color: #eee; margin:15px;"   type="text" name="amount"  readonly  id="price">

                                                    </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
	                        	<div class="wizard-footer">
	                            	<div class="pull-right">
	                                    <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Next' />
	                                    <button type="submit" class='btn btn-next btn-fill btn-success btn-wd' name='finish' value='Finish'>Book Now</button>
	                                </div>
	                                <div class="pull-left">
	                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />

										<div class="footer-checkbox">
											<div class="col-sm-12">
											  <div class="checkbox">
												  <label>
													  <input type="checkbox" name="optionsCheckboxes">
												  </label>
												  Subscribe to our newsletter
											  </div>
										  </div>
										</div>
	                                </div>
	                                <div class="clearfix"></div>
	                        	</div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div> <!-- row -->
		</div> <!--  big container -->

	    <div class="footer">
	        <div class="container text-center">
	             Made with <i class="fa fa-heart heart"></i> by <a href="tel:+256701361609">+256701361609</a>
	        </div>
	    </div>
	</div>




</body>
	<!--   Core JS Files   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	//<script src="{{asset('front/website/assets/js/jquery-2.2.4.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('front/website/assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('front/website/assets/js/jquery.bootstrap.js')}}" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="{{asset('front/website/assets/js/material-bootstrap-wizard.js')}}"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="{{asset('front/website/assets/js/jquery.validate.min.js')}}"></script>


    <script>
        $(function () {
            var origin, destination, map;

            // add input listeners
            google.maps.event.addDomListener(window, 'load', function (listener) {
                setDestination();
                initMap();
            });

            // init or load map
            function initMap() {

                var myLatLng = {
                    lat: 0.347596,
                    lng: 32.582520
                };
                map = new google.maps.Map(document.getElementById('map'), {zoom: 10, center: myLatLng,});
            }

            function setDestination() {
                var from_places = new google.maps.places.Autocomplete(document.getElementById('from'));
                var to_places = new google.maps.places.Autocomplete(document.getElementById('to'));

                google.maps.event.addListener(from_places, 'place_changed', function () {
                    var from_place = from_places.getPlace();
                    var from_address = from_place.formatted_address;
                    $('#origin').val(from_address);
                });

                google.maps.event.addListener(to_places, 'place_changed', function () {
                    var to_place = to_places.getPlace();
                    var to_address = to_place.formatted_address;
                    $('#destination').val(to_address);

                    getRoute();
                });


            }

            function displayRoute( origin, destination, directionsService, directionsDisplay) {
                var directionsService = new google.maps.DirectionsService();
                var directionsRenderer = new google.maps.DirectionsRenderer();
                directionsService.route({
                    origin: origin,
                    destination: destination,
                    travelMode: 'DRIVING',
                    avoidTolls: true
                }, function (response, status) {
                    if (status === 'OK') {
                        directionsDisplay.setMap(map);
                        directionsDisplay.setDirections(response);
                    } else {
                        directionsDisplay.setMap(null);
                        directionsDisplay.setDirections(null);
                        alert('Could not display directions due to: ' + status);
                    }
                } );
            }

            // calculate distance , after finish send result to callback function
            function calculateDistance( origin, destination) {
                var travel_mode = 'DRIVING'
                var DistanceMatrixService = new google.maps.DistanceMatrixService();
                DistanceMatrixService.getDistanceMatrix(
                    {
                        origins: [origin],
                        destinations: [destination],
                        travelMode: google.maps.TravelMode[travel_mode],
                        unitSystem: google.maps.UnitSystem.IMPERIAL, // miles and feet.
                        // unitSystem: google.maps.UnitSystem.metric, // kilometers and meters.
                        avoidHighways: false,
                        avoidTolls: false
                    },save_results);
            }

            // save distance results
            function save_results(response, status) {

                if (status != google.maps.DistanceMatrixStatus.OK) {
                    $('#result').html(err);
                } else {
                    var origin = response.originAddresses[0];
                    var destination = response.destinationAddresses[0];
                    if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
                        $('#result').html("Sorry , not available to use this travel mode between " + origin + " and " + destination);
                    } else {
                        var distance = response.rows[0].elements[0].distance;
                        var duration = response.rows[0].elements[0].duration;
                        var distance_in_kilo = distance.value / 1000; // the kilo meter
                        var distance_in_mile = distance.value / 1609.34; // the mile
                        var duration_text = duration.text;

                        document.getElementById("in_kilo").value = distance_in_kilo + 'KM';

                        document.getElementById("duration").value = duration_text;

                        let cartype = document.getElementById('car_type_id').value;
                        var triptype = document.getElementById("triptype").value;
                        let services = $('#services').val();;
                        document.getElementById('in_kilo').value = distance_in_kilo
                         document.getElementById('duration').value = duration_text


                        var days = document.getElementById("days").value;
                        if(triptype == 'pickup'){

                            $.ajax({
                                url: '{{ route('booking.get.price') }}',
                                type: 'POST',
                                data: {
                                    car: cartype,
                                    distance: distance_in_kilo,
                                    service: services
                                },
                                success: function (response) {

                                    let id = parseInt(response.zone)
                                    document.getElementById("zone").value = response.zonename;
                                    document.getElementById("price").value = response.price;
                                    console.log(response)



                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown,jqXHR);
                                }
                            });
                        }else if(triptype == 'dropoff'){


                            $.ajax({
                                url: '{{ route('booking.get.price') }}',
                                type: 'POST',
                                data: {
                                    car: cartype,
                                    distance: distance_in_kilo,
                                    service: services
                                },
                                success: function (response) {

                                    let id = parseInt(response.zone)
                                    document.getElementById("zone").value = response.zonename;
                                    document.getElementById("price").value = response.price;
                                    console.info(response);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown,jqXHR);
                                }
                            });


                        }else if(triptype == 'townrun'){
                            $.ajax({
                                url: '{{ route('booking.get.price.town') }}',
                                type: 'POST',
                                data: {
                                    car: cartype,
                                    distance: distance_in_kilo
                                },
                                success: function (response) {
                                    document.getElementById("zone").value = 'Town Run';
                                    document.getElementById("price").value = response.price;
                                    console.info(response);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown,jqXHR);
                                }
                            });
                        } else if(triptype == 'hire'){

                            $.ajax({
                                url: '{{ route('booking.get.price.hire') }}',
                                type: 'POST',
                                data: {
                                    car: cartype,
                                    days:days
                                },
                                success: function (response) {
                                    document.getElementById("zone").value = 'Car Hire';
                                    document.getElementById("price").value = response.price;
                                    console.info(response);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown,jqXHR);
                                }
                            });

                        }else if(triptype == 'delivery'){
                            $.ajax({
                                url: '{{ route('booking.get.price.delivery') }}',
                                type: 'POST',
                                data: {
                                    car: cartype,
                                    distance:distance_in_kilo
                                },
                                success: function (response) {
                                    document.getElementById("zone").value = 'Delivery';
                                    document.getElementById("price").value = response.price;
                                    console.info(response);
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown,jqXHR);
                                }
                            });

                        }



                        appendResults(distance_in_kilo, distance_in_mile, duration_text);
                       // sendAjaxRequest(origin, destination, distance_in_kilo, distance_in_mile, duration_text);
                    }
                }
            }

            // append html results
            function appendResults(distance_in_kilo, distance_in_mile, duration_text) {
                console.log(distance_in_kilo, distance_in_mile, duration_text)
                $("#result").removeClass("hide");
                $('#in_mile').html(" 'distance_in_mile' : <span class='badge badge-pill badge-secondary'>" + distance_in_mile.toFixed(2) + "</span>");
                $('#in_kilo').html(" 'distance_in_kilo': <span class='badge badge-pill badge-secondary'>" + distance_in_kilo.toFixed(2) + "</span>");
                $('#duration_text').html("'in_text': <span class='badge badge-pill badge-success'>" + duration_text + "</span>");
            }


            function getRoute(){
                //e.preventDefault();
                var origin = $('#from').val();
                var destination = $('#to').val();

                var directionsDisplay = new google.maps.DirectionsRenderer({'draggable': false});
                var directionsService = new google.maps.DirectionsService();
               displayRoute( origin, destination, directionsService, directionsDisplay);
                calculateDistance( origin, destination);
            }



        });

        // get current Position
        function getCurrentPosition() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(setCurrentPosition);
            } else {
                alert("Geolocation is not supported by this browser.")
            }
        }

        // get formatted address based on current position and set it to input
        function setCurrentPosition(pos) {
            var geocoder = new google.maps.Geocoder();
            var latlng = {lat: parseFloat(pos.coords.latitude), lng: parseFloat(pos.coords.longitude)};
            geocoder.geocode({ 'location' :latlng  }, function (responses) {
                console.log(responses);
                if (responses && responses.length > 0) {
                    $("#origin").val(responses[1].formatted_address);
                    $("#from").val(responses[1].formatted_address);
                    //    console.log(responses[1].formatted_address);
                } else {
                    alert("Cannot determine address at this location.")
                }
            });
        }


    </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker2').datetimepicker({

        });
    });
 </script>



</html>
