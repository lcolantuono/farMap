		var lat, lng;
		var puntos = new Array();
		var map;
		var geocoder;
		var bounds = new google.maps.LatLngBounds();
		var markersArray = [];
		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
		var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';
		var origin1;
		
		function initialize() {
			directionsDisplay = new google.maps.DirectionsRenderer();
			var opts = {
				center : new google.maps.LatLng(lat, lng),
				zoom : 12
			};
			map = new google.maps.Map(document.getElementById('mapa'), opts);
			directionsDisplay.setMap(map);
			geocoder = new google.maps.Geocoder();
		}

		function calcRoute(cantidad) {
			var or = new google.maps.LatLng(lat, lng);
			var des = new google.maps.LatLng(puntos[cantidad].latitud, puntos[cantidad].longitud);
			var request = {
				origin : origin1,
				destination : des,
				travelMode : google.maps.TravelMode.DRIVING
			};
			directionsService.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(result);
				}
			});
		}

		function addMarker(location, isDestination, nombre) {
			var icon;
			if (isDestination) {
				icon = destinationIcon;
			} else {
				icon = originIcon;
			}
			geocoder
					.geocode(
							{
								'address' : location
							},
							function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									bounds.extend(results[0].geometry.location);
									map.fitBounds(bounds);
									if (nombre == null) {
										nombre = "Donde estoy ahora";
										var marker = new google.maps.Marker(
												{
													title : nombre,
													map : map,
													position : results[0].geometry.location,
													icon: icon
												});
										markersArray.push(marker);
									} else
										var marker = new google.maps.Marker(
												{
													title : nombre,
													map : map,
													position : results[0].geometry.location,
													icon : icon
															
												});
									markersArray.push(marker);
								} else {
									alert('Geocode was not successful for the following reason: '
											+ status);
								}
							});
		}

		function OK(position) {
			lat = position.coords.latitude;
			lng = position.coords.longitude;
			origin1 = new google.maps.LatLng(lat, lng);
			ajax();

		}

		function showlocation() {
			navigator.geolocation.getCurrentPosition(OK);
		}

		showlocation();

		function calculateDistances() {
			var service = new google.maps.DistanceMatrixService();
			
			var arreglo = new Array();

			for ( var i = 0; i < puntos.length; i++) {
				arreglo[i] = new google.maps.LatLng(puntos[i].latitud,
						puntos[i].longitud);
			}
			service.getDistanceMatrix({
				origins : [ origin1 ],
				destinations : arreglo,
				travelMode : google.maps.TravelMode.DRIVING,
				unitSystem : google.maps.UnitSystem.METRIC,
				avoidHighways : false,
				avoidTolls : false
			}, callback);
		}

		function mostrarMapa(la, lo) {
			//calculateDistances();
			//$("#mapa").css({visibility: "visible", width: "100%", height: "90%"});
			//$("#listado").css({width: "20%", position: "absolute", right: "0px"});
			//$("#listado").css("display", "none");
		}
		function callback(response, status) {
			if (status != google.maps.DistanceMatrixStatus.OK) {
				//alert('Error was: ' + status);
			} else {
				var origins = response.originAddresses;
				var destinations = response.destinationAddresses;
				var results = response.rows[0].elements;
				deleteOverlays();
				//addMarker(origins[0], false);
				//$("#listado").append(
				//		'<div class="btn-group"> <button type="button" class="btn btn-danger">Farmacias Cercanas</button> <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">   <span class="caret"></span>    <span class="sr-only">Toggle Dropdown</span>  </button>	  <ul class="dropdown-menu" role="menu">');
				for ( var j = 0; j < results.length; j++) {
					//addMarker(destinations[j], true, puntos[j].nombre);
//					if(j==0){
//						$active='active';
//					}else{
//						$active='';
//					}
					$(".btn-group .dropdown-menu").append(
							'<li><a onclick=mostrarMapa('
									+ puntos[j].latitud + ','
									+ puntos[j].longitud
									+ ');calcRoute('+j+');><b>Farmacia: '
									+ puntos[j].nombre + '</b> <p> Dirección ' + ' - '
									+ puntos[j].direccion + ' </br> '
									+ results[j].duration.text + ' - ' + ': '
									+ results[j].distance.text
									+ '</p></a></li>');
				}
				//$("#listado").append(
				//'</ul></div>');

			}
		}
		function deleteOverlays() {
			for ( var i = 0; i < markersArray.length; i++) {
				markersArray[i].setMap(null);
			}
			markersArray = [];
		}
		google.maps.event.addDomListener(window, 'load', initialize);