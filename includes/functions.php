<?php if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * General Key Gen Function
 * @return String Random Key
 */
function wpuw_gen_key( $length=40 ){
  return wp_generate_password( $length, false );
}


// Add custom product fields to woocommerce
add_action( 'woocommerce_product_options_general_product_data', 'wpuw_add_custom_general_fields' );
function wpuw_add_custom_general_fields() {
	global $woocommerce, $post;
	$terms = wp_get_post_terms( $post->ID, 'product_cat' );
	foreach ( $terms as $term ) $categories[] = $term->slug;
	if( !empty( $categories ) && in_array( 'credit',$categories ) ) {
		echo '<div class="options_group">';
		woocommerce_wp_text_input(
			array(
				'id'          => '_credits_amount',
				'label'       => __( 'Credit Amount (' . get_woocommerce_currency_symbol().')', 'woocommerce' ),
				'placeholder' => '0.00',
				'desc_tip'    => 'true',
				'description' => __( 'The amount of credits for this product in currency format.', 'woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' 	=> 'any',
					'min'	=> '0'
				)
			)
		);
		echo '</div>';
	}
}

/**
 * [woo_add_custom_general_fields_save description]
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
add_action( 'woocommerce_process_product_meta', 'wpuw_add_custom_general_fields_save' );
function wpuw_add_custom_general_fields_save ( $post_id ){
	$woocommerce_credits_amount = @$_POST['_credits_amount'];
	if(!empty( $woocommerce_credits_amount ) ){
		update_post_meta( $post_id, '_credits_amount', esc_attr( $woocommerce_credits_amount ) );
	}
}

/**
 * [add_credits_to_user_account description]
 * @param [type] $order_id [description]
 *
 * @since 1.1 - Now fired on woocommerce_order_status_completed action. This is a change to rid infinite reloads 
 * of credits after pruchase.
 */
add_action( 'woocommerce_order_status_completed', 'wpuw_add_credits_to_user_account' );
function wpuw_add_credits_to_user_account ( $order_id ){
	$order = new WC_Order( $order_id );
	if ( count( $order->get_items() ) > 0 ){
		foreach ( $order->get_items() as $item ) {
	    	$product_name = $item['name'];
	    	$product_id = $item['product_id'];
	    	$product_variation_id = $item['variation_id'];
	    	$credit_amount = floatval(get_post_meta($product_id, "_credits_amount", true));
	    	$current_users_wallet_ballance = floatval(get_user_meta(get_current_user_id(),"_uw_balance", true));
	    	update_user_meta(get_current_user_id(), "_uw_balance", ($credit_amount+$current_users_wallet_ballance));
		}
	}
}

/**
 * [custom_woocommerce_auto_complete_order description]
 * @param  [type] $order_id [description]
 * @return [type]           [description]
 */
add_action( 'woocommerce_thankyou', 'wpuw_custom_woocommerce_auto_complete_order' );
function wpuw_custom_woocommerce_auto_complete_order( $order_id ){
	if ( !$order_id ){
	   return;
	}
	 
	$order = new WC_Order( $order_id );
	if ( count( $order->get_items() ) > 0 ) {
		foreach ( $order->get_items() as $item ) {
		   	if( has_term( 'credit', 'product_cat', $item['product_id'] ) ){
		   		$order->update_status( 'completed' );
		   	}
		}
	}
}