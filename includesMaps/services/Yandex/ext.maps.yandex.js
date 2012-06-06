/**
 * JavasSript for Yandex Maps maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */

jQuery(document).ready(function() {
		
		for ( i in window.mwmaps.yandex ) {
			jQuery( '#' + i ).yandex( window.mwmaps.yandex[i] );
		}

});
	