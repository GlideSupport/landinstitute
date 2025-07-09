<?php if (!empty($li_ig_headline_check) || !empty($li_ig_repeater)): ?>
	<div class="image-gallery">
		<?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'heading-3 block-title mb-0') : ''; ?>
		<?php echo !empty($li_ig_headline_check) ? '<div class="gl-s36"></div>' : ''; ?>
		<div class="image-gallery-block">
			<div class="swiper-container image-gallery-slider <?php echo (count($li_ig_repeater) >= 3) ? 'cursor-drag-icon' : ''; ?>">
				<?php if (!empty($li_ig_repeater)) : ?>
					<div class="swiper-wrapper">
						<?php foreach ($li_ig_repeater as $li_ig_rep) :
							$image = $li_ig_rep['image'] ?? ''; ?>
							<?php if (!empty($image)) : ?>
								<div class="swiper-slide">
									<?php echo !empty($image) ? '<div class="img-grid-block">' . wp_get_attachment_image($image, false) . '</div>' : ''; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>