<?php if (!empty($li_tf_headline_check) || !empty($li_tf_kicker) || !empty($li_tf_form_selector)) : ?>
	<div class="newsletter-block">
		<div class="block-row">
			<?php echo !empty($li_tf_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_tf_kicker) . '</div>' : ''; ?>	
			<?php echo (!empty($li_tf_kicker) && !empty($li_tf_headline_check)) ? '<div class="gl-s12"></div>' : ''; ?>
			<?php echo !empty($li_tf_headline_check) ? BaseTheme::headline($li_tf_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_tf_headline_check) && !empty($li_tf_form_selector)) ? '<div class="gl-s44"></div>' : ''; ?>
			<div class="newsletter-form">
				<?php echo !empty($li_tf_form_selector) ? do_shortcode('[gravityform id="' . $li_tf_form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
			</div>
			<div class="gl-s80"></div>
		</div>
	</div>
<?php endif; ?>	