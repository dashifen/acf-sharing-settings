<?php

/**
 * Plugin Name: ACF Sharing Settings
 * Description: An ACF field group for a settings page relating to how a site appears on Twitter and Facebook.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 * Version: 1.2.0
 *
 * @noinspection PhpStatementHasEmptyBodyInspection
 * @noinspection PhpIncludeInspection
 */

use Dashifen\WPHandler\Handlers\HandlerException;
use Dashifen\ACFSharingSettings\ACFSharingSettings;

(function () {
    try {
        ACFSharingSettings::requireAutoloader();
        $acfSharingSettings = new ACFSharingSettings();
        $acfSharingSettings->initialize();
    } catch (HandlerException $e) {
        wp_die($e->getMessage());
    }
})();
