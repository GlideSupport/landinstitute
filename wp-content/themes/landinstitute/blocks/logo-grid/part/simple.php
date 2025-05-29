<?php if (!empty($li_lg_headline) || !empty($li_lg_wysiwyg) || !empty($li_lg_wysiwyg)): ?>
	<div class="logo-grid-block <?php echo esc_attr($border_options); ?>">
		<div class="heading-max">
			<?php echo !empty($li_lg_headline) ? BaseTheme::headline($li_lg_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_lg_headline) && !empty($li_lg_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_lg_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_lg_wysiwyg) . '</div>' : ''; ?>
		</div>
		<div class="gl-s52"></div>
		<?php if (!empty($li_lg_repeater_logos)) { ?>
		<div class="logo-grid-row">
			<?php foreach ($li_lg_repeater_logos as $li_lg_repeater_logo) {
				$li_lg_logo = $li_lg_repeater_logo['li_lg_logo'] ?? '';
				if (!empty($li_lg_logo)) { ?>
					<div class="logo-grid-col">
						<?php echo wp_get_attachment_image($li_lg_logo, 'thumb_300', false, ['class' => 'logo-grid-wrap']); ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>
	</div>
<?php endif; ?>