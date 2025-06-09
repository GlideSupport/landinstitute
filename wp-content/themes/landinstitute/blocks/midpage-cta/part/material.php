<?php 
//Block Fields
$li_mpc_material = $bst_block_fields['li_mpc_material'] ?? null;
$li_mpc_form_selector = $li_mpc_material['li_mpc_form_selector'] ?? null;
$li_mpc_title = $li_mpc_material['li_mpc_title'] ?? null;
$li_mpc_subtitle = $li_mpc_material['li_mpc_subtitle'] ?? null;
$li_mpc_left_bg_image = $li_mpc_material['li_mpc_left_bg_image'] ?? null; 
$li_mpc_logo = $li_mpc_material['li_mpc_logo'] ?? null; 
$li_mpc_right_bg_image = $li_mpc_material['li_mpc_right_bg_image'] ?? null; ?>
<?php if (!empty($li_mpc_form_selector) || !empty($li_mpc_title) || !empty($li_mpc_subtitle) || !empty($li_mpc_left_bg_image) || !empty($li_mpc_logo) || !empty($li_mpc_right_bg_image) || !empty($li_mpc_kicker) || !empty($li_mpc_headline_check) ): ?>
	<div class="midpage-cta-material has-border-bottom">
		<div class="row-flex">
			<div class="cl-left">
				<div class="pattern-max-cards">
					<div class="pattern-lft-design">
						<div class="row-flex bg-base-cream">
						<?php echo !empty($li_mpc_left_bg_image) ? '<div class="col-left">' . wp_get_attachment_image($li_mpc_left_bg_image, 'thumb_300') . '</div>' : ''; ?>
							<div class="col-right">
								<?php echo !empty($li_mpc_title) ? '<div class="custom-title">' . esc_html($li_mpc_title) . '</div><div class="gl-s16"></div>' : ''; ?>  
								<?php echo !empty($li_mpc_subtitle) ? '<div class="custome-sub-title">' . esc_html($li_mpc_subtitle) . '</div>' : ''; ?>  
								<?php echo !empty($li_mpc_logo) ? '<div class="custom-logo">' . wp_get_attachment_image($li_mpc_logo, 'thumb_100') . '</div>' : ''; ?>
							</div>
						</div>
						<?php echo !empty($li_mpc_right_bg_image) ? '<div class="row-flex bg-lemon-yellow behind-reverse-pattern"><div class="col-left">' . wp_get_attachment_image($li_mpc_right_bg_image, 'thumb_300') . '</div></div>' : ''; ?>
						
					</div>
				</div>
			</div>
			<div class="cl-right bg-base-cream">
				<div class="gl-s128"></div>
				<div class="footer-newsletter">
				<?php echo !empty($li_mpc_kicker) ? '<div class="form-title ui-eyebrow-18-16-regular">' . esc_html($li_mpc_kicker) . '</div><div class="gl-s12"></div>' : ''; ?>  
				<?php echo !empty($li_mpc_headline_check) ? BaseTheme::headline($li_mpc_headline, 'heading-3 mb-0 block-title') : ''; ?>
				<?php echo (!empty($li_mpc_headline_check) && !empty($li_mpc_form_selector)) ? '<div class="gl-s44"></div>' : ''; ?>
				<?php echo !empty($li_mpc_form_selector) ? do_shortcode('[gravityform id="' . $li_mpc_form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
				</div>
				<div class="gl-s128"></div>
			</div>
		</div>
	</div>
<?php endif; ?>