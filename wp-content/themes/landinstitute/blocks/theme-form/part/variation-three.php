<?php if (!empty($li_tf_headline_check) || !empty($li_tf_wysiwyg) || !empty($li_tf_form_title) || !empty($li_tf_form_selector)) : ?>
	<div class="theme-form-heading has-border-bottom">
		<?php echo !empty($li_tf_headline_check) ? BaseTheme::headline($li_tf_headline, 'heading-3 mb-0 block-title') : ''; ?>
		<?php echo (!empty($li_tf_headline_check) && !empty($li_tf_wysiwyg)) ? '<div class="gl-s24"></div>' : ''; ?>
		<?php echo !empty($li_tf_wysiwyg) ? '<div class="block-content">' . html_entity_decode($li_tf_wysiwyg) . '</div>' : ''; ?>	
		<?php echo (!empty($li_tf_wysiwyg) && !empty($li_tf_form_selector) || !empty($li_tf_form_embed)) ? '<div class="gl-s44"></div>' : ''; ?>
		<?php if (!empty($li_tf_form_embed) || !empty($li_tf_form_selector)): ?>
			<div class="newsletter-form">
				<?php if (($li_tf_select_form_type == 'gravity-form')): ?>
					<?php echo !empty($li_tf_form_selector) ? do_shortcode('[gravityform id="' . $li_tf_form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
				<?php else :?>
						<?php echo html_entity_decode($li_tf_form_embed); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>	