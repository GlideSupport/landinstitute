<?php if (!empty($li_tct_select_design)): ?>
	<?php if($li_tct_select_design == 'content'):?>
		<?php if (!empty($li_tct_headline_check) || !empty($li_tct_kicker) || !empty($li_tct_wysiwyg)): ?>
			<div class="two-column-text-standard-block">
				<div class="heading-full">
					<?php echo !empty($li_tct_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . html_entity_decode($li_tct_kicker) . '</div>' : ''; ?>
					<?php echo (!empty($li_tct_headline_check) && !empty($li_tct_kicker)) ? '<div class="gl-s12"></div>' : ''; ?>
					<?php echo !empty($li_tct_headline_check) ? BaseTheme::headline($li_tct_headline, 'heading-2 block-title mb-0') : ''; ?>
				</div>
					<?php echo (!empty($li_tct_headline_check) && !empty($li_tct_wysiwyg)) ? '<div class="gl-s44"></div>' : ''; ?>
					<?php echo !empty($li_tct_wysiwyg) ? '<div class="two-col-content  body-20-18-regular">' . html_entity_decode($li_tct_wysiwyg) . '</div>' : ''; ?>
			</div>
		<?php endif; ?>
	<?php else: ?>
		<?php if (!empty($li_tct_headline_check) || !empty($li_tct_kicker) || !empty($li_tct_wysiwyg) || !empty($li_tct_bg_image)): ?>
			<div class="two-column-image">
				<div class="heading-max">
					<?php echo !empty($li_tct_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . html_entity_decode($li_tct_kicker) . '</div>' : ''; ?>
					<?php echo (!empty($li_tct_headline_check) && !empty($li_tct_kicker)) ? '<div class="gl-s12"></div>' : ''; ?>
					<?php echo !empty($li_tct_headline_check) ? BaseTheme::headline($li_tct_headline, 'heading-2 block-title mb-0') : ''; ?>
				</div>
					<?php echo (!empty($li_tct_headline_check) && !empty($li_tct_wysiwyg)) ? '<div class="gl-s44"></div>' : ''; ?>
					<?php echo !empty($li_tct_wysiwyg) ? '<div class="two-col-content  body-20-18-regular">' . html_entity_decode($li_tct_wysiwyg) . '</div>' : ''; ?>
					<?php echo !empty($li_tct_bg_image) ? '<div class="cta-image-full">' . wp_get_attachment_image($li_tct_bg_image, 'thumb_2000') . '</div>' : ''; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>