<?php if (!empty($li_tf_headline_check) || !empty($li_tf_kicker) || !empty($li_tf_select_form_type) || !empty($li_tf_form_embed) || !empty($li_tf_form_selector)) : ?>
	<div class="newsletter-block">
		<div class="block-row">
			<?php echo !empty($li_tf_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_tf_kicker) . '</div>' : ''; ?>	
			<?php echo (!empty($li_tf_kicker) && !empty($li_tf_headline_check)) ? '<div class="gl-s12"></div>' : ''; ?>
			<?php echo !empty($li_tf_headline_check) ? BaseTheme::headline($li_tf_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_tf_headline_check) && !empty($li_tf_form_selector) || !empty($li_tf_form_embed)) ? '<div class="gl-s44"></div>' : ''; ?>
			<?php if (!empty($li_tf_form_embed) || !empty($li_tf_form_selector)): ?>
				<div class="newsletter-form">
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