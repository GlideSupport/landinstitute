<?php if (!empty($li_lg_headline_check) || !empty($li_lg_wysiwyg) || !empty($li_lg_wysiwyg) || !empty($li_lg_logo_grid_layout)): ?>
	<?php if($li_lg_logo_grid_layout=='two-column'):
			$class="logo-grid-two";
		elseif ($li_lg_logo_grid_layout=='three-column') :
			$class="logo-grid-three";
		else :
			$class="logo-grid-four";
		endif;
	?>
	<div class="logo-grid-block">
		<div class="heading-max">
			<?php echo !empty($li_lg_headline_check) ? BaseTheme::headline($li_lg_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_lg_headline_check) && !empty($li_lg_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_lg_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_lg_wysiwyg) . '</div>' : ''; ?>
		</div>
		<?php echo (!empty($li_lg_headline_check) || !empty($li_lg_wysiwyg)) ? '<div class="gl-s52"></div>' : ''; ?>
		<?php if (!empty($li_lg_repeater_logos)) { ?>
		<div class="logo-grid-row <?php echo $class; ?>">
		<?php foreach ($li_lg_repeater_logos as $li_lg_repeater_logo) {
			$li_lg_logo = $li_lg_repeater_logo['li_lg_logo'] ?? '';
			$li_lg_url = $li_lg_repeater_logo['li_lg_url'] ?? '';
			
			if (!empty($li_lg_logo)) {
				echo '<div class="logo-grid-col">';
				echo !empty($li_lg_url) 
					? '<a class="logo-grid-wrap" href="' . esc_url($li_lg_url) . '">' 
					: '<div class="logo-grid-wrap">';
				
				echo wp_get_attachment_image($li_lg_logo, 'thumb_200');
				
				echo !empty($li_lg_url) ? '</a>' : '</div>';
				echo '</div>';
			}
		} ?>
		</div>
	<?php } ?>
	</div>
<?php endif; ?>
