<div class="image-gallery-block <?php echo esc_attr($border_options); ?>">
	<div class="custom-cursor"></div>
	<div class="gallery-block">
		<div class="bg-lines">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/images/bg-lines2x-scaled.png" alt="Image">
		</div>
		<?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'block-heading ui-128-78-bold white_text') : ''; ?>
		<?php if (!empty($li_ig_repeater)) : ?>
			<div class="gallery-grid">
				<div class="gallery-image">
					<?php foreach ($li_ig_repeater as $li_ig_rep) :
						$image = $li_ig_rep['image'] ?? '';
						if (!empty($image)): ?>
							<?php echo !empty($image) ? '<div class="card-img">' . wp_get_attachment_image($image, false) . '</div>' : ''; ?>
					<?php endif;
					endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>