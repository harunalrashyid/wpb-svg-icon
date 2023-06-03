<?php

/**
 * Plugin Name: WPBakery SVG Icons
 * Description: Simple svg icon for WPBakery
 * Version: 1.0.0
 * Author: Harun
 * Author URI: https://github.com/harunalrashyid/wpb-svg-icon
 * 
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Current WPBakery Page Builder version
 */
if ( ! defined( 'WPB_VC_VERSION' ) ) {

	add_action('admin_notices', 'wpb_svgi_showVcVersionNotice');

    return;
}

$plugin_file = plugin_basename( __FILE__ );

define( 'WPB_SVGI', $plugin_file );
define( 'WPB_SVGI_VERSION', '1.0.0' );

require_once( __DIR__ . '/includes/WPBSvgIcon.php' );

function wpb_svgi_showVcVersionNotice() {
    ?>
        <div class="notice notice-warning is-dismissible">
            <p>Please Install <a href="https://1.envato.market/A1QAx">WPBakery Page Builder</a> to use WPBakery Lightbox.</p>
        </div>
    <?php
}
