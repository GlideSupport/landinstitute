<?php if (!empty($li_me_title) || !empty($li_me_text) || !empty($li_me_iframe)): ?>
	<div class="map-embed-block <?php echo esc_attr($border_options); ?>">
		<div class="map-block-group">
			<div class="map-info-box">
				<?php echo !empty($li_me_title) ? '<div class="gl-s30"></div><div class="ui-16-15-bold-uc map-title">' . esc_html($li_me_title) . '</div>' : ''; ?>
				<?php echo (!empty($li_me_text) || !empty($li_me_title)) ? '<div class="gl-s8"></div>' : ''; ?>
				<?php echo !empty($li_me_text) ? '<div class="body-18-16-regular map-content">' . esc_html($li_me_text) . '</div><div class="gl-s30"></div>' : ''; ?>
			</div>
			<?php echo !empty($li_me_iframe) ? html_entity_decode($li_me_iframe) : ''; ?>
		</div>
	</div>
<?php endif; ?>