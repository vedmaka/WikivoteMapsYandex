<?php

/**
 * Parameter manipulation ensuring the value is a Yandex Maps map type.
 * 
 * 
 * 
 * @file Maps_ParamYMapType.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * @ingroup MapsYandexMaps
 * 
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsParamYMapType extends ItemParameterManipulation {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterManipulation::doManipulation
	 * 
	 * @since 0.7
	 */	
	public function doManipulation( &$value, Parameter $parameter, array &$parameters ) {
		$value = MapsYandexMaps::$mapTypes[strtolower( $value )];
	}
	
}