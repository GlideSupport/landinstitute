<?php if (!empty($li_tct_repeater)) { ?>
<div class="two-column-text text-featured-block">
	<div class="row-flex">
		<?php foreach ($li_tct_repeater as $section) {
			$kicker = $section['kicker'];
			$headline = $section['headline'];
			$description = $section['description'];
			$button = $section['link'];
			$bg_color = $section['li_globel_bg_color_options'] ?? null;
			if (!empty($kicker) || !empty($headline) || !empty($description) || !empty($button) || !empty($bg_color)) {
				$has_link = !empty($button['url']);
				?>
				<div class="text-card-col <?php echo esc_attr($bg_color); ?>">
					<?php if ($has_link): ?>
						<a href="<?php echo esc_url($button['url']); ?>" class="text-card-col-group"<?php echo !empty($button['target']) ? ' target="' . esc_attr($button['target']) . '"' : ''; ?>>
					<?php else: ?>
						<div class="text-card-col-group">
					<?php endif; ?>
					<div class="gl-s156"></div>
					<?php echo !empty($kicker) ? '<div class="ui-eyebrow-20-18-regular">' . esc_html($kicker) . '</div>' : ''; ?>
					<div class="gl-s24"></div>
					<?php echo BaseTheme::headline($headline, 'heading-3 mb-0 block-title'); ?>
					<div class="gl-s200"></div>
					<?php if (!empty($button)): ?>
						<div class="text-card-btn">
							<div class="site-btn"><?php echo esc_html($button['title']); ?></div>
						</div>
					<?php endif; ?>
					<?php if ($has_link): ?>
						</a>
					<?php else: ?>
						</div>
					<?php endif; ?>
				</div>
			<?php }
		} ?>
	</div>
</div>
<?php } ?>
