<?php

/**
 * Block Name: Impact Map
 *
 * The template for displaying the custom gutenberg block named Impact Map.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);


// Set the block name for it's ID & class from it's file name.
$bst_block_name = $block['name'];
$bst_block_name = str_replace('acf/', '', $bst_block_name);
$bst_block_styles = BaseTheme::convert_to_css($block);
// Set the preview thumbnail for this block for gutenberg editor view.
if (isset($block['data']['preview'])) {
	echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
}

// create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = (isset($block['className'])) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if( !empty($block['anchor']) ) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ($block['name']) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace('/', '-', $bst_block_name);
	$bst_var_name = 'block-' . $bst_block_name;
}

// Block variables.
$li_im_title = $bst_block_fields['li_im_title'] ?? null;
$li_im_map_svg = $bst_block_fields['li_im_map_svg'] ?? null;
$li_im_repeater = $bst_block_fields['li_im_repeater'] ?? null;
$li_im_button = $bst_block_fields['li_im_button'] ?? null;
?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
	<div class="impact-map-block">
		<?php echo !empty($li_im_title) ? '<div class="gl-s44"></div><div class="ui-20-18-bold-uc block-title mb-0">' . esc_html($li_im_title) . '</div>' : ''; ?>
		<!-- Years slider -->
		<?php if (!empty($li_im_repeater)) : ?>
		<div class="map-content-value">
			<?php if ($li_im_map_svg) : ?>
				<div class="map-image single-map-custom">
					<?php
					// If field returns ID
					if (is_numeric($li_im_map_svg)) {
						$svg_path = get_attached_file($li_im_map_svg);
					} else {
						// If field returns URL
						$svg_path = str_replace(home_url('/'), ABSPATH, $li_im_map_svg);
					}

					if ($svg_path && file_exists($svg_path)) {
						echo file_get_contents($svg_path);
					} else {
						// fallback: show as <img>
						echo wp_get_attachment_image($li_im_map_svg, 'full', false, ['alt' => 'Map Image']);
					}
					?>
				</div>
			<?php endif; ?>
			<div class="swiper-container map-slides">
				<div class="swiper-wrapper">
					<?php foreach ($li_im_repeater as $row) : 
						$year = $row['li_im_year'] ?? '';
						$stats = $row['li_im_stats_details'] ?? [];?>
						<div class="swiper-slide">
							<div class="swiper-slide-container" data-map="<?php echo esc_attr($row['li_im_year']); ?>">
								<?php if (!empty($stats)) : ?>
									<div class="map-values">
										<?php foreach ($stats as $stat) :
											$stat_number = $stat['stat_number'] ?? 0;
											$stat_number_end = $stat['stat_number_end'] ?? 0;
											 ?>
											<div class="map-values-col" >
												 <div class="map-counter" data-start="<?php echo esc_attr($stat_number); ?>" data-end="<?php echo esc_attr($stat_number_end); ?>">	
													<div class="mb-0 block-title heading-2">
													<?php echo esc_html(($stat['stat_prefix'] ?? '')); ?><span class="count"><?php echo esc_attr(number_format($stat_number)); ?></span><?php echo esc_html(($stat['stat_postfix'] ?? '')); ?>
													</div>
												</div>
												<div class="ui-16-15-bold map-content">
													<?php echo esc_html($stat['stat_label'] ?? ''); ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<!-- Add Arrows -->
			<div class="drag-arrows">
				<div class="swiper-button-next" role="button" tabindex="0" aria-label="Next slide"></div>
				<span>Drag</span>
				<div class="swiper-button-prev" role="button" tabindex="0" aria-label="Previous slide" aria-disabled="true"></div>
			</div>
		</div>

		<div class="map-thumb-year">
			<div class="swiper-container map-years">
				<div class="swiper-wrapper">
					<?php foreach ($li_im_repeater as $row) : ?>
						<div class="swiper-slide" role="button" tabindex="0" aria-label="<?php echo esc_attr($row['li_im_year']); ?>">
							<div class="slide-year">
								<?php echo esc_html($row['li_im_year'] ?? ''); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

	<?php endif; ?>
	<?php echo !empty($li_im_button) ? '<div class="map-bottom-cta"><div class="map-cta-btn">' . BaseTheme::button($li_im_button, 'site-btn') . '</div></div>' : ''; ?>
</div>
</div>