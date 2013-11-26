window.onload = function(){
    initialize();
};

var map;
function initialize() {
    var lat_lng = new google.maps.LatLng(-25.392061,-51.469483);
    var mapOptions = {
        zoom: 18,
        center: lat_lng
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

    var marker = new google.maps.Marker({
        position: lat_lng,
        map: map,
        title: 'Hotel Campeão'
    });

}