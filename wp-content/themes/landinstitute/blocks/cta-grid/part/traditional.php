<?php if (!empty($li_cg_headline_check) || !empty($li_cg_kicker) || !empty($li_cg_repeater)): ?>
	<div class="cta-grid-traditional-block <?php echo esc_attr($border_options); ?>">
		<div class="heading-max">
			<?php echo !empty($li_cg_kicker) ? '<div class="ui-eyebrow-18-16-regular block-subhead">' . esc_html($li_cg_kicker) . '</div>' : ''; ?>
			<?php echo (!empty($li_cg_kicker) && !empty($li_cg_headline_check)) ? '<div class="gl-s12"></div>' : ''; ?>
			<?php echo !empty($li_cg_headline_check) ? BaseTheme::headline($li_cg_headline, 'heading-2 block-title mb-0') : ''; ?>
		</div>
		<?php echo (!empty($li_cg_headline_check) && !empty($li_cg_repeater)) ? '<div class="gl-s64"></div>' : ''; ?>
		<?php if (!empty($li_cg_repeater)): ?>
			<div class="cta-grid-traditional-row">
				<?php foreach ($li_cg_repeater as $li_cg_rep):
					$title = $li_cg_rep['title'] ?? '';
					$text = $li_cg_rep['text'] ?? '';
					$link = $li_cg_rep['link'] ?? [];
					$link_url = $link['url'] ?? '';
					$link_title = $link['title'] ?? 'Learn More';
					$link_target = $link['target'] ?? '_self';
					if (!empty($title) || !empty($text) || !empty($link)): ?>
					<div class="cta-grid-traditional-col">						
						<?php echo (!empty($link)) ? '<a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '" class="cta-grid-traditional-card">' : '<div class="cta-grid-traditional-card">'; ?>
							<?php echo (!empty($title) || !empty($text) || !empty($link)) ? '<div class="gl-s96"></div>' : ''; ?>
							<?php echo !empty($title) ? '<div class="ui-34-28-bold card-title">' . esc_html($title) . '</div>' : ''; ?>
							<?php echo (!empty($title) && !empty($text)) ? '<div class="gl-s20"></div>' : ''; ?>
							<?php echo !empty($text) ? '<div class="card-content">' . esc_html($text) . '</div>' : ''; ?>
							<?php echo (!empty($text) && !empty($link)) ? '<div class="gl-s24"></div>' : ''; ?>
							<?php echo !empty($link) ? '<div class="block-btn"><div class="site-btn text-link" role="button" aria-label="' . esc_attr($link_title) . '">' . esc_html($link_title) . '</div></div>' : ''; ?>
							<?php echo (!empty($title) || !empty($text) || !empty($link)) ? '<div class="gl-s96"></div>' : ''; ?>
						<?php echo (!empty($link)) ? '</a>' : '</div>'; ?>
					</div>
				<?php endif; endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
