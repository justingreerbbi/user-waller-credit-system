<?php
/**
 * Plugin Name: User Wallet Credit System
 * Plugin URI: http://justin-greer.cm
 * Version: 1.3
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
if ( ! function_exists( 'add_filter' ) ){
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! defined( 'WPUW_FILE' ) ){
	define( 'WPUW_FILE', __FILE__ );
}

require_once( dirname( __FILE__ ) . '/user-wallet-main.php' );