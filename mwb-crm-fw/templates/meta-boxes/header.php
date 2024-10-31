<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the header of feeds section.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Insightly
 * @subpackage Mwb_Cf7_Integration_With_Insightly/includes/framework/templates/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="mwb_cf7_integration__feeds-wrap">
	<div class="mwb-cf7_integration_logo-wrap">
		<div class="mwb-sf_cf7__logo-zoho">
			<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/crm.png' ); ?>" alt="<?php esc_html_e( 'Insightly', 'mwb-cf7-integration-with-insightly' ); ?>">
		</div>
		<div class="mwb-cf7_integration_logo-contact">
			<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/contact-form.svg' ); ?>" alt="<?php esc_html_e( 'CF7', 'mwb-cf7-integration-with-insightly' ); ?>">
		</div>
	</div>

