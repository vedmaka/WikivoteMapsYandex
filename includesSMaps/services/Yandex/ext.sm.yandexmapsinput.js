/**
 * JavasSript for the Yandex Map form input in the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v3
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */

jQuery(document).ready(function() {
	if ( true ) { // TODO
		for ( i in window.mwmaps.yandex_forminputs ) {
			if ( window.mwmaps.yandex_forminputs[i].ismulti ) {
				jQuery( '#' + i + '_forminput' ).ymapsmultiinput( i, window.mwmaps.yandex_forminputs[i] );
			}
			else {
				jQuery( '#' + i + '_forminput' ).yandexmapsinput( i, window.mwmaps.yandex_forminputs[i] );
			}
		}
	}
	else {
		alert( mediaWiki.msg( 'maps-googlemaps3-incompatbrowser' ) );
		
		for ( i in window.mwmaps.yandex_forminputs ) {
			jQuery( '#' + i + '_forminput' )
				.html( $( '<input />' )
					.attr( { 'name': i, 'value': semanticMaps.buildInputValue( window.mwmaps.yandex_forminputs[i].locations ) } )
				);
		}
	}	
});
