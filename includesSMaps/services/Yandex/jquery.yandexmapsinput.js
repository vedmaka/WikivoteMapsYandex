/**
 * JavasSript for the Yandex Map form input of the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v3
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */

(function( $ ){ $.fn.yandexmapsinput = function( mapDivId, options ) {

	var self = this;
	var geocoder = false;
	
	/**
	 * Creates and places a new marker on the map at the provided
	 * coordinate set and the pans to it.
	 * @param {Object} coordinate
	 */	
	this.showCoordinate = function( coordinate ) {
		this.mapDiv.removeMarkers();
        var markerData = {
            title: '',
            icon: '',
            text: coordinate.lat + ',' + coordinate.lon,
            point: new YMaps.GeoPoint(coordinate.lon,coordinate.lat)
        };
		//coordinate.text = coord.dms( coordinate.lat, coordinate.lon );
		this.mapDiv.addMarker( markerData );
		this.mapDiv.map.panTo( new YMaps.GeoPoint(coordinate.lon,coordinate.lat) );
	};
	
	/**
	 * Calls this.showCoordinate with the provided latLng and updates the input field.
	 * @param {Ymaps.GeoPoint} latLng
	 */
	this.showLatLng = function( latLng ) {
		var location = { lat: latLng.getLat(), lon: latLng.getLng() };
		this.showCoordinate( location );
		this.updateInput( [ location ] );		
	};
	
	this.setupGeocoder = function() {
		if ( geocoder === false ) {
			geocoder = new YMaps.Geocoder();
		}
	};

    this.geocodeAddress = function ( address ) {

        var gc = new YMaps.Geocoder( address );
        YMaps.Events.observe(gc, gc.Events.Load, function () {
            if (this.length()) {
                self.showLatLng( this.get(0).getGeoPoint() );
            }else{
                // TODO: i18n
                alert( "Geocode was not successful!" );
            }
        });
    };
	
	this.mapforminput( mapDivId, options );
	
	this.mapDiv.yandex( options );

    YMaps.Events.observe(this.mapDiv.map, this.mapDiv.map.Events.Click, function (map, mEvent) {

        self.showLatLng( mEvent.getGeoPoint() );

    });
	
	return this;
	
}; })( jQuery );