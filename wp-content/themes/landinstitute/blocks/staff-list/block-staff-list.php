<?php
/**
 * Block Name: Staff List
 *
 * The template for displaying the custom Gutenberg block named Staff List.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

$bst_block_name   = $block['name'];
$bst_block_name   = str_replace('acf/', '', $bst_block_name);
$bst_block_styles = BaseTheme::convert_to_css($block);

if (isset($block['data']['preview'])):
    echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
endif;

$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';
$bst_var_class_name  = isset($block['className']) ? $block['className'] : null;

$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if (!empty($block['anchor'])):
    $bst_block_html_id = $block['anchor'];
endif;

if ($block['name']):
    $bst_block_name = $block['name'];
    $bst_block_name = str_replace('/', '-', $bst_block_name);
    $bst_var_name   = 'block-' . $bst_block_name;
endif;

$li_sl_headline        = $bst_block_fields['li_sl_headline'] ?? null;
$li_sl_headline_check  = BaseTheme::headline_check($li_sl_headline);
$li_sl_choose_variation = $bst_block_fields['li_sl_choose_variation'] ?? 'variation-one';
$li_sl_selector = $bst_block_fields['li_sl_selector'] ?? null;
$li_sl_staff_selector = $bst_block_fields['li_sl_staff_selector'] ?? null;
$bg_color = $bst_block_fields['bg_color']['li_globel_bg_color_options'] ?? 'bg-lilac';
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';
?>

<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
	<?php 
	if($li_sl_choose_variation == 'variation-one'):
		include 'part/variation-one.php';
	endif;
	if($li_sl_choose_variation == 'variation-two'):
		include 'part/variation-two.php';
	endif;
	?>
</div>