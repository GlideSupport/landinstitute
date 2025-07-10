<?php if (!empty($li_t_repeater)) : ?>
	<div class="timeline-block">
	<?php echo $li_t_kicker ? '<h2 class="heading-2 block-title mb-0">' . esc_html($li_t_kicker) . '</h2><div class="gl-s44"></div>' : ''; ?>
		<div class="timeline-slides-block">
			<div class="swiper-container timeline-slider">
				<div class="swiper-wrapper">
					<?php foreach ($li_t_repeater as $item) :
						$year = $item['li_t_year'] ?? '';
						$title = $item['li_t_title'] ?? '';
						$content = $item['li_t_wysiwyg'] ?? '';
						$link = $item['li_t_link']['url'] ?? '';
						$link_title = $item['li_t_link']['title'] ?? '';
						$link_target = $item['li_t_link']['target'] ?? '_self'; 
						if(!empty($year) || !empty($title) || !empty($content) || !empty($link)): ?>
							<div class="swiper-slide">
								<div class="border-card">
									<?php echo !empty($link) ? '<a href="' . esc_url($link) . '" target="' . esc_attr($link_target) . '" class="border-card-click">' : '<div class="border-card-click">'; ?>
									<div class="gl-s52"></div>
										<?php echo $year ? '<div class="ui-20-18-bold card-sub-head">' . esc_html($year) . '</div><div class="gl-s4"></div>' : ''; ?>
										<?php echo $title ? '<div class="heading-4 mb-0 block-title">' . esc_html($title) . '</div><div class="gl-s20"></div>' : ''; ?>
										<?php echo $content ? '<div class="body-18-16-regular block-content">' . html_entity_decode($content) . '</div>' : ''; ?>
										<?php echo (!empty($content) && !empty($link)) ? '<div class="gl-s12"></div>' : ''; ?>
										<?php echo !empty($link) ? '<div class="block-btn"><div class="site-btn text-link">' . html_entity_decode($link_title) . '</div></div>' : ''; ?>
										<div class="gl-s64"></div>
									<?php echo !empty($link) ? '</a>' : '</div>'; ?>
								</div>
							</div>
					<?php endif; endforeach; ?>
				</div>
			</div>

			<div class="gl-s44"></div>
			<div class="slider-btn">
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
	</div>
<?php endif; ?>
