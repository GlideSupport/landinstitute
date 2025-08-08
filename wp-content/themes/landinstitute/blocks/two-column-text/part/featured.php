<?php if (!empty($li_tct_repeater)) { ?>
<div class="two-column-text text-featured-block">
	<div class="row-flex">
		<?php foreach ($li_tct_repeater as $section) {
			$kicker = $section['kicker'];
			$headline = $section['headline'];
			$button = $section['link'];
			$bg_color = $section['li_globel_bg_color_options'] ?? null;
			if (!empty($kicker) || !empty($headline) || !empty($button) || !empty($bg_color)) {?>
				<div class="text-card-col <?php echo esc_attr($bg_color); ?>">
					<div class="text-card-col-group">
						<div class="gl-s156"></div>
						<?php echo !empty($kicker) ? '<div class="ui-eyebrow-20-18-regular">' . esc_html($kicker) . '</div>' : ''; ?>
						<div class="gl-s24"></div>
						<?php echo BaseTheme::headline($headline, 'heading-3 mb-0 block-title'); ?>
						<div class="gl-s200"></div>
						<?php echo !empty($button) ? '<div class="text-card-btn">' . BaseTheme::button($button, 'site-btn') . '</div>' : ''; ?>
					</div>
				</div>
			<?php }
		} ?>
	</div>
</div>
<?php } ?>
