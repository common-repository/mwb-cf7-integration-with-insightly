<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com
 * @since             1.0.0
 * @package           Mwb_Cf7_Integration_With_Insightly
 *
 * @wordpress-plugin
 * Plugin Name:       MWB CF7 Integration with Insightly
 * Plugin URI:        https://wordpress.org/plugins/mwb-cf7-integration-with-insightly
 * Description:       MWB CF7 Integration with Insightly plugin allows the admin to associate CF7 form fields with Insightly modules. and sends all  data over to the connected Insightly account and creates contacts, leads, tasks, etc.
 * Version:           1.0.1
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com
 *
 * Requires at least: 4.0
 * Tested up to:      5.8
 *
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mwb-cf7-integration-with-insightly
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// check if cf7 is activated.
if ( ! mwb_in_cf7_is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
	// wc not activated, show error and return.
	add_action( 'admin_init', 'mwb_in_cf7_plugin_deactivate' );
	return;
}

// All set activate the plugin.
register_activation_hook( __FILE__, 'activate_mwb_cf7_integration_with_insightly' );
register_deactivation_hook( __FILE__, 'deactivate_mwb_cf7_integration_with_insightly' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-cf7-integration-with-insightly.php';

// define plugin constants.
define_mwb_in_cf7();

// begin plugin execution.
run_mwb_cf7_integration_with_insightly();


/**
 * Deactivate plugin hook admin notice.
 */
function mwb_in_cf7_plugin_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
	add_action( 'admin_notices', 'mwb_in_cf7_plugin_error_notice' );
}

/**
 * Show admin notice on plugin deactivation
 */
function mwb_in_cf7_plugin_error_notice() {

	$dependent = esc_html__( 'Contact Form 7', 'mwb-cf7-integration-with-insightly' );
	$plugin    = esc_html__( 'MWB CF7 Integration with Insightly', 'mwb-cf7-integration-with-insightly' );
	?>

	<div class="error notice is-dismissible">
		<p>
			<?php
			printf(
				/* translators: %1$s: Dependent plugin, %2$s: The plugin. */
				esc_html__( ' %1$s is not activated, Please activate %1$s first to activate %2$s', 'mwb-cf7-integration-with-insightly' ),
				'<strong>' . esc_html( $dependent ) . '</strong>',
				'<strong>' . esc_html( $plugin ) . '</strong>'
			);
			?>
		</p>
	</div>
	<?php

	// To hide Plugin activated notice.
	unset( $_GET['activate'] ); // phpcs:ignore
}

/**
 * Function to check for plugin activation.
 *
 * @param    string $slug   Slug of the plugin.
 * @return   bool
 */
function mwb_in_cf7_is_plugin_active( $slug = '' ) {

	if ( empty( $slug ) ) {
		return;
	}

	$active_plugins = get_option( 'active_plugins', array() );

	if ( is_multisite() ) {
		$active_plugins = array_merge( $active_plugins, get_option( 'active_sitewide_plugins', array() ) );
	}

	return in_array( $slug, $active_plugins, true ) || array_key_exists( $slug, $active_plugins );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mwb-cf7-integration-with-insightly-activator.php
 */
function activate_mwb_cf7_integration_with_insightly() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-cf7-integration-with-insightly-activator.php';
	Mwb_Cf7_Integration_With_Insightly_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mwb-cf7-integration-with-insightly-deactivator.php
 */
function deactivate_mwb_cf7_integration_with_insightly() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-cf7-integration-with-insightly-deactivator.php';
	Mwb_Cf7_Integration_With_Insightly_Deactivator::deactivate();
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mwb_cf7_integration_with_insightly() {

	$plugin = new Mwb_Cf7_Integration_With_Insightly();
	$plugin->run();

}

/**
 * Define Plugin Contants
 */
function define_mwb_in_cf7() {
	mwb_in_cf7_constant( 'MWB_CF7_INTEGRATION_WITH_INSIGHTLY_VERSION', '1.0.1' );
	mwb_in_cf7_constant( 'MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL', plugin_dir_url( __FILE__ ) );
	mwb_in_cf7_constant( 'MWB_CF7_INTEGRATION_WITH_INSIGHTLY_DIRPATH', plugin_dir_path( __FILE__ ) );
	mwb_in_cf7_constant( 'MWB_CF7_INTEGRATION_WITH_INSIGHTLY_PLUGIN_NAME', 'MWB CF7 Integration with Insightly' );
}

/**
 * Defining Constants
 *
 * @param string $name Name of constant.
 * @param string $value Value of contant.
 */
function mwb_in_cf7_constant( $name, $value ) {
	if ( ! defined( $name ) ) {
		define( $name, $value );
	}
}

// If pro version is inactive add setings link to org version.
if ( ! mwb_in_cf7_is_plugin_active( 'cf7-integration-with-insightly/cf7-integration-with-insightly.php' ) ) {

	// Add settings link in plugin action links.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwb_in_cf7_settings_link' );

	/**
	 * Add settings link callback.
	 *
	 * @since  1.0.0
	 * @param  string $links link to the admin area of the plugin.
	 * @return array
	 */
	function mwb_in_cf7_settings_link( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=mwb_insightly_cf7_page&tab=accounts' ) . '">' . esc_html__( 'Settings', 'mwb-cf7-integration-with-insightly' ) . '</a>',
			'<a style="background: #2196f3; color: white; font-weight: 700; padding: 2px 5px; border: 1px solid #2196f3; border-radius: 10px;" href="' . esc_url( 'https://makewebbetter.com/product/cf7-integration-with-insightly/?utm_source=mwb-insightly-org&utm_medium=mwb-org&utm_campaign=insightly-org' ) . '" target="_blank">' . esc_html__( 'GO PRO', 'mwb-cf7-integration-with-insightly' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
	}
}

add_filter( 'plugin_row_meta', 'mwb_in_cf7_important_links', 10, 2 );

/**
 * Add custom links.
 *
 * @param   string $links   Link to index file of plugin.
 * @param   string $file    Index file of plugin.
 * @since   1.0.0
 * @return  array
 */
function mwb_in_cf7_important_links( $links, $file ) {
	if ( strpos( $file, 'mwb-cf7-integration-with-insightly.php' ) !== false ) {

		$row_meta = array(
			'demo'    => '<a href="' . esc_url( 'https://demo.makewebbetter.com/get-personal-demo/mwb-cf7-integration-with-insightly/?utm_source=MWB-insightly-org&utm_medium=MWB-org-backend&utm_campaign=MWB-insightly-demo' ) . '" target="_blank"><img src="' . MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Demo.svg" style="width: 20px;padding-right: 5px;"></i>' . esc_html__( 'Demo', 'mwb-cf7-integration-with-insightly' ) . '</a>',
			'doc'     => '<a href="' . esc_url( 'https://docs.makewebbetter.com/mwb-cf7-integration-with-insightly/?utm_source=MWB-insightly-org&utm_medium=MWB-org-backend&utm_campaign=MWB-insightly-doc' ) . '" target="_blank"><img src="' . MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Documentation.svg" style="width: 20px;padding-right: 5px;"></i>' . esc_html__( 'Documentation', 'mwb-cf7-integration-with-insightly' ) . '</a>',
			'support' => '<a href="' . esc_url( 'https://makewebbetter.com/submit-query/?utm_source=MWB-insightly-org&utm_medium=MWB-org-backend&utm_campaign=MWB-insightly-support' ) . '" target="_blank"><img src="' . MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Support.svg" style="width: 20px;padding-right: 5px;"></i>' . esc_html__( 'Support', 'mwb-cf7-integration-with-insightly' ) . '</a>',
		);

		return array_merge( $links, $row_meta );
	}

	return (array) $links;
}

