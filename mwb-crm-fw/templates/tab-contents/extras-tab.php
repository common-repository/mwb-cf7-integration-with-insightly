<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Insightly
 * @subpackage Mwb_Cf7_Integration_With_Insightly/mwb-crm-fw/tab-contents
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$api_key = get_option( 'mwb-cf7-' . $this->crm_slug . '-api-key', '' );
$api_url = get_option( 'mwb-cf7-' . $this->crm_slug . '-api-url', '' );
?>
<div class="mwb-reauth__body row-hide">
	<div class="mwb-crm-reauth-wrap">
		<div class="mwb-reauth__body-close">
			<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/cancel.png' ); ?>" alt="Close">
		</div>
		<!-- Login form start -->
		<form method="post" id="mwb_cf7_integration_account_form">

			<div class="mwb_cf7_integration_table_wrapper">
				<div class="mwb_cf7_integration_account_setup">
					<h2>
						<?php esc_html_e( 'Reauthorize Connection', 'mwb-cf7-integration-with-insightly' ); ?>
					</h2>
				</div>

				<table class="mwb_cf7_integration_table">
					<tbody>

						<!-- api key start  -->
						<tr class="mwb-api-fields">
							<th>							
								<label><?php esc_html_e( 'API Key', 'mwb-cf7-integration-with-insightly' ); ?></label>
							</th>

							<td>
								<input type="text"  name="mwb_account[api_key]" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-api-key" value="<?php echo esc_html( $api_key ); ?>" required placeholder="<?php esc_html_e( 'Enter your API key here', 'mwb-cf7-integration-with-insightly' ); ?>" readonly>
							</td>
						</tr>
						<!-- api key end -->

						<!-- Callback url start -->
						<tr class="mwb-api-fields">
							<th>
								<label><?php esc_html_e( 'Insightly API URL', 'mwb-cf7-integration-with-insightly' ); ?></label>
							</th>

							<td>
								<input type="url" name="mwb_account[api_url]" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-api-url" value="<?php echo esc_html( $api_url ); ?>" required placeholder="https://api.na1.insightly.com" readonly>
							</td>
						</tr>
						<!-- Callback url end -->

						<!-- Save & connect account start -->
						<tr>
							<th>
							</th>
							<td>
								<a href="<?php echo esc_url( wp_nonce_url( admin_url( '?mwb-cf7-integration-perform-auth=1' ) ) ); ?>" class="mwb-btn mwb-btn--filled mwb_cf7_integration_submit_account" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-authorize-button" >
									<?php esc_html_e( 'Reauthorize', 'mwb-cf7-integration-with-insightly' ); ?>
								</a>
							</td>
						</tr>
						<!-- Save & connect account end -->
					</tbody>
				</table>
			</div>
		</form>
		<!-- Login form end -->

	</div>
</div>
