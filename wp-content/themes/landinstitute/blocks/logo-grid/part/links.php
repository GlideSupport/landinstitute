<?php if (!empty($li_lg_headline_check) || !empty($li_lg_wysiwyg) || !empty($li_lg_repeater_logos) || !empty($li_lg_logo_grid_layout)): ?>
	<?php if($li_lg_logo_grid_layout=='two-column'):
			$class="logo-grid-two";
		elseif ($li_lg_logo_grid_layout=='three-column') :
			$class="logo-grid-three";
		else :
			$class="logo-grid-four";
		endif;
	?>
	<div class="logo-grid-links-block <?php echo esc_attr($border_options); ?>">
		<div class="heading-max max-800">
			<?php echo !empty($li_lg_headline_check) ? BaseTheme::headline($li_lg_headline, 'heading-2 mb-0 block-title') : ''; ?>
			<?php echo (!empty($li_lg_headline_check) && !empty($li_lg_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_lg_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_lg_wysiwyg) . '</div>' : ''; ?>
		</div>
		<div class="gl-s96"></div>
		<?php if (!empty($li_lg_repeater_logos)) : ?>

			<div class="logo-grid-links-row <?php echo $class; ?>">
				<?php foreach ($li_lg_repeater_logos as $li_lg_repeater_logo) :
					$li_lg_logo  = $li_lg_repeater_logo['li_lg_logo'] ?? '';
					$li_lg_url  = $li_lg_repeater_logo['li_lg_url'] ?? '';
					$li_lg_text = $li_lg_repeater_logo['li_lg_text'] ?? '';
					$li_lg_content   = $li_lg_repeater_logo['li_lg_content'] ?? '';

					$img_url = wp_get_attachment_url($li_lg_logo);

					if (!empty($img_url) || !empty($li_lg_url) || !empty($li_lg_text) || !empty($li_lg_content)): ?>
						<div class="logo-grid-link-col">
							<?php echo !empty($li_lg_url) ? '<a href="' . esc_url($li_lg_url) . '" class="logo-grid-link">' : '<div class="logo-grid-link">'; ?>
							<?php if($img_url): ?>
								<div class="logo-image">
									<img src="<?php echo esc_url($img_url); ?>" width="200" height="110" alt="logos" loading="lazy" decoding="async" />
								</div>
								<div class="gl-s24"></div>
							<?php endif; ?>
							<div class="card-list">
								<div class="card-item link-with-title with-arrow">
									<div class="card-item-left">
										<div class="card-title ui-20-18-bold">
											<?php echo esc_html($li_lg_text); ?>
										</div>
										<div class="gl-s2"></div>
										<div class="card-content body-18-16-regular">
											<?php echo esc_html($li_lg_content); ?>
										</div>
									</div>
									<?php if (!empty($li_lg_url)): ?>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg">
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php echo !empty($li_lg_url) ? '</a>' : '</div>'; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>