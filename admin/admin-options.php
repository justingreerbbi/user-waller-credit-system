<?php if ( ! defined( 'ABSPATH' ) ) { exit; }

class WPVW_Admin_Options {

	/**
	 * WO Options Name
	 * @var string
	 */
	protected $option_name = 'wpvw_options';

	/**
	 * [_init description]
	 * @return [type] [description]
	 */
	public static function init() {
		add_action('admin_init', array(new self, 'admin_init'));
		add_action('admin_menu', array(new self, 'add_page'));
	}

	/** register the dependant settings */
	public function admin_init() {
	    register_setting('wpvw_options', $this->option_name, array($this, 'validate'));
	}

	/** add the plugin option page to the admin menu */
	public function add_page(){
	    add_submenu_page('woocommerce', 'User Wallet Options', 'User Wallet', 'manage_woocommerce', 'wpvw_settings', array( $this, 'options_do_page'));
	}

	/** load dependant scripts and styles */
	public function admin_head(){
		wp_enqueue_style( 'wpvw_admin' );
		wp_enqueue_script( 'wpvw_admin' );
		wp_enqueue_script( 'jquery-ui-tabs' );
	}

	/**
	 * [options_do_page description]
	 * @return [type] [description]
	 */
	public function options_do_page() {
	    $options = get_option( $this->option_name );
    	$this->admin_head();
    	add_thickbox();
	    ?>
	    		<div class="wrap">
	    			<!--<div class="updated">
				        <p>This version of Virtual Wallet is licensed to EJ for use and modification but not distribution.</p>
				    </div>-->
	        	<h2>User Wallet</h2>
	        	<p>A Woocommerce Extension for allowing users to load and use virtual balance for products.</p>
	       
	        	<form method="post" action="options.php">
	          	<?php settings_fields('wpvw_options'); ?>

	          	<div id="wo_tabs">
								<ul>
							  	<li><a href="#dashboard">Dashboard</a></li>
							  	<li><a href="#configuration">Configuration</a></li>
								</ul>
							  
								<!-- GENERAL SETTINGS -->
								<div id="dashboard">
							  	<table class="form-table">
			            	<tr valign="top">
			            		<th scope="row">Adjust User Wallets:</th>
			                	<td>
			                  	<a class="thickbox button button-primary" href="#TB_inline?width=600&height=550&inlineId=adjust-credits-single-user" title="Adjust User's Virtual Wallet Balance">Select a User</a> 
			                	</td>
			              	</tr>
			            </table>  
							  </div>
 
							  <!-- ADVANCED CONFIGURATION -->
							  <div id="configuration">
							  	<h2>Configuration</h2>

									<table class="form-table">
			              <tr valign="top">
			               	<th scope="row">Show balance on checkout option</th>
			                  <td>
			                  	<input name="show_balance_on_checkout_option" type="checkbox" />
			              	  </td>
			              </tr>
			      			</table>
							  </div>

							</div>
	            
	            <p class="submit">
	                <!--<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />-->
	            </p>
	        </form>

	        <!-- ADD NEW CLIENT HIDDEN FROM -->
	        <div id="adjust-credits-single-user" style="display:none;">
						<div class="wo-popup-inner">
							<h3 class="header">Adjust Wallet Balances</h3>
							<form id="adjust-users-virtual-wallet" action="/" method="get">
								<p>
									<label>Select A User: </label>
									<select id="onchange-get-balance" name="user">
										<?php
										$users = get_users();
										foreach ( $users as $user ) {
											echo '<option value="'.$user->ID.'">' . esc_html( $user->user_login ) . ' - ('.wc_price(get_user_meta($user->ID,'_uw_balance', true)).')</option>';
										}
										?>
									</select>
									<span class="selected-user-balance"></span>
								</p>

								<p>
									<label>Action: </label>
									<select name="adjustment_type">
										<option value="add">Add</option>
										<option value="subtract">Subtract</option>
										<option value="update">Update</option>
									</select>
								</p>

								<p>
									<label>Credit Amount: </label>
									<input type="text" name="credit_amount" placeholder="Enter Adjustment"/>
								</p>

								<p>
									<label>Notify the User: </label>
									<input type="checkbox" name="notify_user" value="1" />
								</p>

								<p>
									<textarea name="admin_note" placeholder="Message to user (if applicable)"></textarea>
								</p>

								<?php submit_button("Update User's Virtual Wallet"); ?>
							</form>
						</div>

					</div>

	    </div>
	    <?php
	}

	/**
	 * WO options validation
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public function validate($input) {
	    $input["enabled"] = isset($input["enabled"]) ? $input["enabled"] : 0;
	    return $input;
	}
}
WPVW_Admin_Options::init();