<?php
/**
 * Plugin Name: ACF Sharing Settings
 * Description: An ACF field group for a settings page relating to how a site appears on Twitter and Facebook.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 *Version: 1.2.0
 */

use Dashifen\WPHandler\Handlers\HandlerException;
use Dashifen\ACFSharingSettings\ACFSharingSettings;

if (file_exists($autoloader = realpath('./vendor/autoloader.php'))) {
    /** @noinspection PhpIncludeInspection */
    
    require_once $autoloader;
}

try {
    (new ACFSharingSettings())->initialize();
} catch (HandlerException $exception) {
    wp_die('Unable to initialize ACF sharing settings.');
}
