<?php if (!empty($li_ig_headline_check) || !empty($li_ig_repeater)): ?>
	<div class="image-gallery">
		<?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'heading-3 block-title mb-0') : ''; ?>
		<?php echo !empty($li_ig_headline_check) ? '<div class="gl-s36"></div>' : ''; ?>
		<div class="image-gallery-block <?php echo esc_attr($border_options); ?>">
			<div class="swiper-container image-gallery-slider cursor-drag-icon">
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

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		new Swiper('.image-gallery-slider', {
			loop: true,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			centeredSlides: false,
			slidesPerView: 1.5,
			spaceBetween: 16,
			breakpoints: {
				1920: {
					slidesPerView: 3.7,
					spaceBetween: 20,
				},
				1440: {
					slidesPerView: 2.97,
					spaceBetween: 20,
				},
				641: {
					slidesPerView: 2.5,
					spaceBetween: 16,
				},
				375: {
					slidesPerView: 1.27,
					spaceBetween: 16,
				}
			},
		});
	});
</script>