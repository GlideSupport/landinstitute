<?php

/**
 * Block Name: Theme Form
 *
 * The template for displaying the custom gutenberg block named Theme Form.
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
if (!empty($block['anchor'])) {
    $bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ($block['name']) {
    $bst_block_name = $block['name'];
    $bst_block_name = str_replace('/', '-', $bst_block_name);
    $bst_var_name = 'block-' . $bst_block_name;
}

// Block variables.
$li_tf_headline = $bst_block_fields['li_tf_headline'] ?? null;
$li_tf_headline_check = BaseTheme::headline_check($li_tf_headline);
$li_tf_choose_variation = $bst_block_fields['li_tf_choose_variation'] ?? null;
$li_tf_kicker = $bst_block_fields['li_tf_kicker'] ?? null;
$li_tf_form_title = $bst_block_fields['li_tf_form_title'] ?? null;
$li_tf_wysiwyg = $bst_block_fields['li_tf_wysiwyg'] ?? null;
$li_tf_select_form_type = $bst_block_fields['li_tf_select_form_type'] ?? 'gravity-form';
$li_tf_form_embed = $bst_block_fields['li_tf_form_embed'] ?? null;
$li_tf_form_selector = $bst_block_fields['li_tf_form_selector'] ?? null;  
?>


<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>">
    <?php 
	if($li_tf_choose_variation == 'variation-one'):
		include 'part/variation-one.php';
	endif;
	if($li_tf_choose_variation == 'variation-two'):
		include 'part/variation-two.php';
    endif;
	if($li_tf_choose_variation == 'variation-three'):
		include 'part/variation-three.php';
	endif;?>
</div>
