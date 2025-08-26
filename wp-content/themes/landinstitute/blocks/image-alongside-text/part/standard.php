<?php if (!empty($li_iat_headline_check) || !empty($li_iat_kicker) || !empty($li_iat_wysiwyg) || !empty($li_iat_button) || !empty($li_iat_image)): ?>
	<div class="image-alongside-text <?php echo esc_attr($image_position_class); ?>">
		<div class="cl-left">
			<div class="pattern-image-group">
				<?php echo !empty($li_iat_image) ? wp_get_attachment_image($li_iat_image, 'thumb_1000', false, ['class' => 'visual-image']) : ''; ?>
			</div>
		</div>
		<div class="cl-right">
			<?php echo !empty($li_iat_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_iat_kicker) . '</div>' : ''; ?>
			<div class="gl-s12"></div>
			<?php echo !empty($li_iat_headline_check) ? BaseTheme::headline($li_iat_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_iat_headline_check) && !empty($li_iat_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_iat_wysiwyg) ? '<div class="block-content">' . html_entity_decode($li_iat_wysiwyg) . '</div>' : ''; ?>  
			<?php echo (!empty($li_iat_wysiwyg) || !empty($li_iat_button)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_iat_button) ? '<div class="block-btn">' . BaseTheme::button($li_iat_button, 'site-btn text-link') . '</div>' : ''; ?>
		</div>
	</div>
<?php endif; ?>