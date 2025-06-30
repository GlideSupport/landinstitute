<?php 
// Block Fields
$li_hero_text_only = $bst_block_fields['li_hero_text_only'] ?? null;
$kicker = $li_hero_text_only['kicker'] ?? null;

if (!empty($li_hero_headline_check) || !empty($kicker)) : ?>
	<section id="hero-section" class="hero-section hero-section-default hero-text-only">
		<!-- hero start -->
		<div class="hero-default <?php echo esc_attr($border_options); ?>">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-content bg-lime-green">
						<div class="hero-content">
							<?php echo (!empty($kicker) || !empty($li_hero_headline_check)) ? '<div class="gl-s128"></div>' : ''; ?>
							<?php echo !empty($kicker) ? '<div class="ui-eyebrow-20-18-regular">' . esc_html($kicker) . '</div>' : ''; ?>
							<?php echo (!empty($kicker) && !empty($li_hero_headline_check)) ? '<div class="gl-s20"></div>' : ''; ?>
							<?php echo !empty($li_hero_headline_check) ? BaseTheme::headline($li_hero_headline, 'heading-1 mb-0 block-title') : ''; ?>
							<?php echo (!empty($li_hero_headline_check) || !empty($kicker)) ? '<div class="gl-s96"></div>' : ''; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
