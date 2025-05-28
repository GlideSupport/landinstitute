<?php 
//Block Fields
$li_hero_standard = $bst_block_fields['li_hero_standard'] ?? null;
$kicker = $li_hero_standard['kicker'] ?? null;
$wysiwyg = $li_hero_standard['wysiwyg'] ?? null;
$button = $li_hero_standard['button'] ?? null;
$image = $li_hero_standard['image'] ?? null;
$bg_image = $li_hero_standard['bg_image'] ?? null;
if (!empty($li_hero_headline_check) || !empty($kicker) || !empty($wysiwyg) || !empty($button) || !empty($image) || !empty($bg_image)): ?>
	<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu variation-width">
		<!-- hero start -->
		<?php echo !empty($bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_image, 'thumb_1600') . '</div>' : ''; ?>
		<div class="hero-default <?php echo esc_attr($border_options); ?>">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left <?php echo esc_attr($bg_color); ?>">
						<div class="hero-content">
							<?php echo !empty($kicker) ? '<div class="ui-eyebrow-18-16-regular">' . esc_html($kicker) . '</div>' : ''; ?>
							<?php echo (!empty($li_hero_headline_check) && !empty($kicker)) ? '<div class="gl-s12"></div>' : ''; ?>
							<?php echo !empty($li_hero_headline_check) ? BaseTheme::headline($li_hero_headline, 'heading-1 mb-0 block-title') : ''; ?>
							<?php echo (!empty($li_hero_headline_check) || !empty($button)) ? '<div class="gl-s30"></div>' : ''; ?>
							<?php echo !empty($wysiwyg) ? '<div class="block-content">' . html_entity_decode($wysiwyg) . '</div><div class="gl-s30"></div>' : ''; ?>
							<?php echo !empty($button) ? '<div class="tab-dropdown">' . BaseTheme::button($button, 'site-btn text-link') . '</div><div class="gl-s96"></div>' : ''; ?>
						</div>
					</div>
					<div class="col-right">
					<?php echo !empty($image) ? '<div class="block-image-center">' . wp_get_attachment_image($image, 'thumb_900') . '</div>' : ''; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>