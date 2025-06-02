
<?php if (!empty($li_me_headline_check) || !empty($li_me_wysiwyg) || !empty($li_me_hours_title) || !empty($li_me_hours_wysiwyg) || !empty($li_me_iframe)): ?>
	<div class="map-embed-block contact-info-block has-border-bottom">
		<div class="row-flex">
			<div class="cl-left">
				<div class="gl-s64"></div>
				<?php echo !empty($li_me_headline_check) ? BaseTheme::headline($li_me_headline, 'heading-4 block-title mb-0') : ''; ?>
				<?php echo (!empty($li_me_headline_check) && !empty($li_me_wysiwyg)) ? '<div class="gl-s24"></div>' : ''; ?>
				<?php echo !empty($li_me_wysiwyg) ? '<div class="contact-info body-20-18-regular">' . html_entity_decode($li_me_wysiwyg) . '</div><div class="gl-s36"></div>' : ''; ?>   
				<?php echo !empty($li_me_hours_title) ? '<div class="ui-20-18-bold-uc address-title">' . esc_html($li_me_hours_title) . '</div>' : ''; ?>   
				
				<?php echo (!empty($li_me_hours_title) && !empty($li_me_hours_wysiwyg)) ? '<div class="gl-s8"></div>' : ''; ?>
				<?php echo !empty($li_me_hours_wysiwyg) ? '<div class="ui-20-18-regular address-title">' . html_entity_decode($li_me_hours_wysiwyg) . '</div><div class="gl-s64"></div>' : ''; ?>   
				
			</div>
			<div class="cl-right">
				<?php echo !empty($li_me_iframe) ? '<div class="map-img">' . html_entity_decode($li_me_iframe) . '</div>' : ''; ?>
			</div>
		</div>
	</div>
<?php endif; ?>