<?php

/**
 * This file holds the hook and initialization for the Yandex Maps service.
 *
 * @file YandexMaps.php
 * @ingroup MapsYandexMaps
 *
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgResourceModules['ext.maps.yandex'] = array(
	'dependencies' => array( 'ext.maps.common' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteBasePath' => $WikivoteMapsYandexScriptPath .  '/includesMaps/services/Yandex',
	'group' => 'ext.maps',
	'scripts' => array(
		'jquery.yandex.js',
		'ext.maps.yandex.js',
	),
	'styles' => array(

	),
	'messages' => array(
		'maps-markers',
		'maps_overlays',
		'maps_photos',
		'maps_videos',
		'maps_wikipedia',
		'maps_webcams',
		'maps-googlemaps2-incompatbrowser'
	)
);

$wgHooks['MappingServiceLoad'][] = 'efMapsInitYandexMaps';

/**
 * Initialization function for the Yandex Maps service.
 *
 * @ingroup MapsYandexMaps
 * @return true
 */
function efMapsInitYandexMaps() {
	global $wgAutoloadClasses;

	$wgAutoloadClasses['MapsYandexMaps'] 			= dirname( __FILE__ ) . '/Maps_YandexMaps.php';
	$wgAutoloadClasses['CriterionYandexOverlay'] 	= dirname( __FILE__ ) . '/CriterionYandexOverlay.php';
	$wgAutoloadClasses['MapsParamYMapType']		 	= dirname( __FILE__ ) . '/Maps_ParamYMapType.php';

	MapsMappingServices::registerService( 'yandex', 'MapsYandexMaps' );
	$yandexMaps = MapsMappingServices::getServiceInstance( 'yandex' );
    $yandexMaps->addFeature( 'display_point', 'MapsBasePointMap' );
    $yandexMaps->addFeature( 'display_map', 'MapsBaseMap' );

	return true;
}
