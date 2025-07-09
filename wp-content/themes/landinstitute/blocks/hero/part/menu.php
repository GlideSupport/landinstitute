<?php 
//Block Fields
$li_hero_menu = $bst_block_fields['li_hero_menu'] ?? null;
$menu_label = $li_hero_menu['menu_label'] ?? null;
$select_menu = $li_hero_menu['menu_selector'] ?? null;
$image = $li_hero_menu['image'] ?? null;
$bg_image = $li_hero_menu['bg_image'] ?? null;
$content = $li_hero_menu['content'] ?? null;

// Get menu slug or ID safely
$menu_value = null;
if (is_array($select_menu) && isset($select_menu['slug'])) {
    $menu_value = $select_menu['slug'];
} elseif (is_object($select_menu) && isset($select_menu->slug)) {
    $menu_value = $select_menu->slug;
} elseif (is_numeric($select_menu)) {
    $menu_value = (int) $select_menu;
}

if (!empty($li_hero_headline_check) || !empty($menu_label) || !empty($content) || !empty($select_menu) || !empty($image) || !empty($bg_image)): ?>
	<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu">
		<!-- hero start -->
		<?php echo !empty($bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_image, 'thumb_1600') . '</div>' : ''; ?>
		<div class="hero-default <?php echo esc_attr($border_options); ?>">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left bg-lime-green">
						<div class="hero-content">
						<?php echo !empty($li_hero_headline_check) ? BaseTheme::headline($li_hero_headline, 'heading-1 mb-0 block-title') : ''; ?>
						<?php if (!empty($content)) : ?>
							<div class="gl-s30"></div>
						<?php endif; ?>
						<?php echo !empty($content) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($content) . '</div>' : ''; ?> 
							<?php echo !empty($menu_label) ? '<div class="gl-s36"></div><div class="ui-18-16-bold sub-head">' . esc_html($menu_label) . '</div><div class="gl-s12"></div>' : ''; ?>
							<!-- TO DO -->
							<?php echo !empty($menu_value) ? '<div class="gl-s12"></div>' : ''; ?>
							<?php if (!empty($menu_value)) :
								$menu_object = wp_get_nav_menu_object($menu_value);
								$menu_items = !empty($menu_object) ? wp_get_nav_menu_items($menu_object->term_id) : [];
								$first_menu_title = !empty($menu_items) ? $menu_items[0]->title : 'Select'; ?>
								<div class="tab-dropdown menu-dropdown">
									<button class="dropdown-toggle" id="hero-menu" aria-expanded="false" aria-haspopup="true" aria-controls="hero-menu">
										<?php echo esc_html($first_menu_title); ?><div class="arrow-icon"></div>
									</button>
								</div>
							<?php endif; ?>
							<div class="gl-s96"></div>
						</div>
					</div>
					<div class="col-right">
					<?php echo !empty($bg_image) ? '<div class="bg-pattern pattern-top-align">' . wp_get_attachment_image($bg_image, 'thumb_900') . '</div>' : ''; ?>
					<?php echo !empty($image) ? '<div class="block-image-center">' . wp_get_attachment_image($image, 'thumb_900') . '</div>' : ''; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php
wp_nav_menu(array(
	'menu'           => $menu_value,
	'fallback_cb'    => 'BaseTheme::nav_fallback',
	'container'      => false,
	'menu_class'     => 'dropdown-menu',
	'menu_id'        => 'hero-menu',
	'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menu" aria-labelledby="hero-menu">%3$s</ul>',
));
?>

