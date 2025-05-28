<?php

/**
 * Block Name: Image Alongside Text 
 *
 * The template for displaying the custom gutenberg block named Image Alongside Text.
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
$li_iat_headline = $bst_block_fields['li_iat_headline'] ?? null;
$li_iat_headline_check = BaseTheme::headline_check($li_iat_headline);
$li_iat_choose_variation = $bst_block_fields['li_iat_choose_variation'] ?? 'pattern';
$li_iat_kicker = $bst_block_fields['li_iat_kicker'] ?? null;
$li_iat_wysiwyg = $bst_block_fields['li_iat_wysiwyg'] ?? null;
$li_iat_button = $bst_block_fields['li_iat_button'] ?? null;
$li_iat_image_position = $bst_block_fields['li_iat_image_position'] ?? 'left';
$li_iat_image = $bst_block_fields['li_iat_image'] ?? null;
$li_iat_bg_image = $bst_block_fields['li_iat_bg_image'] ?? null;
$border_options = $bst_block_fields['border_options']['li_globel_border_options'] ?? 'none';
$image_position_class = ($li_iat_image_position == 'right') ? 'block-rtl' : '';
?>

<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
<?php 
	if($li_iat_choose_variation == 'pattern'):
		include 'part/pattern.php';
	endif;
	if($li_iat_choose_variation == 'standard'):
		include 'part/standard.php';
	endif;
    ?>
</div>