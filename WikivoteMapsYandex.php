<?php
/**
 * Initialization file for the WikivoteMapsYandex extension.
 *
 * @file WikivoteMapsYandex.php
 * @ingroup WikivoteMapsYandex
 *
 * @licence GNU GPL v3
 * @author Wikivote llc < http://wikivote.ru >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.17', '<' ) ) {
	die( '<b>Error:</b> This version of WikivoteMapsYandex requires MediaWiki 1.17 or above.' );
}

if ( !defined( 'Maps_VERSION' ) ) {
    die( 'WikivoteMapsYandex requires Maps extension.' );
}

/* Extension path variables */
$WikivoteMapsYandexScriptPath = ( $wgExtensionAssetsPath === false ? $wgScriptPath . '/extensions' : $wgExtensionAssetsPath ) . '/WikivoteMapsYandex';
$WikivoteMapsYandexDir 	= dirname( __FILE__ ) . '/';

/* Maps: Services */
$egMapsAvailableServices[] = 'yandex';

/* Maps: Yandex Maps Settings */
require_once( dirname( __FILE__ ) . '/WikivoteMapsYandex.settings.php' );

/* Maps: Yandex.Maps initialization for Maps extension */
require_once( dirname( __FILE__ ) . '/includesMaps/services/Yandex/Yandex.php' );

/* Semantic Maps: */
if (defined('SM_VERSION')) {

    /* Semantic Maps: Yandex Maps API */
    require_once( dirname( __FILE__ ) . '/includesSMaps/services/Yandex/SM_YandexMaps.php' );

}

/* Credits page */
$wgExtensionCredits['specialpage'][] = array(
    'path' => __FILE__,
    'name' => 'WikivoteMapsYandex',
    'version' => '0.1',
    'author' => 'Wikivote! llc',
    'url' => '',
    'descriptionmsg' => 'WikivoteMapsYandex-credits',
);

/* Resource modules */
$wgResourceModules['ext.WikivoteMapsYandex.main'] = array(
    'localBasePath' => dirname( __FILE__ ) . '/',
    'remoteExtPath' => 'WikivoteMapsYandex/',
    'group' => 'ext.WikivoteMapsYandex',
    'scripts' => array(),
    'styles' => array()
);

/* Message Files */
$wgExtensionMessagesFiles['WikivoteMapsYandex'] = dirname( __FILE__ ) . '/WikivoteMapsYandex.i18n.php';

/* Autoload classes */
$wgAutoloadClasses['WikivoteMapsYandex'] = dirname( __FILE__ ) . '/WikivoteMapsYandex.class.php';
#$wgAutoloadClasses['WikivoteMapsYandexHooks'] = dirname( __FILE__ ) . '/WikivoteMapsYandex.hooks.php';

/* Rights */
#$wgAvailableRights['example_rights'] = '';

/* Permissions */
#$wgGroupPermissions['sysop']['example_rights'] = true;

/* Special Pages */
#$wgSpecialPages['WikivoteMapsYandex'] = 'WikivoteMapsYandexSpecial';

/* Hooks */
#$wgHooks['example_hook'][] = 'WikivoteMapsYandexHooks::onExampleHook';