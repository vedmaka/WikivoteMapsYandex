<?php
/**
 *
 *
 * @file WikivoteMapsYandex.settings.php
 * @ingroup
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 */

# Yandex Maps

# Your Yandex Maps API key. Required for displaying Yandex Maps, and using the
$egYandexMapsKey = '';

# If your wiki is accessable via multiple urls, you'll need multiple keys.
# Example: $egYandexMapsKeys['http://yourdomain.tld/something'] = 'your key';
$egYandexMapsKeys = array();

# Integer. The default zoom of a map. This value will only be used when the
# user does not provide one.
$egMapsYandexMapsZoom = 14;

# Array of String. The Yandex Maps default map types. This value will only
# be used when the user does not provide one.
$egMapsYandexMapsTypes = array(
    'normal',
    'satellite',
    'hybrid',
    'physical'
);

# String. The default map type. This value will only be used when the user does
# not provide one.
$egMapsYandexMapsType = 'normal';

# Boolean. The default value for enabling or disabling the autozoom of a map.
# This value will only be used when the user does not provide one.
$egMapsYandexAutozoom = true;

# Array of String. The default controls for Yandex Maps. This value will
# only be used when the user does not provide one.
# Available values: auto, large, small, large-original, small-original, zoom,
# type, type-menu, overview-map, scale, nav-label, overlays
$egMapsYMapControls = array(
    'auto',
    'scale',
    'type',
    'overlays',
    'zoom'
);

# Array. The default overlays for the Yandex Maps overlays control, and
# whether they should be shown at pageload. This value will only be used when
# the user does not provide one.
# Available values: photos, videos, wikipedia, webcams
$egMapsYMapOverlays = array(
    'photos',
    'videos',
    'wikipedia',
    'webcams'
);

