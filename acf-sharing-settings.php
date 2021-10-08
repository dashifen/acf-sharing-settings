<?php
/**
 * Plugin Name: ACF Sharing Settings
 * Description: An ACF field group for a settings page relating to how a site appears on Twitter and Facebook.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 * Version: 2.0.0
 */

use Dashifen\WPHandler\Handlers\HandlerException;
use Dashifen\ACFSharingSettings\ACFSharingSettings;

if (!class_exists('Dashifen\ACFSharingSettings\ACFSharingSettings')) {
  require_once 'vendor/autoload.php';
}

(function() {
    try {
        $acfSharingSettings = new ACFSharingSettings();
        $acfSharingSettings->initialize();
    } catch (HandlerException $e) {
        wp_die($e->getMessage());
    }
})();
