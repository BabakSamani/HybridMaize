@extends('app')

@section('content')
	<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-2uqBhq1_iCmt0OFu7eLEbZlHIVl2Ckk&libraries=drawing,places&callback=initMap" ></script>
	<style>
		.controls {
			 margin-top: 10px;
			 border: 1px solid transparent;
			 border-radius: 2px 0 0 2px;
			 box-sizing: border-box;
			 -moz-box-sizing: border-box;
			 height: 32px;
			 outline: none;
			 box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
		 }
		#pac-input {
			background-color: #fff;
			font-family: Roboto;
			font-size: 15px;
			font-weight: 300;
			margin-left: 12px;
			padding: 0 11px 0 13px;
			text-overflow: ellipsis;
			width: 300px;
		}
		#type-selector label {
			font-family: Roboto;
			font-size: 13px;
			font-weight: 300;
		}
		#pac-input:focus {
			border-color: #4d90fe;
		}

		#panel {
			width: 200px;
			font-family: Arial, sans-serif;
			font-size: 13px;
			float: right;
			margin: 10px;
		}

		#color-palette {
			clear: both;
		}

		.color-button {
			width: 14px;
			height: 14px;
			font-size: 0;
			margin: 2px;
			float: left;
			cursor: pointer;
		}
		/*.pac-container {*/
			/*font-family: Roboto;*/
		/*}*/

		/*#type-selector {*/
			/*color: #fff;*/
			/*background-color: #4d90fe;*/
			/*padding: 5px 11px 0px 11px;*/
		/*}*/

		/*#target {*/
			/*width: 345px;*/
		/*}*/
	</style>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>
					<p>You have login!</p>
					<div class="panel-body">
						<form class="form-horizontal" role="form" method="POST" action="">
							<p>Please select a crop:</p>
							<div class="radio-inline">
								<label><input type="radio" name="optRadio">Corn</label>
							</div>
							<div class="radio-inline">
								<label><input type="radio" name="optRadio">Soybean</label>
							</div>
							{!! Form::open(array('url'=>'', 'files'=>true)) !!}
								<div class="form-group">
									<label for="">Title</label>
									<input type="text" class="form-control input-sm" name="title"/>
								</div>
								<input id="pac-input" class="controls" type="text" placeholder="Search Box">
								<div id="map-canvas" style="width:100%; height: 500px;"></div>

								<script>
									var coordinates = [];
									var map;
									// Default latitude and longitude for the center of the map
									var center = {lat: 41.49212083968779, lng: -99.415283203125};

									function colorControl(controlDiv) {
										console.log('color control panel was called!'); // Print on the log
										// Set CSS for the control border.
										var colorUI = document.createElement('div');
										colorUI.style.backgroundColor = '#fff';
										colorUI.style.border = '2px solid #fff';
										colorUI.style.borderRadius = '2px';
										colorUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
										colorUI.style.cursor = 'pointer';
										colorUI.style.width = '200px';
										colorUI.style.marginTop = '5px';
										colorUI.style.marginBottom = '15px';
										colorUI.title = 'Color panel';
										colorUI.id = 'panel';
										colorUI.appendChild(controlDiv);

										// Set CSS for the control interior.
										var colorPalette = document.createElement('div');
										colorPalette.style.clear = 'both';
										colorPalette.id = 'color-palette';
										colorUI.appendChild(colorPalette);
									}

									function Delete_Button(deleteDiv) {

										// Set CSS for the control border.
										var deleteUI = document.createElement('div');
										deleteUI.style.backgroundColor = '#fff';
										deleteUI.style.border = '2px solid #fff';
										deleteUI.style.borderRadius = '2px';
										deleteUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
										deleteUI.style.cursor = 'pointer';
										deleteUI.style.marginTop = '5px';
										deleteUI.style.marginBottom = '15px';
										deleteUI.style.textAlign = 'center';
										deleteUI.title = 'delete shape';
										deleteUI.id = 'delete-button';
										deleteDiv.appendChild(deleteUI);

										// Set CSS for the control interior.
										var deleteText = document.createElement('div');
										deleteText.style.color = 'rgb(25,25,25)';
										deleteText.style.fontFamily = 'Roboto,Arial,sans-serif';
										deleteText.style.fontSize = '12px';
										deleteText.style.lineHeight = '21px';
										deleteText.style.paddingLeft = '5px';
										deleteText.style.paddingRight = '5px';
										deleteText.innerHTML = 'Delete selected shape';
										deleteUI.appendChild(deleteText);

										// Setup the click event listeners: simply set the map to Chicago.
										deleteUI.addEventListener('click', function() {
											deleteSelectedShape();
											coordinates.length = 0;
											console.log(coordinates); // Print on the log
										});
									}

									function displayLocationElevation(location, elevator, infowindow) {
										// Initiate the location request
										elevator.getElevationForLocations({
											'locations': [location]
										}, function(results, status) {
											infowindow.setPosition(location);
											if (status === 'OK') {
												// Retrieve the first result
												if (results[0]) {
													// Open the infowindow indicating the elevation at the clicked position.
													infowindow.setContent('The elevation at this point <br>is ' + results[0].elevation + ' meters.');
												} else {
													infowindow.setContent('No results found');
												}
											} else {
												infowindow.setContent('Elevation service failed due to: ' + status);
											}
										});
									}

									function Get_Elevation(location){
										console.log('The Get_Elevation function is being called!');
										var elevator = new google.maps.ElevationService;
										var elevations = new Array(1);
										elevations[0] = '0';
										// Initiate the location request
										elevator.getElevationForLocations({
											'locations': [location]
										}, function(results, status) {
											var elevation;
											if (status === 'OK') {
												// Retrieve the first result
												if (results[0]) {
													elevation = results[0].elevation;
												} else {
													elevation = 0;
												}
											} else {
												elevation = 0;
											}
											elevations[0] = elevation.toString();
										});
										for(var i=0; i<elevations.length; i++){
											console.log(elevations[i]); // Print on the log
										}
										return elevations;
									}

									function Get_Elevation_Elevator(location){
										console.log('The Get_Elevation_Elevator function is being called!');
										var elevator = new google.maps.ElevationService;
										var elevations = new Array(1);
//										elevations[0] = '0';
										// Initiate the location request
										if(elevator){
											elevator.getElevationForLocations({'locations': [location]}, function (results, status){
												if(status === 'OK'){
													console.log('Line 131: The length is ' + results.length);
													elevations[0] = results[0].elevation.toString();
												}
												else {
													elevations[0] = '0';
													console.log("Elevator is failed: " + status);
												}
												console.log(elevations[0]); // prints out the elevation here
											});
										}
										return elevations[0]; // Here returns nothing for the elevation
									}

									function Get_Eleveation_Geocoder(location){
										console.log('The Get_Eleveation_Geocoder function is being called!');
										var geocoder = new google.maps.Geocoder();
										if (geocoder) {
											geocoder.geocode({ 'location': location }, function (results, status) {
												if (status == google.maps.GeocoderStatus.OK) {
													console.log(results[0]);
												}
												else {
													console.log("Geocoding failed: " + status);
												}
											});
										}
									}

									function Get_Elevation_Ajax(lat, lng){
										console.log('The Get_Elevation_Ajax function is being called!');
										var elevation;
										var json;
										$.ajax({
											url: 'https://maps.googleapis.com/maps/api/elevation/json?locations='+ lat + ',' + lng + '&key=AIzaSyC-2uqBhq1_iCmt0OFu7eLEbZlHIVl2Ckk',
											dataType: 'json',
											json: 'callback',
											method: 'GET',
											success: function (results){
//												elevation = results[0].elevation;
//												console.log(results[0].elevation);
												var elev = results['results']['elevation'];
												console.log('latitude: ' + elev);
											}
										});
//										return elevation;
									}

									/* This function converts 'X' degrees to radians.*/
									function toRadians(x) {
										return (x * Math.PI / 180);
									}
									function distance_calculator(lat1,lng1,lat2,lng2) {
										var R = 6371e3; // metres
										var φ1 = toRadians(lat1);
										var φ2 = toRadians(lat2);
										var Δφ = toRadians((lat2-lat1));
										var Δλ = toRadians((lng2-lng1));

										var a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
												Math.cos(φ1) * Math.cos(φ2) *
												Math.sin(Δλ/2) * Math.sin(Δλ/2);
										var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

										return R * c;
									}

									function Circle_Coordinate_Generator(center_lat, center_lng, radius){
										var coordinates = [];
										var lat1 = toRadians(center_lat); 	// Convert to radian
										var lng1 = toRadians(center_lng); 	// convert to radian
										var R = radius/(3956*1609.344);		// Convert the radius to radian
										var lat, lng, dlng;
										for(var tc=0; tc <= 360; tc++){
											var tcRadian = toRadians(tc);
											// Starting from North
											// Condition for North
											if(tcRadian == 0){
												lat = lat1 + R;
											}
											// Condition for South
											else if (tcRadian == Math.PI) {
												lat = lat1 - R;
											}
											// Condition for East and West
											else if (tcRadian == (Math.PI/2) || tcRadian == (3 * Math.PI/2)){
												lat = Math.asin(Math.sin(lat1) * Math.cos(R));
											}
											// Condition for other cases
											else{
												lat = Math.asin(Math.sin(lat1) * Math.cos(R) + Math.cos(lat1) * Math.sin(R) * Math.cos(tcRadian));
											}

											if(Math.cos(lat) == 0){
												lng = lng1;
											}
											else{
												dlng = Math.atan2(Math.sin(tcRadian) * Math.sin(R) * Math.cos(lat1), Math.cos(R) - Math.sin(lat1) * Math.sin(lat));
												lng = ((lng1-dlng + Math.PI) % (2 * Math.PI)) - Math.PI;
											}
											var point = [lng * 57.2958, lat * 57.2958];
											coordinates.push(point);
										}
										return coordinates;
									}

									var selectedShape;
									var drawingManager;
									var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
									var selectedColor;
									var colorButtons = {};

									function clearSelection () {
										if (selectedShape) {
											if (selectedShape.type !== 'marker') {
												selectedShape.setEditable(false);
											}
											selectedShape = null;
										}
									}
									function setSelection (shape) {
										if (shape.type !== 'marker') {
											clearSelection();
											shape.setEditable(true);
											selectColor(shape.get('fillColor') || shape.get('strokeColor'));
										}
										selectedShape = shape;
									}
									function deleteSelectedShape () {
										if (selectedShape) {
											selectedShape.setMap(null);
										}
									}

									function selectColor (color) {
										selectedColor = color;
										for (var i = 0; i < colors.length; ++i) {
											var currColor = colors[i];
											colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
										}

										// Retrieves the current options from the drawing manager and replaces the
										// stroke or fill color as appropriate.
										var polylineOptions = drawingManager.get('polylineOptions');
										polylineOptions.strokeColor = color;
										drawingManager.set('polylineOptions', polylineOptions);

										var rectangleOptions = drawingManager.get('rectangleOptions');
										rectangleOptions.fillColor = color;
										drawingManager.set('rectangleOptions', rectangleOptions);

										var circleOptions = drawingManager.get('circleOptions');
										circleOptions.fillColor = color;
										drawingManager.set('circleOptions', circleOptions);

										var polygonOptions = drawingManager.get('polygonOptions');
										polygonOptions.fillColor = color;
										drawingManager.set('polygonOptions', polygonOptions);
									}
									function setSelectedShapeColor (color) {
										if (selectedShape) {
											if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
												selectedShape.set('strokeColor', color);
											} else {
												selectedShape.set('fillColor', color);
											}
										}
									}

									function makeColorButton (color) {
										var button = document.createElement('span');
										button.className = 'color-button';
										button.style.backgroundColor = color;
										google.maps.event.addDomListener(button, 'click', function () {
											selectColor(color);
											setSelectedShapeColor(color);
										});

										return button;
									}

									function buildColorPalette () {
										var colorPalette = document.getElementById('color-palette');
										for (var i = 0; i < colors.length; ++i) {
											var currColor = colors[i];
											var colorButton = makeColorButton(currColor);
											colorPalette.appendChild(colorButton);
											colorButtons[currColor] = colorButton;
										}
										selectColor(colors[0]);
									}

									function initMap() {
//									window.initMap = function(){
//										var directionsService = new google.maps.DirectionsService();
//										directionsDisplay = new google.maps.DirectionsRenderer();

										map = new google.maps.Map(document.getElementById('map-canvas'), {
											mapTypeControlOptions: {style:google.maps.MapTypeControlStyle.DROPDOWN_MENU},
											center: center,
											mapTypeId: google.maps.MapTypeId.MAP,
											scaleControl: true,
											mapTypeControl: true,
											streetViewControl: false,
											zoom: 7,
											minZoom: 4
										});

										// Setup a default marker
//										var marker = new google.maps.Marker({
//											position: myLatLng,
//											map: map,
//											draggable: true
//										});

										// Create the search box and link it to the UI element.
										var input = document.getElementById('pac-input');
										var searchBox = new google.maps.places.SearchBox(input);
										map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

										// Bias the SearchBox results towards current map's viewport.
										map.addListener('bounds_changed', function() {
											searchBox.setBounds(map.getBounds());
										});

										var markers = [];
										// Listen for the event fired when the user selects a prediction and retrieve
										// more details for that place.
										searchBox.addListener('places_changed', function() {
											var places = searchBox.getPlaces();

											if (places.length == 0) {
												return;
											}

											// Clear out the old markers.
											markers.forEach(function(marker) {
												marker.setMap(null);
											});
											markers = [];

											// For each place, get the icon, name and location.
											var bounds = new google.maps.LatLngBounds();
											places.forEach(function(place) {
												var icon = {
													url: place.icon,
													size: new google.maps.Size(71, 71),
													origin: new google.maps.Point(0, 0),
													anchor: new google.maps.Point(17, 34),
													scaledSize: new google.maps.Size(25, 25)
												};

												// Create a marker for each place.
												markers.push(new google.maps.Marker({
													map: map,
													icon: icon,
													title: place.name,
													position: place.geometry.location
												}));

												if (place.geometry.viewport) {
													// Only geocodes have viewport.
													bounds.union(place.geometry.viewport);
												} else {
													bounds.extend(place.geometry.location);
												}
											});
											map.fitBounds(bounds);
										});

										// Create the DIV to hold the control and call the Delete_Button()
										// constructor passing in this DIV.
										var deleteButtonDiv = document.createElement('div');
										var deleteButton = new Delete_Button(deleteButtonDiv);

										deleteButtonDiv.index = 1;
										map.controls[google.maps.ControlPosition.TOP_RIGHT].push(deleteButtonDiv);

										var colorPaletteDiv = document.createElement('div');
										var colorPalette = new colorControl(colorPaletteDiv);

										colorPaletteDiv.index = 1;
										map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(colorPaletteDiv);

//										var elevator = new google.maps.ElevationService;
//										var infowindow = new google.maps.InfoWindow({map: map});
//
//										google.maps.event.addListener(map, "click", function(event) {
//											displayLocationElevation(event.latLng, elevator, infowindow);
//										});

										//Add listener
//										google.maps.event.addListener(map, "click", function (event) {
//
//											var latitude = event.latLng.lat();
//											var longitude = event.latLng.lng();
//
//											fieldCoordinate.push([{"lat":latitude, "lng":longitude}]);
////											alert(fieldCoordinate[0][key]);
////											console.log( fieldCoordinate[0] );
//
//											radius = new google.maps.Circle({map: map,
//												radius: 100,
//												center: event.latLng,
//												fillColor: '#17A589',
//												fillOpacity: 0.5,
//												strokeColor: '#AA0000',
//												strokeOpacity: 0.8,
//												strokeWeight: 2,
//												draggable: true,    // Draggable
//												editable: true      // Resizable
//											});
//
//											// Center of map
//											map.panTo(new google.maps.LatLng(latitude,longitude));
//										}); //end addListener

//										var field = new google.maps.Polyline({
//											path: fieldCoordinate,
//											geodesic: true,
//											strokeColor: '#FF0000',
//											strokeOpacity: 1.0,
//											strokeWeight: 2
//										});

//										field.setMap(map);

										// Shapes options for drawing manager
										var polyOptions = {
//											fillColor: '#17A589',
// 											strokeColor: '#ffbf00',
											strokeWeight: 3,
											fillOpacity: 0.55,
											clickable: true,
											draggable: true,
											editable: true,
											geodesic: true,
											zIndex: 1
										};

										// Drawing a shapes
										drawingManager = new google.maps.drawing.DrawingManager({
											// Default drawing mode
											drawingMode: google.maps.drawing.OverlayType.PAN,//MARKER,
											drawingControl: true,
											drawingControlOptions: {
												position: google.maps.ControlPosition.TOP_RIGHT,
												drawingModes: [
													google.maps.drawing.OverlayType.MARKER,
													google.maps.drawing.OverlayType.CIRCLE,
													google.maps.drawing.OverlayType.POLYGON,
													google.maps.drawing.OverlayType.RECTANGLE,
													google.maps.drawing.OverlayType.POLYLINE
												]
											},
											markerOption:{
												animation: google.maps.Animation.DROP,
												clickable: true,
												draggable: true,
												editable:  true
											},
											circleOptions: polyOptions,
											rectangleOptions: polyOptions,
											polygonOptions: polyOptions,
											polylineOptions: polyOptions,
											map: map
										});


										google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
											var newShape = event.overlay;
											var path;
											newShape.type = event.type;
											if(newShape.type !== google.maps.drawing.OverlayType.MARKER){
												// Switch back to non-drawing mode after drawing a shape.
												drawingManager.setDrawingMode(null);

												if (newShape.type == 'rectangle') {
													coordinates.length = 0;
													console.log('rectangle');
													var rectangle = event.overlay;
													var bounds = rectangle.getBounds();
													var NE = bounds.getNorthEast();
													var SW = bounds.getSouthWest();
													var NW = new google.maps.LatLng(NE.lat(), SW.lng());
													var SE = new google.maps.LatLng(SW.lat(), NE.lng());
													coordinates.push(NE.toUrlValue(14));
													coordinates.push(NW.toUrlValue(14));
													coordinates.push(SW.toUrlValue(14));
													coordinates.push(SE.toUrlValue(14));
												}
												if (event.type == 'polygon'){
													coordinates.length = 0;
													console.log('polygon');
													var polygon = event.overlay;
													var len = polygon.getPath().getLength();

													for (var i = 0; i < len; i++) {
//													console.log(polygon.getPath().getAt(i).toString());//toUrlValue(5));
														coordinates.push(polygon.getPath().getAt(i).toUrlValue(14));
													}
												}
												if (event.type == 'circle') {
													coordinates.length = 0;
													console.log('circle');
													var circle = event.overlay;
													var center_lat = circle.getCenter().lat();
													var center_lng = circle.getCenter().lng();
													var radius = circle.getRadius();
													console.log('center: ',center_lat,',',center_lng,'---','radius: ',radius);
													var result = Circle_Coordinate_Generator(center_lat, center_lng, radius);
													for (var k=0; k<result.length; k++){
														var point = result[k];
														lng = point[1].toString();
														lat = point[0].toString();
														coordinates.push(point);
//													console.log(point[0].toString(),',',point[1].toString(),', 0');
													}
												}
												if (event.type == 'polyline') {
													coordinates.length = 0;
													console.log('polyline');
												}

												// Add an event listener that selects the newly-drawn shape when the user
												// mouses down on it.
												google.maps.event.addListener(newShape, 'click', function (event) {
													if (event.vertex !== undefined) {
														if (newShape.type === google.maps.drawing.OverlayType.POLYGON) {
															path = newShape.getPaths().getAt(event.path);
															path.removeAt(event.vertex);
															if (path.length < 3) {
																newShape.setMap(null);
															}
														}
														if (newShape.type === google.maps.drawing.OverlayType.POLYLINE) {
															path = newShape.getPath();
															path.removeAt(event.vertex);
															if (path.length < 2) {
																newShape.setMap(null);
															}
														}
													}
													setSelection(newShape);
												});
												setSelection(newShape);
											}
											else{
												var lat, lng;
												var marker = event.overlay;
												coordinates.length = 0;
												lat = marker.position.lat().toString();
												lng = marker.position.lng().toString();
												coordinates.push(marker.position.toUrlValue(14));
												Get_Elevation_Elevator(marker.position);

												google.maps.event.addListener(newShape, 'click', function (event) {
													setSelection(newShape);
												});
												setSelection(newShape);
											}

//											var lat, lng;
//											if (event.type == 'marker') {
//												var marker = event.overlay;
//												lat = marker.position.lat().toString();
//												lng = marker.position.lng().toString();
////												var elevation = Get_Elevation(marker.position);
////												console.log(elevation.length);
////												Get_Elevation_Ajax(lat,lng);
////												Get_Eleveation_Geocoder(marker.position);
//												console.log('Line 415: ' + Get_Elevation_Elevator(marker.position));
////												Get_Elevation(lat, lng);
////												var json_obj = JSON.parse(Get_Elevation(lat, lng));
//											}
//											if (event.type == 'rectangle') {
//												coordinates.length = 0;
//												console.log('rectangle');
//												var rectangle = event.overlay;
//												var bounds = rectangle.getBounds();
//												var NE = bounds.getNorthEast();
//												var SW = bounds.getSouthWest();
//												var NW = new google.maps.LatLng(NE.lat(), SW.lng());
//												var SE = new google.maps.LatLng(SW.lat(), NE.lng());
//												coordinates.push(NE.toUrlValue(14));
//												coordinates.push(NW.toUrlValue(14));
//												coordinates.push(SW.toUrlValue(14));
//												coordinates.push(SE.toUrlValue(14));
////												console.log(NE.toUrlValue(5), NW.toUrlValue(5), SW.toUrlValue(5), SE.toUrlValue(5));
//
//											}
//											if (event.type == 'polygon'){
//												coordinates.length = 0;
//												console.log('polygon');
//												var polygon = event.overlay;
//												var len = polygon.getPath().getLength();
//
//												for (var i = 0; i < len; i++) {
////													console.log(polygon.getPath().getAt(i).toString());//toUrlValue(5));
//													coordinates.push(polygon.getPath().getAt(i).toUrlValue(14));
//												}
//											}
//											if (event.type == 'circle') {
//												coordinates.length = 0;
//												console.log('circle');
//												var circle = event.overlay;
//												var center_lat = circle.getCenter().lat();
//												var center_lng = circle.getCenter().lng();
//												var radius = circle.getRadius();
//												console.log('center: ',center_lat,',',center_lng,'---','radius: ',radius);
//												var result = Circle_Coordinate_Generator(center_lat, center_lng, radius);
//												for (var k=0; k<result.length; k++){
//													var point = result[k];
//													lng = point[1].toString();
//													lat = point[0].toString();
//													coordinates.push(point);
////													console.log(point[0].toString(),',',point[1].toString(),', 0');
//												}
//											}
											console.log(coordinates);
										});

//										drawingManager.setMap(map);
										
										// Clear the current selection when the drawing mode is changed, or when the
										// map is clicked.
										google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
										google.maps.event.addListener(map, 'click', clearSelection);

										buildColorPalette();

//										var fieldCoordinate = [
//											{lat: 37.772, lng: -122.214},
//											{lat: 21.291, lng: -157.821},
//											{lat: -18.142, lng: 178.431},
//											{lat: -27.467, lng: 153.027}
//										];
//										var field = new google.maps.Polyline({
//											path: fieldCoordinate,
//											geodesic: true,
//											strokeColor: '#FF0000',
//											strokeOpacity: 1.0,
//											strokeWeight: 2
//										});
//
//										field.setMap(map);
//										directionsDisplay.setMap(map);

									 }

//									google.maps.event.addDomListener(window, 'load', initMap);
								</script>

								{{--<div class="form-group">--}}
									{{--<label for="">Map</label>--}}
									{{--<input type="text" class="form-control input-sm" id="searchMap">--}}
									{{--<div id="map-canvas"></div>--}}
								{{--</div>--}}
								<div id="panel">
									<div id="color-palette"></div>
								</div>
								<div class="form-group">
									<label for="">Lat</label>
									<input type="text" class="form-control input-sm" name="lat" id="lat">
								</div>

								<div class="form-group">
									<label for="">Lng</label>
									<input type="text" class="form-control input-sm" name="lng" id="lng">
								</div>

								<button class="btn btn-sm btn-danger">Save</button>
							{!! Form::close() !!}
							{{--<label class="c-input c-radio">--}}
								{{--<input id="radio1" name="radio" type="radio">--}}
								{{--<span class="c-indicator"></span>--}}
								{{--Soybean--}}
							{{--</label>--}}
							{{--<label class="c-input c-radio">--}}
								{{--<input id="radio2" name="radio" type="radio">--}}
								{{--<span class="c-indicator"></span>--}}
								{{--Corn--}}
							{{--</label>--}}

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Proceed
									</button>
								</div>
							</div>
						</form>
					</div>
					{{--{!! Form::open() !!}--}}
					{{--{!! Form::close() !!}--}}
				</div>
			</div>
		</div>
	</div>
@endsection
