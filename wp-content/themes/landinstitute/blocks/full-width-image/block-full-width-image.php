<?php

/**
 * Block Name: Full Width Image
 *
 * The template for displaying the custom gutenberg block named Full Width Image.
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
if( !empty($block['anchor']) ) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ($block['name']) {
    $bst_block_name = $block['name'];
    $bst_block_name = str_replace('/', '-', $bst_block_name);
    $bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_fwi_headline = $bst_block_fields['li_fwi_headline'] ?? null;
$li_fwi_headline_check = BaseTheme::headline_check($li_fwi_headline);
$li_fwi_wysiwyg = $bst_block_fields['li_fwi_wysiwyg'] ?? null;
$li_fwi_image = $bst_block_fields['li_fwi_image'] ?? null;
$border_options = $bst_block_fields['li_global_border_options'] ?? 'none'; ?>

<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
    <?php if (!empty($li_fwi_headline_check) || !empty($li_fwi_wysiwyg) || !empty($li_fwi_image) ): ?>
        <div class="block-chart <?php echo esc_attr($border_options); ?>">
            <div class="block-head">
                <?php echo !empty($li_fwi_headline_check) ? BaseTheme::headline($li_fwi_headline, 'heading-2 block-title mb-0') : ''; ?>
                <?php echo (!empty($li_fwi_headline_check) || !empty($li_fwi_wysiwyg)) ? ' <div class="gl-s30"></div>' : ''; ?>
                <?php echo !empty($li_fwi_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_fwi_wysiwyg) . '</div><div class="gl-s36"></div>' : ''; ?>    
            </div>
            <?php echo !empty($li_fwi_image) ? '<div class="chart-data">' . wp_get_attachment_image($li_fwi_image, 'thumb_1600') . '<div class="map-icon desktop-none"><a href="#map-popup" class="radius-btn" data-lity="data-lity">Zoom chart</a></div></div>' : ''; ?>
        </div>
    <?php endif; ?>
</div>
<!-- Map popup mobile -->
<?php echo !empty($li_fwi_image) ? '<div id="map-popup" class="lity-hide popup-block map-modal"><div class="popup-video popup-block-design"><div class="map-play">' . wp_get_attachment_image($li_fwi_image, 'thumb_1600') . '</div></div></div>' : ''; ?>
