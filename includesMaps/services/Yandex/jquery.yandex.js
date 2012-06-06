/**
 * JavasSript for Yandex Maps maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */

(function( $, mw ){ $.fn.yandex = function( options ) {

    var _this = this;

    this.options = options;
	
	options.types = ensureTypeIsSelectable( options.type, options.types );

    //TODO: fix lang
    YMaps.MapType.PMAP.setName('Народная');

	var types = [];
    this.map = null;
    this.markers = [];
	
	for ( i in options.types ) {
		types.push( eval( options.types[i] ) );
	}
	
	var mapOptions = {
		mapTypes: types
	};
	
	var map = new YMaps.Map( this.get( 0 ) );
    this.map = map;

    map.setType( eval( options.type ) );
	
	var hasSearchBar = false;
	
	for ( var i = options.controls.length - 1; i >= 0; i-- ) {
		if ( options.controls[i] == 'searchbar' ) {
			hasSearchBar = true;
			break;
		}
	}

    this.addMarker = function( markerData ) {
        var nm = createYMarker( markerData );
        this.map.addOverlay(nm);
        this.markers.push( nm );
    };

    //Form inputs functions
    this.removeMarkers = function() {
        for ( var i = this.markers.length - 1; i >= 0; i-- ) {
            this.map.removeOverlay(this.markers[i]);
        }
        this.markers = [];
    };
	
	// List of YControls
	for ( var i = 0, n = options.controls.length; i < n; i++ ) {
		if ( options.controls[i] == 'auto' ) {
			if ( this.get( 0 ).offsetHeight > 75 ) options.controls[i] = this.get( 0 ).offsetHeight > 320 ? 'large' : 'small';
		}

		switch ( options.controls[i] ) {
			case 'large' : 
				map.addControl( new YMaps.ToolBar() );
				break;
			case 'small' : 
				map.addControl( new YMaps.ToolBar([new YMaps.ToolBar.MagnifierButton()]) );
				break;
			case 'large-original' : 
				map.addControl( new YMaps.ToolBar() );
				break;
			case 'small-original' : 
				map.addControl( new YMaps.ToolBar() );
				break;
			case 'zoom' : 
				map.addControl( new YMaps.Zoom() );
				break;
			case 'type' : 
				map.addControl( new YMaps.TypeControl(types) );
				break;				
			case 'type-menu' : 
				map.addControl( new YMaps.TypeControl(types,[1,2,3]) );
				break;
			//case 'overlays' : 
			//	map.addControl( new MoreControl() );
			//	break;		
			case 'overview' : case 'overview-map' : 
				map.addControl( new YMaps.MiniMap() );
				break;
			case 'scale' : 
				if ( hasSearchBar ) {
					map.addControl( new YMaps.ScaleLine(), new YMaps.ControlPosition( BOTTOM_LEFT, new YMaps.Point( 5,37 ) ) );
				}
				else {
					map.addControl( new YMaps.ScaleLine() );
				}
				break;
			/*case 'nav-label' : case 'nav' :
				map.addControl( new GNavLabelControl() );
				break;*/
			case 'searchbar' :
				map.addControl( new YMaps.SearchControl() );
				break;
		}
	}
	
	if ( !options.locations ) {
		options.locations = [];
	}

    var bounds = null;
	if ( ( options.zoom === false || options.centre === false ) && options.locations.length > 1 ) {
        bounds = new YMaps.GeoCollectionBounds();
    }

	for ( i = options.locations.length - 1; i >= 0; i-- ) {

		var location = options.locations[i];
		location.point = new YMaps.GeoPoint( location.lon, location.lat );

        //var mark =
            this.addMarker( location );
		//map.addOverlay( mark );

		if ( bounds != null ) {
            bounds.add( location.point );
        }

	}

	if ( bounds != null ) {
        //console.log(bounds.getCenter(), bounds.getMapZoom(map));
		map.setCenter( bounds.getCenter(), bounds.getMapZoom(map) );
        //map.setBounds(bounds);
	}

	if ( options.centre !== false ) {
		map.setCenter( new YMaps.GeoPoint( options.centre.lon, options.centre.lat ) );
	}

    if ( bounds == null && options.centre === false) {
        if (options.locations.length > 0)
            map.setCenter( new YMaps.GeoPoint( options.locations[0].lon, options.locations[0].lat ) );
    }
	
	if ( options.zoom !== false ) {
		map.setZoom( options.zoom );
	}
	
	if ( options.autozoom ) {
		map.enableScrollZoom();
	}

	//map.enableContinuousZoom();
	
	// Code to add KML files.
	for ( i = options.kml.length - 1; i >= 0; i-- ) {
		map.addOverlay( new YMaps.KML( options.kml[i] ) );
	}
	
	if ( options.resizable ) {
		mw.loader.using( 'ext.maps.resizable', function() {
			_this.resizable();
		} );
	}
	
    function ensureTypeIsSelectable( type, types ) {
    	var typesContainType = false;

    	for ( var i = 0, n = types.length; i < n; i++ ) {
    		if ( types[i] == type ) {
    			typesContainType = true;
    			break;
    		}
    	}

    	if ( !typesContainType ) {
    		types.push( type );
    	}
    	
    	return types;
    }

    /**
     * Returns YMarker object on the provided location. It will show a popup baloon
     * with title and label when clicked, if either of these is set.
     */
	function createYMarker( markerData ) {
    	var marker;

        var s = null;

    	if ( markerData.icon !== '' ) {

            //var newImg = new Image();
            //newImg.src = markerData.icon;
            s = new YMaps.Style();
            s.iconStyle = new YMaps.IconStyle();
            s.iconStyle.href = markerData.icon;

            //TODO: fix that
            s.iconStyle.size = new YMaps.Point(18, 29);


    	}

        var options = {};

    	if ( markerData.text !== '' ) {

             options = {
                style: s,
                hintOptions: {
                    maxWidth: 350
                }
             };

            marker = new YMaps.Placemark( markerData.point, options );
            marker.setBalloonContent('<div style="overflow:auto;max-height:130px;">' + markerData.text + '</div>');
    	}else{

            options = { hasBalloon: false, style: s };
            marker = new YMaps.Placemark( markerData.point, options );

        }

    	return marker;
    }
	
	return this;
	
}; })( jQuery, mediaWiki );