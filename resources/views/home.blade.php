@extends('app')

@section('content')
	{{--<script>--}}
		{{--var map;--}}
		{{--function initMap() {--}}
			{{--map = new google.maps.Map(document.getElementById('map'), {--}}
				{{--center: {lat: -34.397, lng: 150.644},--}}
				{{--zoom: 15--}}
			{{--});--}}
		{{--}--}}
	{{--</script>--}}
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-2uqBhq1_iCmt0OFu7eLEbZlHIVl2Ckk&callback=initMap"
			async defer></script>
	{{--<script>--}}
		{{--var map = new google.maps.Map(document.getElementById('map-canvas'),{--}}
			{{--center:{--}}
				{{--lat: 27.72,--}}
				{{--lng: 85.36--}}
			{{--},--}}
			{{--zoom:15--}}
		{{--});--}}
	{{--</script>--}}
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
									<input type="text" class="form-control input-sm" name="title">
								</div>

								<div id="map"></div>
								<script>
									var map;
									function initMap() {
										map = new google.maps.Map(document.getElementById('map'), {
											center: {lat: -34.397, lng: 150.644},
											zoom: 8
										});
									}
								</script>

								{{--<div class="form-group">--}}
									{{--<label for="">Map</label>--}}
									{{--<input type="text" class="form-control input-sm" id="searchMap">--}}
									{{--<div id="map-canvas"></div>--}}
								{{--</div>--}}

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
