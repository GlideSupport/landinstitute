<?php if (!empty($li_ill_headline_check) || !empty($li_ill_wysiwyg) || !empty($li_ill_show_or_hide_arrow) || !empty($li_ill_repeater) || !empty($li_ill_img)) { ?>
	<div class="internal-link-list-block with-parallax-image">
		<div class="row-flex">
			<div class="col-left parallax-img">
			<?php echo !empty($li_ill_img) ? '<div class="parallax-fixed-bgs">' . wp_get_attachment_image($li_ill_img, 'thumb_1400') . '</div>' : ''; ?>
			</div>
			<div class="col-right bg-base-cream">
				<div class="gl-s156"></div>
				<?php echo !empty($li_ill_headline_check) ? BaseTheme::headline($li_ill_headline, 'heading-2 block-title mb-0') : ''; ?>
				<?php echo (!empty($li_ill_headline_check) && !empty($li_ill_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
				<?php echo !empty($li_ill_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_ill_wysiwyg) . '</div><div class="gl-s30"></div>' : ''; ?>
				<?php if (!empty($li_ill_repeater)) { ?>
				<div class="card-list">
					<?php foreach ($li_ill_repeater as $li_ill_rep) {
						$title = $li_ill_rep['title'];
						$text = $li_ill_rep['text'];
						$image = $li_ill_rep['image'];
						$link = $li_ill_rep['link'];
						$link_url = $link['url'] ?? '';
						$link_target = $link['target'] ?? '_self';

						if (!empty($title) || !empty($text) || !empty($link)) { ?>
						<?php echo !empty($link_url) 
						? '<a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '" class="card-item link-with-title' . 
						(($li_ill_show_or_hide_arrow === 'with-arrow' && !empty($link_url)) ? ' with-arrow' : '') . 
						(!empty($image) ? ' hover-img' : '') . '">' 
						: '<div class="card-item link-with-title' . 
						(!empty($image) ? ' hover-img' : '') . '">'; ?>
						<?php echo !empty($image) ? '<div class="card-img">' . wp_get_attachment_image($image, 'thumb_200') . '</div>' : ''; ?>
								<div class="card-item-left">
									<?php echo !empty($title) ? '<div class="card-title ui-24-21-bold">' . esc_html($title) . '</div>' : ''; ?>
									<?php echo (!empty($title) && !empty($text)) ? '<div class="gl-s4"></div>' : ''; ?>
									<?php echo !empty($text) ? '<div class="card-content body-18-16-regular">' . esc_html($text) . '</div>' : ''; ?>
								</div>
								<?php if($li_ill_show_or_hide_arrow == 'with-arrow' && !empty($link_url)){?>
									<div class="card-item-right">
										<div class="dot-btn">
											<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" title="right-circle-arrow" alt="right-circle-arrow" />
										</div>
									</div>
								<?php } ?>
							<?php echo !empty($link_url) ? '</a>' : '</div>'; ?>
						<?php }
					} ?>
				</div>
				<?php } ?>
				<div class="gl-s156"></div>
			</div>
		</div>
	</div>
<?php } ?>