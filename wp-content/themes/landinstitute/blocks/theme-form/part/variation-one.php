<?php if (!empty($li_tf_headline_check) || !empty($li_tf_wysiwyg) || !empty($li_tf_form_title)  || !empty($li_tf_select_form_type) || !empty($li_tf_form_embed) || !empty($li_tf_form_selector)) : ?>
	<div class="get-in-touch-block">
		<div class="cl-left">
			<div class="gl-s80"></div>
			<?php echo !empty($li_tf_headline_check) ? BaseTheme::headline($li_tf_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_tf_headline_check) && !empty($li_tf_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_tf_wysiwyg) ? '<div class="body-20-18-regular block-content">' . html_entity_decode($li_tf_wysiwyg) . '</div><div class="gl-s80"></div>' : ''; ?>	
		</div>
		<div class="cl-right">
			<div class="gl-s80"></div>
			<?php if (!empty($li_tf_form_embed) || !empty($li_tf_form_selector) || !empty($li_tf_form_title) ): ?>
				<div class="footer-newsletter">
					<?php echo !empty($li_tf_form_title) ? '<div class="form-title ui-24-21-bold">' . esc_html($li_tf_form_title) . '</div><div class="gl-s30"></div>' : ''; ?>
					<?php if (($li_tf_select_form_type == 'gravity-form')): ?>
						<?php echo !empty($li_tf_form_selector) ? do_shortcode('[gravityform id="' . $li_tf_form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
					<?php else :?>
							<?php echo html_entity_decode($li_tf_form_embed); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="gl-s80"></div>
		</div>
	</div>
<?php endif; ?>