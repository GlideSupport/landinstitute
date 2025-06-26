<?php if (!empty($li_cg_headline_check) || !empty($li_cg_kicker) || !empty($li_cg_wysiwyg) ): ?>
	<div class="cta-grid-slider-block <?php echo esc_attr($border_options); ?>">
		<div class="heading-max">
		<?php echo !empty($li_cg_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_cg_kicker) . '</div>' : ''; ?>
			<?php echo (!empty($li_cg_kicker) && !empty($li_cg_headline_check)) ? '<div class="gl-s12"></div>' : ''; ?>
			<?php echo !empty($li_cg_headline_check) ? BaseTheme::headline($li_cg_headline, 'heading-2 block-title mb-0') : ''; ?>
			<?php echo (!empty($li_cg_headline_check) && !empty($li_cg_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_cg_wysiwyg) ? '<div class="block-content">' . html_entity_decode($li_cg_wysiwyg) . '</div>' : ''; ?>
		</div>
		<div class="gl-s64"></div>
		<div class="cta-grid-slider-cards">
			<?php if (!empty($li_cg_repeater)): ?>
				<div class="swiper-container cta-card-slide">
					<div class="swiper-wrapper">
					<?php   
						foreach ($li_cg_repeater as $li_cg_rep) :
							$title = $li_cg_rep['title'];
							$text = $li_cg_rep['text']; 
							$link = $li_cg_rep['link']; 
							$link_url = $link['url'] ?? '';
							$link_title = $link['title'] ?? '';
							$link_target = $link['target'] ? $link['target'] : '_self';
							$image = $li_cg_rep['image']; 
							if(!empty($title) || !empty($text) || !empty($link) || !empty($image)): ?>
								<div class="swiper-slide">
									<div class="trans-border-card">
									<?php echo !empty($link) ? '<a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '" class="trans-border-on">' : '<div class="trans-border-on">'; ?>
											<div class="card-content-group">
												<?php echo !empty($title) ? '<div class="ui-24-21-bold card-title">' . esc_html($title) . '</div>' : ''; ?>
												<?php echo (!empty($title) && !empty($text)) ? '<div class="gl-s4"></div>' : ''; ?>
												<?php echo !empty($text) ? '<div class="body-18-16-regular card-content">' . esc_html($text) . '</div>' : ''; ?>
											</div>
											<?php echo !empty($image) ? '<div class="card-img">' . wp_get_attachment_image($image, 'thumb_500') . '</div>' : ''; ?>
										<?php echo !empty($link) ? '</a>' : '</div>'; ?>
									</div>
								</div>
							<?php endif; ?>
					<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>