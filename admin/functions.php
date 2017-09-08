<?php

/**
 * Setup the admin tabs as needed
 *
 * @param $page
 * @param $tabs
 * @param $location
 * @param $default
 * @param null $current
 */
function lc_pro_admin_tabs( $page, $tabs, $location, $default, $current = null ) {
	if ( is_null( $current ) ) {
		if ( isset( $_GET['tab'] ) ) {
			$current = $_GET['tab'];
		} else {
			$current = $default;
		}
	}
	$content = '';
	$content .= '<h2 class="nav-tab-wrapper">';
	foreach ( $tabs as $tab => $tabname ) {
		if ( $current == $tab ) {
			$class = ' nav-tab-active';
		} else {
			$class = '';
		}
		$content .= '<a class="nav-tab' . $class . '" href="?page=' .
		            $page . '&tab=' . $tab . '">' . $tabname . '</a>';
	}
	$content .= '</h2>';
	echo $content;
	if ( ! $current ) {
		$current = key( $tabs );
	}
	require_once( $location . $current . '.php' );

	return;
}

function lc_pro_display_settings_tabs() {
	$tabs         = apply_filters( 'wpuw_admin_tabs', array(
		'general' => 'General',
	) );
	$settings_tab = 'wpvw_settings';
	echo lc_pro_admin_tabs( $settings_tab, $tabs, dirname( __FILE__ ) . '/tabs/', 'general', null );
}