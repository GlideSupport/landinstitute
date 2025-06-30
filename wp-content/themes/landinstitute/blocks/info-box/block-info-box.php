<?php

/**
 * Block Name: Info Box
 *
 * The template for displaying the custom gutenberg block named Info Box.
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
$li_ib_headline = $bst_block_fields['li_ib_headline'] ?? null;
$li_ib_headlinee_check = BaseTheme::headline_check($li_ib_headline);
$li_ib_kicker = $bst_block_fields['li_ib_kicker'] ?? null;
$li_ib_wysiwyg = $bst_block_fields['li_ib_wysiwyg'] ?? null;
$li_ib_image = $bst_block_fields['li_ib_image'] ?? null;
$li_ib_link = $bst_block_fields['li_ib_link'] ?? null;

?>

<?php if(!empty($li_ib_headlinee_check) || !empty($li_ib_kicker) || !empty($li_ib_wysiwyg) || !empty($li_ib_image) || !empty($li_ib_link)): ?>
	<div class="cta-slider-block variation-static">
		<div class="heading-max">
			<?php echo !empty($li_ib_kicker) ? '<div class="ui-eyebrow-18-16-regular block-subhead">' . esc_html($li_ib_kicker) . '</div><div class="gl-s12"></div>' : ''; ?>
			<?php echo !empty($li_ib_headlinee_check) ? BaseTheme::headline($li_ib_headline, 'heading-2 block-title mb-0') : ''; ?>
		</div>
		<?php echo (!empty($li_ib_kicker) && !empty($li_ib_headlinee_check)) ? '<div class="gl-s64"></div>' : ''; ?>
		<?php if(!empty($li_ib_wysiwyg) || !empty($li_ib_image)): ?>
			<div class="cta-slider-box">
				<div class="cta-slider-lft-block">
					<div class="cl-left">
						<div class="slide-content">
							<?php echo !empty($li_ib_wysiwyg) ? '<div class="block-content">' . html_entity_decode($li_ib_wysiwyg) . '</div><div class="gl-s64"></div>' : ''; ?>
						</div>
					</div>
					<div class="cl-right">
						<?php echo !empty($li_ib_image) ? '<div class="cta-image">' . wp_get_attachment_image($li_ib_image, 'thumb_800') . '</div>' : ''; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php echo !empty($li_ib_link) ? '<div class="block-ctn-btn">' . BaseTheme::button($li_ib_link, 'site-btn btn-butter-yellow') . '</div>' : ''; ?>
	</div>
<?php endif; ?>