<?php
/**
 * Block Name: Map Embed
 *
 * The template for displaying the custom gutenberg block named Map Embed.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_block_id, $bst_block_fields ) = BaseTheme::defaults( $block['id'] );

// Set the block name for it's ID & class from it's file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace( 'acf/', '', $bst_block_name );
$bst_block_styles = BaseTheme::convert_to_css( $block );
// Set the preview thumbnail for this block for gutenberg editor view.
if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
}
// create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = ( isset( $block['className'] ) ) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if( !empty($block['anchor']) ) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ( $block['name'] ) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace( '/', '-', $bst_block_name );
	$bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_me_headline = $bst_block_fields['li_me_headline'] ?? null;
$li_me_headline_check = BaseTheme::headline_check($li_me_headline);
$li_me_choose_variation = $bst_block_fields['li_me_choose_variation'] ?? 'full-width';
$li_me_title = $bst_block_fields['li_me_title'] ?? null;
$li_me_text = $bst_block_fields['li_me_text'] ?? null;
$li_me_wysiwyg = $bst_block_fields['li_me_wysiwyg'] ?? null;
$li_me_hours_title = $bst_block_fields['li_me_hours_title'] ?? null;
$li_me_hours_wysiwyg = $bst_block_fields['li_me_hours_wysiwyg'] ?? null;
$li_me_select_form_type = $bst_block_fields['li_me_select_form_type'] ?? null;
$li_me_form_selector = $bst_block_fields['li_me_form_selector'] ?? null;
$li_me_iframe = $bst_block_fields['li_me_iframe'] ?? null;
$li_me_iframe_v_two = $bst_block_fields['li_me_iframe_v_two'] ?? null
?>


<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
	<?php 
	if($li_me_choose_variation == 'full-width'):
		include 'part/full-width.php';
	endif;
	if($li_me_choose_variation == 'contact-info'):
		include 'part/contact-info.php';
	endif;
	?>
</div>