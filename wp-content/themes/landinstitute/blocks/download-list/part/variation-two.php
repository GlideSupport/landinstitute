<?php if (!empty($li_dl_headline_check) || !empty($li_dl_image) || !empty($li_dl_wysiwyg) || !empty($li_dl_main_repeater_two)): ?>
	<div class="download-list sticky-lft-block has-border-bottom">
		<div class="row-flex">
			<?php echo !empty($li_dl_image) ? '<div class="col-left sticky-img "><div class="sticky-image-stick">' . wp_get_attachment_image($li_dl_image, 'thumb_1200') . '</div></div>' : ''; ?>
			<div class="cl-right">
				<div class="gl-s156"></div>
				<?php echo !empty($li_dl_headline_check) ? BaseTheme::headline($li_dl_headline, 'heading-2 block-title mb-0') : ''; ?>
				<?php echo (!empty($li_dl_headline_check) && !empty($li_dl_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
				<?php echo !empty($li_dl_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_dl_wysiwyg) . '</div><div class="gl-s30"></div>' : ''; ?>   
				<?php if (!empty($li_dl_main_repeater_two)) : ?>
				<div class="card-list">
					<?php foreach ($li_dl_main_repeater_two as $li_dl_main_rep_two) : 
						$li_dl_title_two = $li_dl_main_rep_two['li_dl_title_two'] ?? '';
						$li_dl_wysiwyg_two = $li_dl_main_rep_two['li_dl_wysiwyg_two'] ?? '';
						$li_dl_link_two = $li_dl_main_rep_two['li_dl_link_two'] ?? null;
					
						$link_url = $li_dl_link_two['url'] ?? '';
						$link_title = $li_dl_link_two['title'] ?? '';
						$link_target = $li_dl_link_two['target'] ?? '_self';
						
						if(!empty($li_dl_title_two) || !empty($li_dl_wysiwyg_two) || !empty($li_dl_link_two)): ?>
							<?php echo !empty($link_url) ? '<a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '" class="card-item link-with-title with-arrow">' : '<div class="card-item link-with-title with-arrow">'; ?>
								<div class="card-item-left">
									<div class="card-title ui-24-21-bold">
										<?php echo esc_html($li_dl_title_two); ?>
									</div>
									<div class="gl-s4"></div>
									<div class="card-content body-18-16-regular">
										<?php echo html_entity_decode($li_dl_wysiwyg_two); ?>
									</div>
								</div>
								<div class="card-item-right">
									<div class="dot-btn">
										<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg">
									</div>
								</div>
							<?php echo !empty($li_dl_link_two) ? '</a>' : '</div>'; ?>
						<?php  endif; endforeach; ?>
					</div>
				<div class="gl-s156"></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>