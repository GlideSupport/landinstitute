<?php if (!empty($li_ig_headline_check) || !empty($li_ig_repeater)): ?>
	<div class="image-gallery">
		<?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'heading-3 block-title mb-0') : ''; ?>
		<?php echo !empty($li_ig_headline_check) ? '<div class="gl-s36"></div>' : ''; ?>
		<div class="image-gallery-block">
			<div class="swiper-container image-gallery-slider">
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
			<?php if(count($li_ig_repeater) >= 3): ?>
				<div class="gl-s44"></div>
				<div class="slider-btn">
					<div class="swiper-button-prev" role="button" tabindex="0" aria-label="Previous slide"></div>
					<div class="swiper-button-next" role="button" tabindex="0" aria-label="Next slide"></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>