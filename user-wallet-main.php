<?php if ( ! defined( 'ABSPATH' ) ) { exit; }

class WPUW
{
	/** @var string current plugin version */
	public static $version = '1.2';

	/** @var object container instance for plugin */
	public static $_instance = null;

	/** @var array array of notices for the plugin to display */
	public $notices = array();

	/** @var array plugin default settings */
	protected $defualt_settings = array(
		'enabled'	=> true,
		'auto_complete_status' => true
		);

	/** construct method */
	function __construct ()
	{

		/** check for WooCommerce and trigger notice if needed */
		if (! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
			$this->notices[] = 'WooCommerce needs to be installed and activated to use "User Wallet"';
		}

		if ( !defined( 'WPUW_ABSPATH' ) ){
			define('WPUW_ABSPATH', dirname( __FILE__ ) );
		}

		if ( !defined( 'WPUW_URI' ) ){
				define( 'WPUW_URI', plugins_url('/', __FILE__) );
		}

		if ( function_exists( '__autoload' ) ) {
			spl_autoload_register( '__autoload' );
		}
		spl_autoload_register( array( $this, 'autoload' ) );

		add_action('wp_loaded', array($this, 'register_scripts'));
		add_action('wp_loaded', array($this, 'register_styles'));
		add_action('init', array( __CLASS__, 'includes'));
		add_action('init', array( $this, 'register_terms'));
		add_action( 'admin_notices', array($this, 'admin_notice') );

		/** activation hook for the server */
		register_activation_hook(__FILE__, array($this, 'setup'));
	}

	/**
	 * Load the instance of the plugin
	 */
	public static function instance (){
		if ( is_null( self::$_instance ) ) 
			self::$_instance = new self();

		return self::$_instance;
	}

	/**
	 * Autoload all the classes on demand.
	 * All WPUW classes are located in library directory.
	 * @return [type] [description]
	 */
	public function autoload($class){
		$path  = null;
		$class = strtolower( $class );
		$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

		if( strpos( $class, "UW_") === 0 ){
			$path = dirname( __FILE__ ) . '/library/' . trailingslashit(substr(str_replace( '_', '-', $class ), 18));
		}

		if ( $path && is_readable( $path . $file ) ){
			require_once( $path . $file );
			return;
		}
	}

	/**
	 * Plugin Includes
	 * @return void
	 */
	public static function includes (){
		require_once( dirname(__FILE__) . '/includes/gateway.php');
		require_once( dirname(__FILE__) . '/includes/functions.php');
		require_once( dirname(__FILE__) . '/includes/filters.php');
		require_once( dirname(__FILE__) . '/includes/shortcodes.php');
		
		/** include the ajax class if DOING_AJAX is defined */
		if ( defined( 'DOING_AJAX' ) ){
			require_once( dirname(__FILE__) . '/includes/ajax.php');
		}

		/** admin options page */
		require_once( dirname(__FILE__) . '/admin/admin-options.php');
	}

	/** register dependant styles */
	public function register_styles (){
		wp_register_style('wpvw_admin', plugins_url( '/assets/css/admin.css', __FILE__ )  );
	}

	/** register dependant scripts */
	public function register_scripts (){
		wp_register_script('wpvw_admin', plugins_url( '/assets/js/admin.js', __FILE__ ) );
	}

	/** register terms needed for plugin */
	public function register_terms (){
		wp_insert_term(
		  'Credit',
		  'product_cat',
		  array(
		    'description'=> '',
		    'slug' => 'credit'
		  )
		);
	}

	/**
	 * [setup description]
	 * @return void
	 */
	public function setup (){
		$options = get_option("vw_options");
		if(! isset($options["enabled"]) ){
			update_option("vw_options", $this->defualt_settings);
		}
	}

	/**
	 * [admin_notice description]
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 * @todo Add text domain 
	 */
	public function admin_notice ( ){
		if (count($this->notices) > 0): foreach($this->notices as $message):
    ?>
    <div class="updated">
        <p><?php _e( $message, 'my-text-domain' ); ?></p>
    </div>
    <?php
    endforeach; endif;
	}


}

function _WPUW (){
	return WPUW::instance();
}
$GLOBAL['WPUW'] = _WPUW();
