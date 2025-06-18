<?php

/**
 * Block Name: Two Column Text
 *
 * The template for displaying the custom gutenberg block named Two Column Text.
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
$li_tct_headline = $bst_block_fields['li_tct_headline'] ?? null;
$li_tct_headline_check = BaseTheme::headline_check($li_tct_headline);
$li_tct_choose_variation = $bst_block_fields['li_tct_choose_variation'] ?? 'featured';
$li_tct_repeater = $bst_block_fields['li_tct_repeater'] ?? null;
$li_tct_select_design = $bst_block_fields['li_tct_select_design'] ?? 'content';
$li_tct_kicker = $bst_block_fields['li_tct_kicker'] ?? null;
$li_tct_wysiwyg = $bst_block_fields['li_tct_wysiwyg'] ?? null;
$li_tct_bg_image = $bst_block_fields['li_tct_bg_image'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';
$li_tct_background_image = $bst_block_fields['li_tct_background_image'] ?? null;
?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
	<?php 
	if($li_tct_choose_variation == 'featured'):
		include 'part/featured.php';
	endif;
	if($li_tct_choose_variation == 'standard'):
		include 'part/standard.php';
	endif;
	?>
</div>