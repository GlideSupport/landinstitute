<?php
//Block Fields
$li_hero_form = $bst_block_fields['li_hero_form'] ?? null;
$choose_variation = $li_hero_form['choose_variation'] ?? 'form';
$wysiwyg = $li_hero_form['wysiwyg'] ?? null;
$button = $li_hero_form['button'] ?? null;
$form = $li_hero_form['form'] ?? null;
$image = $li_hero_form['image'] ?? null;
$bg_image = $li_hero_form['bg_image'] ?? null;


if (!empty($li_hero_headline_check) || !empty($wysiwyg) || !empty($button) || !empty($form) || !empty($image) || !empty($bg_image)): ?>
	<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu variation-equal">
		<?php echo !empty($bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_image, 'thumb_1600') . '</div>' : ''; ?>
		<div class="hero-default">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left <?php echo esc_attr($bg_color); ?>">
						<div class="hero-content">
						<?php echo !empty($li_hero_headline_check) ? BaseTheme::headline($li_hero_headline, 'heading-1 mb-0 block-title') : ''; ?>
							<?php echo (!empty($li_hero_headline_check) && !empty($wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
							<?php echo !empty($wysiwyg) ? '<div class="hero-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div><div class="gl-s44"></div>' : ''; ?>	
							<?php
							echo ($choose_variation === 'form')
								? (!empty($form) ? '<div class="footer-newsletter">' . do_shortcode('[gravityform id="' . $form . '" title="false" ajax="true" tabindex="0"]') . '</div>' : '')
								: (!empty($button) ? '<div class="hero-button">' . BaseTheme::button($button, 'site-btn btn-sunflower-yellow xsm-btn') . '</div>' : '');
							?>
							<div class="gl-s96"></div>
						</div>
					</div>
					<div class="col-right">
					<?php echo !empty($bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_image, 'thumb_1600') . '</div>' : ''; ?>
					<?php echo !empty($image) ? '<div class="block-image-center">' . wp_get_attachment_image($image, 'thumb_900') . '</div>' : ''; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>