<?php if (!empty($li_ig_headline_check) || !empty($li_ig_repeater)): ?>
	<div class="image-gallery-block">
		<div class="custom-cursor mobile-hidden"></div>
		<div class="gallery-block">
		
			<?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'block-heading ui-128-78-bold white_text mb-0') : ''; ?>
			<div class="cursor-static">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/images/drag-button.svg" alt="Image" title="Image"/>
			</div>
			<?php if (!empty($li_ig_repeater)) : ?>
				<div class="gallery-grid">
				
					<?php 
					// Split images into batches of 8
						$chunks = array_chunk($li_ig_repeater, 8); 
				foreach ($chunks as $index => $chunk): ?>
					<div class="gallery-image customheighgal ">
						<?php 
						$count = 0;
						$total = count($chunk);
						foreach ($chunk as $li_ig_rep) :
							if ($count >= 8) break; // stop after 8
							$image = $li_ig_rep['image'] ?? '';
							if (!empty($image)):

								// add class if first or last in this chunk
								$extra_class = '';
								if ($count === 0) {
									$extra_class = ' firstimg';
								} elseif ($count === $total - 1) { 
									$extra_class = ' lastimg';
								}
								?>
								<div class="card-img<?php echo $extra_class; ?>">
									<?php echo wp_get_attachment_image($image, false); ?>
								</div>
							<?php 
							$count++;    
							endif;
						endforeach; ?>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		 <!-- Expand / Close Buttons -->
        <button class="gallery-expand-btn" id="followBtn">Browse Gallery</button>
        <button class="gallery-close-btn">✕</button>
	</div>
<?php endif; ?>