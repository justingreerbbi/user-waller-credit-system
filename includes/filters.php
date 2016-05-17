<?php if ( ! defined( 'ABSPATH' ) ) { exit; }


add_filter("wpuw_Errors", "wpuw_error_filter", 1);
function wpuw_error_filter ( $errors )
{
	$errors["system_error"] = "There was a system error";
	return $errors;
}

////////////////////////////////////////////////////////////////////////
///
/// WOOCOMMERCE HOOKS 
///
////////////////////////////////////////////////////////////////////////

/**
 * Functionality to redirect the user to the checkout page ONLY making a deposit.
 * Since credits should only be addeded using the shortcode the follwing redirect should
 * work just fine.
 *
 * @todo Possibly give the user the ability to change the logic of how this works
 */
add_filter ('woocommerce_add_to_cart_redirect', 'wpuw_redirect_to_checkout');
function wpuw_redirect_to_checkout () {
	if( isset($_POST['wpuw_add_product']) ){
		$product_id = (int) apply_filters('woocommerce_add_to_cart_product_id', $_POST['add-to-cart']);
		if( has_term( 'credit', 'product_cat', $product_id ) ){
			global $woocommerce;
			wc_clear_notices();
			return $woocommerce->cart->get_checkout_url();
		}
	}
}

add_filter ('woocommerce_add_cart_item_data', 'wpuw_clear_cart_items');
function wpuw_clear_cart_items ( $cart_item_data ){
	global $woocommerce;
	foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
	  	if( has_term('credit', 'product_cat', $cart_item['product_id']) ){
	  		global $woocommerce;
	  		$woocommerce->cart->set_quantity( $cart_item_key, 0 );
	    }
  	}
  return $cart_item_data;
}

/**
 * Functionality to change the button text for all credit buttons while not messing with
 * any ther products in the store
 *
 * @todo Right now this feature is static mening it an not be changed without changing this code.
 * I need to add the functionlity to give the user and option to defined cutom text in wp-admin.
 * OR this could be a filter setting as well for extendabilty options for developers.
 */
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text () 
{
	global $product;
	if( has_term( 'credit', 'product_cat', $product->ID) )
		return __( 'Buy Now', 'woocommerce' );

	/** default */
	return __( 'Add to cart', 'woocommerce' );
}

/**
 * Excludes Credit Products from the store listing. This keeps the items seperate
 * and does not confuse the customer as wel as limiting the headace on the logic in the backend.
 *
 * @link(WooCodex, http://docs.woothemes.com/document/exclude-a-category-from-the-shop-page/)
 */
add_action( 'pre_get_posts', 'custom_pre_get_posts_query_for_credit' );
function custom_pre_get_posts_query_for_credit( $q ) 
{
	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;
	
	if ( ! is_admin() && is_shop() ) 
	{
		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'credit' ),
			'operator' => 'NOT IN'
		)));
	}
	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query_for_credit' ); 
}
