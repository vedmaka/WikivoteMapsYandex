<?php

/**
 * Class holding information and functionallity specific to Yandex Maps.
 * This infomation and features can be used by any mapping feature. 
 * 
 * @since 0.1
 * 
 * @file Maps_YandexMaps.php
 * @ingroup MapsYandexMaps
 * 
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsYandexMaps extends MapsMappingService {
	
	/**
	 * A list of supported overlays.
	 * 
	 * @var array
	 */
	protected static $overlayData = array(
		'photos' => '0',
		'videos' => '1',
		'wikipedia' => '2',
		'webcams' => '3'
	);		
	
	/**
	 * Constructor.
	 * 
	 * @since 0.6.6
	 */
	function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			array( 'yandex', 'ymap', 'ymaps' )
		);
	}
	
	/**
	 * @see MapsMappingService::addParameterInfo
	 * 
	 * @since 0.7
	 */
	public function addParameterInfo( array &$params ) {
		global $egMapsYandexMapsType, $egMapsYandexMapsTypes, $egMapsYandexAutozoom;
		global $egMapsYMapControls, $egMapsYMapOverlays, $egMapsResizableByDefault;
		
		$params['zoom']->addCriteria( new CriterionInRange( 0, 20 ) );
		$params['zoom']->setDefault( self::getDefaultZoom() );
		
		$params['controls'] = new ListParameter( 'controls' );
		$params['controls']->setDefault( $egMapsYMapControls );
		$params['controls']->addCriteria( new CriterionInArray( self::getControlNames() ) );
		$params['controls']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );		
		$params['controls']->setMessage( 'maps-googlemaps2-par-controls' );
		
		$params['type'] = new Parameter(
			'type',
			Parameter::TYPE_STRING,
			$egMapsYandexMapsType, // FIXME: default value should not be used when not present in types parameter.
			array(),
			array(
				new CriterionInArray( array_keys( self::$mapTypes ) ),
			),
			array( 'types' )		
		);
		$params['type']->addManipulations( new MapsParamYMapType() );
		$params['type']->setMessage( 'maps-googlemaps2-par-type' );

		$params['types'] = new ListParameter(
			'types',
			ListParameter::DEFAULT_DELIMITER,
			Parameter::TYPE_STRING,
			$egMapsYandexMapsTypes,
			array(),
			array(
				new CriterionInArray( array_keys( self::$mapTypes ) ),
			)
		);
		$params['types']->addManipulations( new MapsParamYMapType() );
		$params['types']->setMessage( 'maps-googlemaps2-par-types' );		
		
		$params['autozoom'] = new Parameter(
			'autozoom',
			Parameter::TYPE_BOOLEAN,
			$egMapsYandexAutozoom
		);
		$params['autozoom']->setMessage( 'maps-googlemaps2-par-autozoom' );
		
		$params['kml'] = new ListParameter( 'kml' );
		$params['kml']->setDefault( array() );
		//$params['kml']->addManipulations( new MapsParamFile() );
		$params['kml']->setMessage( 'maps-googlemaps2-par-kml' );
		
		$params['overlays'] = new ListParameter( 'overlays' );
		$params['overlays']->setDefault( $egMapsYMapOverlays );
		$params['overlays']->addCriteria( new CriterionYandexOverlay( self::$overlayData ) );
		$params['overlays']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) ); // TODO
		$params['overlays']->setMessage( 'maps-googlemaps2-par-overlays' );
		
		$params['resizable'] = new Parameter( 'resizable', Parameter::TYPE_BOOLEAN );
		$params['resizable']->setDefault( $egMapsResizableByDefault, false );
		$params['resizable']->setMessage( 'maps-par-resizable' );
	}
	
	/**
	 * @see iMappingService::getDefaultZoom
	 * 
	 * @since 0.6.5
	 */
	public function getDefaultZoom() {
		global $egMapsYandexMapsZoom;
		return $egMapsYandexMapsZoom;
	}
	
	/**
	 * Returns all possible values for the overlays parameter.
	 * 
	 * @since 0.7.1
	 * 
	 * @return array
	 */
	public function getOverlayNames() {
		return array_keys( self::$overlayData );
	}

	/**
	 * @see MapsMappingService::getMapId
	 * 
	 * @since 0.6.5
	 */
	public function getMapId( $increment = true ) {
		static $mapsOnThisPage = 0;
		
		if ( $increment ) {
			$mapsOnThisPage++;
		}
		
		return 'map_yandex_' . $mapsOnThisPage;
	}

	/**
	 * @see MapsMappingService::getMapObject
	 * 
	 * @since 1.0
	 */
	public function getMapObject() {
		
	}
	
	/**
	 * A list of mappings between supported map type values and their corresponding JS variable.
	 * 
	 * 
	 * 
	 * @var array
	 */ 
	public static $mapTypes = array(
		'normal' => 'YMaps.MapType.MAP',
		'satellite' => 'YMaps.MapType.SATELLITE',
		'hybrid' => 'YMaps.MapType.HYBRID',
		'physical' => 'YMaps.MapType.PMAP'
	);
	
	/**
	 * Returns the names of all supported controls. 
	 * This data is a copy of the one used to actually translate the names
	 * into the controls, since this resides client side, in YandexMapFunctions.js. 
	 * 
	 * @return array
	 */
	public static function getControlNames() {
		return array(
			'auto',
			'large',
			'small',
			'large-original',
			'small-original',
			'zoom',
			'type',
			'type-menu',
			'overlays',
			'overview',
			'overview-map',
			'scale',
			'nav-label',
			'nav',
			'searchbar'
		);
	}
	
	/**
	 * @see MapsMappingService::getDependencies
	 * 
	 * @return array
	 */
	protected function getDependencies() {
		global $wgLang;
		global $egYandexMapsKeys, $egYandexMapsKey;
		
		$langCode = self::getMappedLanguageCode( $wgLang->getCode() ); 
		
		$dependencies = array();
		
		$dependencies[] = Html::linkedScript( "http://api-maps.yandex.ru/1.1/index.xml?key=$egYandexMapsKey&hl=$langCode&modules=pmap~metro" );
		
		$dependencies[] = Html::inlineScript(
			'var yandexMapsKey = '. FormatJson::encode( $egYandexMapsKey ) . ';' .
			'var yandexMapsKeys = '. FormatJson::encode( $egYandexMapsKeys ) . ';'  .
			'var yandexLangCode = '. FormatJson::encode( $langCode ) . ';'
		);

		return $dependencies;
	}
	
	/**
	 * Maps language codes to Yandex Maps API compatible values.
	 * 
	 * @param string $code
	 * @return string The mapped code
	 */
	protected static function getMappedLanguageCode( $code ) {
		$mappings = array(
	         'en_gb' => 'en',// v2 does not support en_gb - use english :(
	         'he' => 'iw',   // iw is googlish for hebrew
	         'fj' => 'fil',  // google does not support Fijian - use Filipino as close(?) supported relative
	         'or' => 'en'    // v2 does not support Oriya.
		);
		
		if ( array_key_exists( $code, $mappings ) ) {
			$code = $mappings[$code];
		}
		
		return $code;
	}
	
	/**
	 * This function ensures backward compatibility with Semantic Yandex Maps and other extensions
	 * using $wgYandexMapsKey instead of $egYandexMapsKey.
	 */
	public static function validateYandexMapsKey() {
		global $egYandexMapsKey, $wgYandexMapsKey;
		
		if ( isset( $wgYandexMapsKey ) &&  $egYandexMapsKey !== '' ) {
			$egYandexMapsKey = $wgYandexMapsKey;
		}
	}
	
	/**
	 * @see MapsMappingService::getResourceModules
	 * 
	 * @since 1.0
	 * 
	 * @return array of string
	 */
	public function getResourceModules() {
		return array_merge(
			parent::getResourceModules(),
			array( 'ext.maps.yandex' )
		);
	}
	
}								