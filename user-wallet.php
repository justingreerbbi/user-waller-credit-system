<?php
/**
 * Plugin Name: User Wallet Credit System
 * Plugin URI: http://justin-greer.cm
 * Version: 3.0.1
 * Description: Gives the ability for users to load their wallet balance using WooCommerce. The wallet balance can then be used (if enabled) to make purchases.
 * Author: Justin Greer
 * Author URI: http://justin-greer.com
 * License: GPL2
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 *
 * @author  Justin Greer <justin@justin-greer.com>
 * @package User Wallet
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( ! defined( 'WPUW_FILE' ) ) {
	define( 'WPUW_FILE', __FILE__ );
}

function cgc_ub_action_links( $actions, $user_object ) {

	// This is not displayed to users that can not manage the wallet.
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return $actions;
	}

	$actions['edit_wallet'] = "<a class='cgc_ub_edit_badges' href='" . admin_url( "admin.php?page=wpvw_edit_wallet&amp;ID=$user_object->ID" ) . "'>" . __( 'Edit Wallet', 'cgc_ub' ) . "</a>";

	return $actions;
}

add_filter( 'user_row_actions', 'cgc_ub_action_links', 10, 2 );

require_once( dirname( __FILE__ ) . '/user-wallet-main.php' );

require_once( dirname( __FILE__ ) . '/includes/widget.php' );