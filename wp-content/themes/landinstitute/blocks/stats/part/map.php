<?php if (!empty($li_s_kicker) || !empty($li_s_image) || !empty($li_s_repeater_one)): ?>
	<div class="impact-map-block stats-map-block">
		<?php echo !empty($li_s_kicker) ? '<div class="gl-s44"></div><div class="ui-20-18-bold-uc block-title mb-0">' . esc_html($li_s_kicker) . '</div>' : ''; ?>
		<!-- Years slider -->
		<div class="map-content-value">
			<div class="swiper-slide-container">
				<div class="map-image">
				<?php echo wp_get_attachment_image($li_s_image, 'full', false, array( 'width'  => 1003, 'height' => 534, 'alt' => 'Map Image') ); ?>
				</div>
				<?php if (!empty($li_s_repeater_one)) : ?>
					<div class="map-values">
						<?php foreach ($li_s_repeater_one as $li_s_rep_one) :?>
							<div class="map-values-col" >
								<div class="map-counter counter-number" data-target="<?php echo esc_attr($li_s_rep_one['li_s_number_one']); ?>">	
									<h2 class="mb-0 block-title heading-2">
									<?php echo esc_html(($li_s_rep_one['li_s_prefix_one'] ?? '')); ?><span class="count">0</span><?php echo esc_html(($li_s_rep_one['li_s_postfix_one'] ?? '')); ?>
									</h2>
								</div>
								<div class="ui-16-15-bold map-content">
									<?php echo esc_html($li_s_rep_one['li_s_label_one'] ?? ''); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php echo !empty($li_s_button) ? '<div class="map-bottom-cta"><div class="map-cta-btn">' . BaseTheme::button($li_s_button, 'site-btn') . '</div></div>' : ''; ?>
	</div>
<?php endif; ?>