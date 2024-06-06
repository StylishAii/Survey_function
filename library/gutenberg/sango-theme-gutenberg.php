<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_version = wp_get_theme(get_template())->get('Version');

define( "SGB_VER_NUM", $current_version );

require_once dirname( __FILE__ ) . '/vendor/autoload.php';
require_once dirname( __FILE__ ) . '/dist/init.php';
require_once dirname( __FILE__ ) . '/dist/shutdown.php';
