<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the premium page.
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

?>
<!-- Overview content start -->

<div class="mwb-cf7-integration-overview">
	<div class="mwb-cf7-integration-overview__wrapper">
		<div class="mwb-cf7-integration-overview__container">
			<div class="mwb-cf7-integration-overview__icons-wrap">
				<a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/?utm_source=MWB-insightly-org&utm_medium=MWB-org-backend&utm_campaign=MWB-insightly-query' ); ?>">
					<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/connect.svg' ); ?>" alt="contact-us-img">
				</a>
				<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/mwb-cf7-integration-with-insightly/?utm_source=MWB-insightly-org&utm_medium=MWB-org-backend&utm_campaign=MWB-insightly-doc' ); ?>">
					<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/doc.svg' ); ?>" alt="doc-img">
				</a>
			</div>
			<div class="mwb-cf7-integration-overview__banner-img">
				<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/banner.png' ); ?>" alt="banner-img">
			</div>
			<div class="mwb-cf7-integration-overview__content">
				<h1><?php esc_html_e( 'What is  MWB CF7 Integration with Insightly?', 'mwb-cf7-integration-with-insightly' ); ?></h1>
				<p><?php esc_html_e( 'MWB CF7 Integration with Insightly plugin integrates your Insightly account with CF7, sending all data over Insightly as per its available modules.', 'mwb-cf7-integration-with-insightly' ); ?></p>
			</div>
			<div class="mwb-cf7-integration-overview__features">
				<h2><?php esc_html_e( 'What does MWB CF7 Integration with Insightly do?', 'mwb-cf7-integration-with-insightly' ); ?></h2>
				<ul class="mwb-cf7-integration-overview__features-list">
					<li><?php esc_html_e( 'Smooth CF7 Integration With Your Insightly Account.', 'mwb-cf7-integration-with-insightly' ); ?></li>
					<li><?php esc_html_e( 'Easy CF7 Fields Association With Any Insightly Module Fields.', 'mwb-cf7-integration-with-insightly' ); ?></li>
					<li><?php esc_html_e( 'Filters CF7 submissions According To User Input.', 'mwb-cf7-integration-with-insightly' ); ?></li>
					<li><?php esc_html_e( 'Detailed Log Of CF7 Submission Sent To Insightly.', 'mwb-cf7-integration-with-insightly' ); ?></li>
					<li><?php esc_html_e( 'Primary Key To Update Existing Entry Over Insightly.', 'mwb-cf7-integration-with-insightly' ); ?></li>
				</ul>
			</div>
			<div class="mwb-cf7-integration-overview__keywords-wrap">
				<h2><?php esc_html_e( 'Salient Features of MWB CF7 Integration with Insightly Plugin.', 'mwb-cf7-integration-with-insightly' ); ?></h2>
				<div class="mwb-cf7-integration-overview__keywords">
					<div class="mwb-cf7-integration-overview__keywords-item">
						<div class="mwb-cf7-integration-overview__keywords-card">
							<div class="mwb-cf7-integration-overview__keywords-text">
								<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Integration.jpg' ); ?>" alt="smooth-integration" width="100px">
								<h4 class="mwb-cf7-integration-overview__keywords-heading"><?php esc_html_e( 'Smooth CF7 Integration With Your Insightly Account', 'mwb-cf7-integration-with-insightly' ); ?></h4>
								<p class="mwb-cf7-integration-overview__keywords-description">
									<?php esc_html_e( 'MWB CF7 Integration with Insightly offers a smooth integration of both. The admin can enter their Insightly API credentials to integrate Contact Form 7 with their Insightly accounts.', 'mwb-cf7-integration-with-insightly' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="mwb-cf7-integration-overview__keywords-item">
						<div class="mwb-cf7-integration-overview__keywords-card">
							<div class="mwb-cf7-integration-overview__keywords-text">
								<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Association.jpg' ); ?>" alt="Easy-association" width="100px">
								<h4 class="mwb-cf7-integration-overview__keywords-heading"><?php esc_html_e( 'Easy CF7 Fields Association With Any Insightly Module Fields', 'mwb-cf7-integration-with-insightly' ); ?></h4>
								<p class="mwb-cf7-integration-overview__keywords-description">
									<?php esc_html_e( 'Any Contact Form 7 field can be linked to any Insightly module field. Any Insightly module Contacts, Organisations, Opportunities, Leads, Tasks, Projects and Prospects, integrates perfectly with this plugin.', 'mwb-cf7-integration-with-insightly' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="mwb-cf7-integration-overview__keywords-item">
						<div class="mwb-cf7-integration-overview__keywords-card">
							<div class="mwb-cf7-integration-overview__keywords-text">
								<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Filters.jpg' ); ?>" alt="Filter-form" width="100px">
								<h4 class="mwb-cf7-integration-overview__keywords-heading"><?php esc_html_e( 'Filters CF7 submissions According To User Input.', 'mwb-cf7-integration-with-insightly' ); ?></h4>
								<p class="mwb-cf7-integration-overview__keywords-description">
									<?php esc_html_e( 'The admin can filter the Contact Form 7 submissions based on user input using AND/OR logic. This logic will filter Contact Form 7 forms submissions and send it Insightly depending on user inputs.', 'mwb-cf7-integration-with-insightly' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="mwb-cf7-integration-overview__keywords-item">
						<div class="mwb-cf7-integration-overview__keywords-card">
							<div class="mwb-cf7-integration-overview__keywords-text">
								<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Log.jpg' ); ?>" alt="Detailed-log" width="100px">
								<h4 class="mwb-cf7-integration-overview__keywords-heading"><?php esc_html_e( 'Detailed Log Of CF7 Submission Sent To Insightly.', 'mwb-cf7-integration-with-insightly' ); ?></h4>
								<p class="mwb-cf7-integration-overview__keywords-description">
									<?php esc_html_e( 'MWB Insightly Integration plugin will provide a detailed log of each Contact Form 7 sent to Insightly as per the response from the Insightly. There is logging of all the API interaction with Insightly for better error handling.', 'mwb-cf7-integration-with-insightly' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="mwb-cf7-integration-overview__keywords-item">
						<div class="mwb-cf7-integration-overview__keywords-card">
							<div class="mwb-cf7-integration-overview__keywords-text">
								<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/Primary.jpg' ); ?>" alt="Primary-key" width="100px">
								<h4 class="mwb-cf7-integration-overview__keywords-heading"><?php esc_html_e( 'Primary Key To Update Existing Entry Over Insightly.', 'mwb-cf7-integration-with-insightly' ); ?></h4>
								<p class="mwb-cf7-integration-overview__keywords-description">
									<?php esc_html_e( 'Suppose an entry made by the user already exists over Insightly. In that case, the admin can update it with the help of the “Primary key” provided.', 'mwb-cf7-integration-with-insightly' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="mwb-cf7-integration-overview__keywords-item">
						<div class="mwb-cf7-integration-overview__keywords-card">
							<div class="mwb-cf7-integration-overview__keywords-text">
								<img src="<?php echo esc_url( MWB_CF7_INTEGRATION_WITH_INSIGHTLY_URL . 'admin/images/eMail.jpg' ); ?>" alt="Email-notification" width="100px">
								<h4 class="mwb-cf7-integration-overview__keywords-heading"><?php esc_html_e( 'Error eMail Notification For Admin', 'mwb-cf7-integration-with-insightly' ); ?></h4>
								<p class="mwb-cf7-integration-overview__keywords-description">
									<?php esc_html_e( 'E-mail notifications are sent to the admin if any input error occurs in the process of data sending entries over to Insightly. This way, the admin gets notified of any slight error in real-time.', 'mwb-cf7-integration-with-insightly' ); ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Overview content end-->
