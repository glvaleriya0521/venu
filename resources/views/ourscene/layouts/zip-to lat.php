//convert zipcode to lon and lat
// function lonlat(zipcode) {

// 		var zipCode = zipcode;
// 		var lat, lon;

// 		var xhr = $.get('https://maps.googleapis.com/maps/api/geocode/json?address=' + zipCode + '&key=AIzaSyDVPLLlJAQ679Frd0gu11khJ9mW02wsvWQ');

// 		xhr.done(function(data) {
// 			lat = data.results[0].geometry.location.lat;
// 			lon = data.results[0].geometry.location.lng;
// 			console.log('2-', lat);
// 		});
// 		console.log('3-', xhr);
// 		setTimeout(function(){console.log('1-lat,lon', lat);},2000);
// }

// var lat, lon, latlon;
// latlon = lonlat('90267');
// alert(latlon.lat);