<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * display the use wallet for the current logged in user
 * @todo Add options
 */
add_shortcode( 'uw_balance', 'wpuw_wallet_balance_shortcode' );
function wpuw_wallet_balance_shortcode( $atts ) {
	/** do not run if the user is not logged into WP */
	if ( ! is_user_logged_in() ) {
		return false;
	}

	/** shortcode attribute functionality */
	extract( shortcode_atts( array(
		'display_username' => true,
		'separator'        => ':',
		'username_type'    => 'display_name'
	), $atts ) );


	/** @var object the current user object */
	$current_user = wp_get_current_user();
	$output       = '';

	/** deturmine whether to show the username or not */
	if ( $display_username === 'true' ) {
		$output = '<div class="user-credit"><strong>';

		/** which type of user name to display */
		switch ( $username_type ) {
			case 'first_name':
				$output .= $current_user->first_name;
				break;

			case 'last_name':
				$output .= $current_user->last_name;
				break;

			case 'full_name':
				$output .= $current_user->first_name . ' ' . $current_user->last_name;
				break;

			default:
				$output .= $current_user->display_name;
		}

		$output .= '</strong>';

		/** add separator */
		if ( ! empty( $separator ) ) {
			$output .= $separator . ' ';
		}
	}

	$hasBalance = get_user_meta( get_current_user_id(), '_uw_balance', true );
	if ( ! empty( $hasBalance ) ) {
		// Customzed to wrap wc_price with an extra class
		$output .= "<div class='has-balance'> " . wc_price( $hasBalance ) . "</div></div>";
	} else {
		update_user_meta( get_current_user_id(), "_uw_balance", "0.00" );
		$output .= "<div class='no-balance'> " . wc_price( get_user_meta( get_current_user_id(), '_uw_balance', true ) ) . "</div></div>";
	}

	return $output;
}

add_shortcode( 'uw_product_table', 'wpuw_list_products_shortcode' );
function wpuw_list_products_shortcode() {
	/** do not show anything is the user is not logged in */
	if ( ! is_user_logged_in() ) {
		return false;
	}
	
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => get_option( 'post_per_page', 10 ),
		'product_cat'    => 'credit'
	);
	$output = '<table>';
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) :
		$loop->the_post();
		global $product;
		$output .= '<tr>';
		$output .= '<td>' . the_title('','',false) . '</td>';
		$output .= '<td>';
		// Start form
		$output .= '<form id="add_to_cart_' . get_the_ID() . '" method="post">';
		$output .= '<input type="hidden" nae="add-to-cart" value="' . get_the_ID() . '"/>';
		$output .= '<input type="hidden" name="wpuw_add_product" value="1"/>';
		$output .= '</form>';
		// End Form
		// Start "Make Deposit Button"
		$script = "javascript:document.getElementById('add_to_cart_" . get_the_ID() . "').submit();";
		$output .= '<button class="uw-make-deposit" onclick="'.$script.'">Make Deposit</button>';
		// End "Make Deposit Button"
		$output .= '</td>';
		$output .= '</tr>';
		/*
		<tr>
			<td><?php the_title(); ?> </td>
			<td>
				<form id="add_to_cart_<?php echo get_the_ID(); ?>" method="post">
				    <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID(); ?>"/>
				    <input type="hidden" name="wpuw_add_product" value="1"/>
				</form>
				<button class="uw-make-deposit"
				        onclick="javascript:document.getElementById('add_to_cart_<?php echo get_the_ID(); ?>').submit();">
					Make Deposit
				</button>
			</td>
		</tr>
		*/
	endwhile;
	wp_reset_query();
	$output .= '</table>';
	return $output;
}