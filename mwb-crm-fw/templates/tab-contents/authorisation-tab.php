<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the accounts creation page.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Insightly
 * @subpackage Mwb_Cf7_Integration_With_Insightly/admin/partials/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$connected = get_option( 'mwb-cf7-' . $this->crm_slug . '-crm-connected', false );
?>
<?php if ( '1' !== get_option( 'mwb-cf7-' . $this->crm_slug . '-crm-active', false ) || '1' !== get_option( 'mwb-cf7-' . $this->crm_slug . '-crm-connected', false ) ) : ?>
	<?php if ( '1' !== $connected ) : ?>
		<section class="mwb-intro">
			<div class="mwb-content-wrap">
				<div class="mwb-intro__header">
					<h2 class="mwb-section__heading">
						<?php echo sprintf( 'Getting started with CF7 and %s', esc_html( $this->crm_name ) ); ?>
					</h2>
				</div>
				<div class="mwb-intro__body mwb-intro__content">
					<p>
					<?php
					echo sprintf(
						/* translators: %1$s: crm name, %2$s:crm name, %3$s: API modules, %3$s: crm name */
						esc_html__( 'With this CF7 %1$s Integration you can easily sync all your CF7 Form Submissions data over %2$s CRM. It will create %3$s over %4$s CRM, based on your CF7 Form Feed data.', 'mwb-cf7-integration-with-insightly' ),
						esc_html( $this->crm_name ),
						esc_html( $this->crm_name ),
						esc_html( $params['api_modules'] ),
						esc_html( $this->crm_name )
					);
					?>
					</p>
					<ul class="mwb-intro__list">
						<li class="mwb-intro__list-item">
							<?php
							echo sprintf(
								/* translators: %s: crm name */
								esc_html__( 'Connect your %s CRM account with CF7.', 'mwb-cf7-integration-with-insightly' ),
								esc_html( $this->crm_name )
							);
							?>
						</li>
						<li class="mwb-intro__list-item">
							<?php
							echo sprintf(
								/* translators: %s:CRM name */
								esc_html__( 'Sync your data over %s CRM.', 'mwb-cf7-integration-with-insightly' ),
								esc_html( $this->crm_name )
							);
							?>
						</li>
					</ul>
					<div class="mwb-intro__button">
						<a href="javascript:void(0)" class="mwb-btn mwb-btn--filled" id="mwb-showauth-form">
							<?php esc_html_e( 'Connect your Account.', 'mwb-cf7-integration-with-insightly' ); ?>
						</a>
					</div>
				</div> 
			</div>
		</section>
	<?php endif; ?>

	<!--============================================================================================
											Authorization form start.
	================================================================================================-->

	<div class="mwb_cf7_integration_account-wrap <?php echo esc_html( false === $connected ? 'row-hide' : '' ); ?>" id="mwb-cf7-auth_wrap">
		<!-- Logo section start -->
		<div class="mwb-cf7_integration_logo-wrap">
			<div class="mwb-cf7_integration_logo-crm">
				<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/crm.png' ); ?>" alt="<?php esc_html_e( 'Insightly', 'mwb-cf7-integration-with-insightly' ); ?>">
			</div>
			<div class="mwb-cf7_integration_logo-contact">
				<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/contact-form.svg' ); ?>" alt="<?php esc_html_e( 'CF7', 'mwb-cf7-integration-with-insightly' ); ?>">
			</div>
		</div>
		<!-- Logo section end -->

		<!-- Login form start -->
		<form method="post" id="mwb_cf7_integration_account_form">

			<div class="mwb_cf7_integration_table_wrapper">
				<div class="mwb_cf7_integration_account_setup">
					<h2>
						<?php esc_html_e( 'Enter your api credentials here', 'mwb-cf7-integration-with-insightly' ); ?>
					</h2>
				</div>

				<table class="mwb_cf7_integration_table">
					<tbody>
						<div class="mwb-auth-notice-wrap row-hide">
							<p class="mwb-auth-notice-text">
								<?php esc_html_e( 'Connection has been successful ! Validating .....', 'mwb-cf7-integration-with-insightly' ); ?>
							</p>
						</div>

						<!-- api key start  -->
						<tr class="mwb-api-fields">
							<th>							
								<label><?php esc_html_e( 'API Key', 'mwb-cf7-integration-with-insightly' ); ?></label>
							</th>

							<td>
								<?php
								$api_key = ! empty( $params['api_key'] ) ? sanitize_text_field( wp_unslash( $params['api_key'] ) ) : '';
								?>
								<div class="mwb-cf7-integration__secure-field">
									<input type="password"  name="mwb_account[api_key]" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-api-key" value="<?php echo esc_html( $api_key ); ?>" required placeholder="<?php esc_html_e( 'Enter your API key here', 'mwb-cf7-integration-with-insightly' ); ?>">
									<div class="mwb-cf7-integration__trailing-icon">
										<span class="dashicons dashicons-visibility mwb-toggle-view"></span>
									</div>
								</div>
							</td>
						</tr>
						<!-- api key end -->

						<!-- api url start -->
						<tr class="mwb-api-fields">
							<th>
								<label><?php esc_html_e( 'Insightly API URL', 'mwb-cf7-integration-with-insightly' ); ?></label>
							</th>

							<td>
								<?php
								$api_url = ! empty( $params['api_url'] ) ? sanitize_text_field( wp_unslash( $params['api_url'] ) ) : '';
								?>
								<input type="url" name="mwb_account[api_url]" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-api-url" value="<?php echo esc_html( $api_url ); ?>" required placeholder="https://api.na1.insightly.com" >
							</td>
						</tr>
						<!-- api url end -->

						<!-- Save & connect account start -->
						<tr>
							<th>
							</th>
							<td>
								<a href="<?php echo esc_url( wp_nonce_url( admin_url( '?mwb-cf7-integration-perform-auth=1' ) ) ); ?>" class="mwb-btn mwb-btn--filled mwb_cf7_integration_submit_account" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-authorize-button" ><?php esc_html_e( 'Authorize', 'mwb-cf7-integration-with-insightly' ); ?></a>
							</td>
						</tr>
						<!-- Save & connect account end -->
					</tbody>
				</table>
			</div>
		</form>
		<!-- Login form end -->

		<!-- Info section start -->
		<div class="mwb-intro__bottom-text-wrap ">
			<p>
				<?php esc_html_e( 'Don’t have an account yet . ', 'mwb-cf7-integration-with-insightly' ); ?>
				<a href="https://accounts.insightly.com/?plan=trial" target="_blank" class="mwb-btn__bottom-text">
					<?php esc_html_e( 'Create A Free Account', 'mwb-cf7-integration-with-insightly' ); ?>
				</a>
			</p>
			<p>
				<?php esc_html_e( 'Get Your Api Key here.', 'mwb-cf7-integration-with-insightly' ); ?>
				<a href="https://crm.na1.insightly.com/Users/UserSettings" target="_blank" class="mwb-btn__bottom-text"><?php esc_html_e( 'Get Api Keys', 'mwb-cf7-integration-with-insightly' ); ?></a>
			</p>
			<p>
				<?php esc_html_e( 'Check app setup guide . ', 'mwb-cf7-integration-with-insightly' ); ?>
				<a href="javascript:void(0)" class="mwb-btn__bottom-text trigger-setup-guide"><?php esc_html_e( 'Show Me How', 'mwb-cf7-integration-with-insightly' ); ?></a>
			</p>
		</div>
		<!-- Info section end -->
	</div>

<?php else : ?>

	<!-- Successfull connection start -->
	<section class="mwb-sync">
		<div class="mwb-content-wrap">
			<div class="mwb-sync__header">
				<h2 class="mwb-section__heading">
					<?php
					echo sprintf(
						/* translators: %s: CRM name */
						esc_html__( 'Congrats! You’ve successfully set up the MWB CF7 Integration with %s Plugin.', 'mwb-cf7-integration-with-insightly' ),
						esc_html( $this->crm_name )
					);
					?>
				</h2>
			</div>
			<div class="mwb-sync__body mwb-sync__content-wrap">            
				<div class="mwb-sync__image">    
					<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/congo.jpg' ); ?>" >
				</div>       
				<div class="mwb-sync__content">            
					<p> 
						<?php
						echo sprintf(
							/* translators: %s : crm name */
							esc_html__( 'Now you can go to the dashboard and check connection data. You can create your feeds, edit them in the feeds tab. If you do not see your data over %s, you can check the logs for any possible error.', 'mwb-cf7-integration-with-insightly' ),
							esc_html( $this->crm_name )
						);
						?>
					</p>
					<div class="mwb-sync__button">
						<a href="javascript:void(0)" class="mwb-btn mwb-btn--filled mwb-onboarding-complete">
							<?php esc_html_e( 'View Dashboard', 'mwb-cf7-integration-with-insightly' ); ?>
						</a>
					</div>
				</div>             
			</div>       
		</div>
	</section>
	<!-- Successfull connection end -->

<?php endif; ?>
