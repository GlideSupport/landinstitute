<?php

/**
 * Block Name: Letter
 *
 * The template for displaying the custom gutenberg block named Letter.
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
$li_l_kicker = $bst_block_fields['li_l_kicker'] ?? null;
$li_l_wysiwyg = $bst_block_fields['li_l_wysiwyg'] ?? null;
$li_l_signature = $bst_block_fields['li_l_signature'] ?? null;
$li_l_name = $bst_block_fields['li_l_name'] ?? null;
$li_l_title = $bst_block_fields['li_l_title'] ?? null;
$li_l_image = $bst_block_fields['li_l_image'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';

if (!empty($li_l_kicker) || !empty($li_l_wysiwyg) || !empty($li_l_signature)  || !empty($li_l_name)  || !empty($li_l_title)  || !empty($li_l_image)): ?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
    <div class="letter-block bg-base-cream <?php echo esc_attr($border_options); ?>">
        <?php echo !empty($li_l_kicker) ? '<div class="gl-s96"></div><div class="ui-26-23-bold letter-title">' . esc_html($li_l_kicker) . '</div>' : ''; ?>
        <?php echo (!empty($li_l_kicker) && !empty($li_l_wysiwyg)) ? '<div class="gl-s24"></div>' : ''; ?>
        <?php echo !empty($li_l_wysiwyg) ? '<div class="letter-content body-20-18-regular">' . html_entity_decode($li_l_wysiwyg) . '</div><div class="gl-s52"></div>' : ''; ?>   
        <div class="letter-row">
            <div class="cl-left">
                <?php echo !empty($li_l_signature) ? '<div class="signature-img">' . wp_get_attachment_image($li_l_signature, 'thumb_200') . '</div><div class="gl-s20"></div>' : ''; ?>
                <?php echo !empty($li_l_name) ? '<div class="ui-eyebrow-18-16-regular signature-title">' . esc_html($li_l_name) . '</div>' : ''; ?>
                <?php echo !empty($li_l_title) ? '<div class="body-18-16-regular signature-content">' . esc_html($li_l_title) . '</div><div class="gl-s36"></div>' : ''; ?>
                
            </div>
            <div class="cl-right">
                <?php echo !empty($li_l_image) ? wp_get_attachment_image($li_l_image, 'thumb_400') : ''; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>