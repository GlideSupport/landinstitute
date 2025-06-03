<?php

/**
 * Block Name: Internal Link List
 *
 * The template for displaying the custom gutenberg block named Internal Link List.
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
$li_ill_headline = $bst_block_fields['li_ill_headline'] ?? null;
$li_ill_headline_check = BaseTheme::headline_check($li_ill_headline);
$li_ill_choose_variation = $bst_block_fields['li_ill_choose_variation'] ?? 'two-column';
$li_ill_wysiwyg = $bst_block_fields['li_ill_wysiwyg'] ?? null;
$li_ill_repeater = $bst_block_fields['li_ill_repeater'] ?? null;
$li_ill_image = $bst_block_fields['li_ill_image'] ?? null;
$border_options = $bst_block_fields['li_global_border_options'] ?? 'none';

?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
	<?php 
	if($li_ill_choose_variation == 'two-column'):
		include 'part/two-column.php';
	endif;
	if($li_ill_choose_variation == 'image'):
		include 'part/image.php';
	endif;
	?>
</div>