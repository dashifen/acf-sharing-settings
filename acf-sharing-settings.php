<?php
/**
 * Plugin Name: ACF Sharing Settings
 * Description:  * Description: A plugin to show emergency notifications on georgetown.edu.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 *Version: 1.0
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
