<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPVW_Ajax {

	public static function init() {

		$ajax_events = array(
			'adjust_user_wallet' => false,
			'get_user_balance'   => false
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_wpvw_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_wpvw_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}

	/**
	 * Get a refreshed cart fragment - OMG 3 hours later!!!
	 */
	public static function adjust_user_wallet() {
		parse_str( $_POST['data'], $params );
		extract( $params );

		/** get the user current balance */
		$current_user_balance = floatval( get_user_meta( $user, '_uw_balance', true ) );
		if ( $current_user_balance == '' || ! $current_user_balance ) {
			$current_user_balance = floatval( 0 );
		}

		$credit_amount = floatval( $credit_amount );
		$new_balance   = floatval( 0 );

		if ( $adjustment_type == 'add' ) {
			$new_balance = $current_user_balance + $credit_amount;
		} elseif ( $adjustment_type == 'subtract' ) {
			$new_balance = $current_user_balance - $credit_amount;
		} elseif ( $adjustment_type == 'update' ) {
			$new_balance = $credit_amount;
		}

		/** updaet the users wallet */
		update_user_meta( $user, '_uw_balance', $new_balance );

		$return = array(
			'status'        => true,
			'credit_amount' => $credit_amount,
			'new_balance'   => wc_price( $new_balance ),
			'message'       => "Users blance has been updated to: " . $new_balance
		);

		// Send notification to user
		if ( isset( $notify_user ) ) {
			$user_email = get_user_by( 'ID', $user );

			$to      = $user_email->user_email;
			$subject = apply_filters( 'uw_wallet_email_subject', 'Your wallet has been updated' );
			$message = 'This email is to inform you that your account has been updated at: ' . get_bloginfo( 'name' ) . ' (' . home_url() . ')';

			$footer = apply_filters( 'uw_wallet_email_footer', '' . get_bloginfo( 'name' ) . ' (' . home_url() . ')' );

			if ( strlen( $admin_note ) > 0 ) {
				$message = $admin_note . "
				
				$footer
				";
			}

			wp_mail( $to, $subject, $message );
		}

		print json_encode( $return );

		exit;
	}

	/**
	 * return user balance formated as dollars
	 * @return [type] [description]
	 */
	function get_user_balance() {
		$current_user_balance = get_user_meta( $_POST['user_id'], '_uw_balance', true );
		$return               = array(
			'status'  => true,
			'balance' => wc_price( $current_user_balance )
		);
		print json_encode( $return );
		exit;
	}

}

WPVW_Ajax::init();