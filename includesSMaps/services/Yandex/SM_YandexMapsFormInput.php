<?php

/**
 * Yandex Maps form input class.
 *
 * @since 1.0
 * @file SM_YandexMapsFormInput.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v3
 * @author Vedmaka <god.vedmaka@gmail.com>, based on code from Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMYandexMapsFormInput extends SMFormInput {
	
	/**
	 * @see SMFormInput::getResourceModules
	 * 
	 * @since 1.0
	 * 
	 * @return array of string
	 */
	protected function getResourceModules() {
		return array_merge( parent::getResourceModules(), array( 'ext.sm.fi.yandex' ) );
	}	
	
}
