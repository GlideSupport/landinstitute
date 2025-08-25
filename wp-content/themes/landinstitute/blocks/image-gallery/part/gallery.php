<?php if (!empty($li_ig_headline_check) || !empty($li_ig_repeater)): ?>
	<div class="image-gallery-block">
		<div class="custom-cursor mobile-hidden"></div>
		<div class="gallery-block">
			<div class="bg-lines">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/images/bg-lines2x-scaled.png" alt="Image" title="Image">
			</div>
			<?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'block-heading ui-128-78-bold white_text mb-0') : ''; ?>
			<div class="cursor-static">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/images/close-gallery.svg" alt="Image" title="Image"/>
			</div>
			<?php if (!empty($li_ig_repeater)) : ?>
				<div class="gallery-grid">
					<div class="gallery-image">
						<?php 
						$count = 0;
						foreach ($li_ig_repeater as $li_ig_rep) :
							if ($count >= 8) break; // stop after 8
							$image = $li_ig_rep['image'] ?? '';
							if (!empty($image)): ?>
								<?php echo !empty($image) ? '<div class="card-img">' . wp_get_attachment_image($image, false) . '</div>' : ''; ?>
						<?php 
						$count++;	
						endif;
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		 <!-- Expand / Close Buttons -->
        <button class="gallery-expand-btn" id="followBtn">Browse Gallery</button>
        <button class="gallery-close-btn">✕</button>
	</div>
<?php endif; ?>