<?php if (!empty($li_mpc_headline_check) || !empty($li_mpc_kicker) || !empty($li_mpc_wysiwyg) || !empty($li_mpc_link) || !empty($li_mpc_image)): ?>
	<div class="midpage-cta-map has-border-bottom">
		<div class="row-flex">
			<div class="cl-left">
				<div class="part-content">
					<div class="gl-s128"></div>
					<?php echo !empty($li_mpc_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_mpc_kicker) . '</div><div class="gl-s12"></div>' : ''; ?>  
					<?php echo !empty($li_mpc_headline_check) ? BaseTheme::headline($li_mpc_headline, 'heading-2 block-title mb-0') : ''; ?>
					<?php echo (!empty($li_mpc_headline_check) && !empty($li_mpc_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
					<?php echo !empty($li_mpc_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_mpc_wysiwyg) . '</div><div class="gl-s128"></div>' : ''; ?>
				</div>
				<?php echo !empty($li_mpc_link) ? '<div class="text-card-btn">' . BaseTheme::button($li_mpc_link, 'site-btn') . '</div>' : ''; ?>
			</div>
			<div class="cl-right">
				<?php echo !empty($li_mpc_image) ? '<div class="map-img">' . wp_get_attachment_image($li_mpc_image, 'thumb_800') . '</div>' : ''; ?>
			</div>
		</div>
	</div>
<?php endif; ?>