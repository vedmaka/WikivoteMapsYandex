<?php

/**
 * This file holds the general information for the Yandex Maps service.
 *
 * @file SM_YandexMaps.php
 * @ingroup SMYandexMaps
 *
 * @licence GNU GPL v3
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$moduleTemplate = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteBasePath' => $WikivoteMapsYandexScriptPath .  '/includesSMaps/services/Yandex',
	'group' => 'ext.semanticmaps',
);

$wgResourceModules['ext.sm.fi.yandex'] = $moduleTemplate + array(
	'dependencies' => array( 'ext.maps.yandex', 'ext.sm.forminputs', 'ext.sm.fi.yandex.single' ),
	'scripts' => array(
		'ext.sm.yandexmapsinput.js'
	),
);

$wgResourceModules['ext.sm.fi.yandex.single'] = $moduleTemplate + array(
	//'dependencies' => array( 'ext.sm.fi.yandex' ),
	'scripts' => array(
		'jquery.yandexmapsinput.js',
	),
	'messages' => array(
	)
);

unset( $moduleTemplate );

$wgHooks['MappingServiceLoad'][] = 'smfInitYandexMaps';

function smfInitYandexMaps() {
	global $wgAutoloadClasses;
	
	$wgAutoloadClasses['SMYandexMapsFormInput'] = dirname( __FILE__ ) . '/SM_YandexMapsFormInput.php';
	
	MapsMappingServices::registerServiceFeature( 'yandex', 'qp', 'SMMapPrinter' );
	MapsMappingServices::registerServiceFeature( 'yandex', 'fi', 'SMYandexMapsFormInput' );
	
	return true;
}
