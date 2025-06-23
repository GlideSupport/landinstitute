<?php

/**
 * Block Name: CTA Slider
 *
 * The template for displaying the custom gutenberg block named CTA Slider.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

// Set the block name for it's ID & class from it's file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace('acf/', '', $bst_block_name);
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
if (!empty($block['anchor'])) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ($block['name']) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace('/', '-', $bst_block_name);
	$bst_var_name   = 'block-' . $bst_block_name;
}

// ACF Fields
$li_cs_headline = $bst_block_fields['li_cs_headline'] ?? null;
$li_cs_headline_check = BaseTheme::headline_check($li_cs_headline);
$li_cs_kicker = $bst_block_fields['li_cs_kicker'] ?? null;
$li_cs_repeater = $bst_block_fields['li_cs_repeater'] ?? null;
$li_cs_link = $bst_block_fields['li_cs_link'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';

$total_cta_count = count($li_cs_repeater);

if($total_cta_count > 1){
	$swiper_class= "swiper-wrapper";
}else{
	$swiper_class = "";
}
?>

<div class="cta-slider-block <?php echo esc_attr($border_options); ?>">
	<div class="heading-max">
		<?php echo !empty($li_cs_kicker) ? '<div class="ui-eyebrow-18-16-regular block-subhead">' . esc_html($li_cs_kicker) . '</div><div class="gl-s12"></div>' : ''; ?>
		<?php echo !empty($li_cs_headline_check) ? BaseTheme::headline($li_cs_headline, 'heading-2 block-title mb-0') : ''; ?>
	</div>
	<div class="gl-s64"></div>
	<?php if (!empty($li_cs_repeater)): ?>
		<div class="cta-slider-box">
			<div class="swiper-container cta-work-slider">
				<div class="slide-counter" style="display: none;">1 / 1</div>
				<div class="<?php echo $swiper_class; ?>">
					<?php
					foreach ($li_cs_repeater as $li_cs_rep) :
						$title = $li_cs_rep['title'];
						$wysiwyg = $li_cs_rep['wysiwyg'];
						$link = $li_cs_rep['link'];
						$image = $li_cs_rep['image'];
						if (!empty($title) || !empty($wysiwyg) || !empty($link) || !empty($image)): ?>
							<div class="swiper-slide">
								<div class="cta-slider-lft-block">
									<div class="cl-left">
										<div class="slide-content">
											<?php echo !empty($title) ? '<div class="ui-34-28-bold block-title">' . esc_html($title) . '</div>' : ''; ?>
											<?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s24"></div>' : ''; ?>
											<?php echo !empty($wysiwyg) ? '<div class="block-content">' . html_entity_decode($wysiwyg) . '</div><div class="gl-s64"></div>' : ''; ?>
											<?php echo !empty($link) ? '<div class="block-btn">' . BaseTheme::button($link, 'site-btn text-link') . '</div><div class="gl-s64"></div>' : ''; ?>
										</div>
									</div>
									<div class="cl-right">
										<?php echo !empty($image) ? '<div class="cta-image">' . wp_get_attachment_image($image, 'thumb_1000') . '</div>' : ''; ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<!-- If we need navigation buttons -->
				<div class="slider-btn">
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php echo !empty($li_cs_link) ? '<div class="block-ctn-btn">' . BaseTheme::button($li_cs_link, 'site-btn btn-butter-yellow') . '</div>' : ''; ?>
</div>