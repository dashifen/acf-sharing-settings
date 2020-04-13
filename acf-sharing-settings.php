<?php

/**
 * Plugin Name: ACF Sharing Settings
 * Description: An ACF field group for a settings page relating to how a site appears on Twitter and Facebook.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 * Version: 1.5.4
 *
 * @noinspection PhpStatementHasEmptyBodyInspection
 * @noinspection PhpIncludeInspection
 */

use Dashifen\WPHandler\Handlers\HandlerException;
use Dashifen\ACFSharingSettings\ACFSharingSettings;

if (file_exists($autoloader = dirname(ABSPATH) . '/deps/vendor/autoload.php'));
elseif ($autoloader = file_exists(dirname(ABSPATH) . '/vendor/autoload.php'));
elseif ($autoloader = file_exists(ABSPATH . 'vendor/autoload.php'));
else $autoloader = 'vendor/autoload.php';
require_once $autoloader;

(function() {
    try {
        $acfSharingSettings = new ACFSharingSettings();
        $acfSharingSettings->initialize();
    } catch (HandlerException $e) {
        wp_die($e->getMessage());
    }
})();
