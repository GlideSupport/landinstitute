<?php if (!empty($li_dl_headline_check) || !empty($li_dl_image) || !empty($li_dl_wysiwyg) || !empty($li_dl_main_repeater)): ?>
	<div class="download-list sticky-lft-block">
		<div class="row-flex">
			<?php echo !empty($li_dl_image) ? '<div class="col-left sticky-img "><div class="sticky-image-stick">' . wp_get_attachment_image($li_dl_image, 'thumb_1000') . '</div></div>' : ''; ?>
			<div class="cl-right">
				<div class="gl-s156"></div>
				<?php echo !empty($li_dl_headline_check) ? BaseTheme::headline($li_dl_headline, 'heading-2 block-title mb-0') : ''; ?>
				<?php echo (!empty($li_dl_headline_check) && !empty($li_dl_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
				<?php echo !empty($li_dl_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_dl_wysiwyg) . '</div><div class="gl-s52"></div>' : ''; ?>   
				<?php if (!empty($li_dl_main_repeater)) : 
					$total_groups = count($li_dl_main_repeater);
					$current_index = 0;?>
					<?php foreach ($li_dl_main_repeater as $fiscal_group) : 
						$fiscal_year = $fiscal_group['li_dl_title'];
						$downloads = $fiscal_group['li_dl_inner_repeater'];
						if(!empty($fiscal_year) && !empty($downloads)): ?>
							<div class="list-list-block">
								<?php if (!empty($fiscal_year)) : ?>
									<div class="heading-4 mb-0 block-title"><?php echo esc_html($fiscal_year); ?></div>
									<div class="gl-s16"></div>
								<?php endif; ?>
								<?php if (!empty($downloads)) : ?>
									<div class="card-pdf-list">
										<?php foreach ($downloads as $file_item) : 
											$link = $file_item['li_dl_link'] ?? null;
											$label = $file_item['li_dl_label'] ?? null;
											if ($link):
												$url = $link['url'];
												$title = $link['title'];
												$link_target = $link['target'] ? $link['target'] : '_self';
											if(!empty($url) && !empty($title)): ?>
											<?php echo !empty($link) ? '<a href="' . esc_url($url) . '" target="' . esc_attr($link_target) . '" class="card-item">' : '<div class="card-item">'; ?>
													<div class="card-item-left">
														<div class="card-title ui-20-18-bold"> <?php echo esc_html($title); ?>
														<?php echo !empty($label) ? '<span class="card-content tag-label">' . esc_html($label) . '</span>' : ''; ?>   
													</div>
													</div>
													<div class="card-item-right">
														<div class="dot-btn">
															<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="View PDF">
														</div>
													</div>
													<?php echo !empty($link) ? '</a>' : '</div>'; ?>
										<?php endif; endif; endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
							<?php
								$current_index++;
								echo ($current_index === $total_groups) ? '<div class="gl-s156"></div>' : '<div class="gl-s52"></div>';
							?>
							<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>