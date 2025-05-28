<?php
/**
 * Block Name: Hero
 *
 * The template for displaying the custom gutenberg block named Hero.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_block_id, $bst_block_fields ) = BaseTheme::defaults( $block['id'] );
list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults(get_the_ID());


// Set the block name for it's ID & class from it's file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace( 'acf/', '', $bst_block_name );
$bst_block_styles = BaseTheme::convert_to_css( $block );
// Set the preview thumbnail for this block for gutenberg editor view.
if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
}
// create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = ( isset( $block['className'] ) ) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];

// Making the unique ID for the block.
if ( $block['name'] ) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace( '/', '-', $bst_block_name );
	$bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_hero_headline = $bst_block_fields['li_hero_headline'] ?? null;
$li_hero_choose_variation = $bst_block_fields['li_hero_choose_variation'] ?? 'home';
$li_hero_headline_check = BaseTheme::headline_check($li_hero_headline);


$bg_color = $bst_block_fields['bg_color']['li_globel_bg_color_options'] ?? 'bg-lilac';
$border_options = $bst_block_fields['border_options']['li_globel_border_options'] ?? 'none';
?>

<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
	<?php 
	if($li_hero_choose_variation == 'home'):
		include 'part/home.php';
	endif;
	if($li_hero_choose_variation == 'menu'):
		include 'part/menu.php';
	endif;
	if($li_hero_choose_variation == 'standard'):
		include 'part/standard.php';
	endif;
	if($li_hero_choose_variation == 'video'):
		include 'part/video.php';
	endif;
	if($li_hero_choose_variation == 'blog-teaser'):
		include 'part/blog-teaser.php';
	endif;
	if($li_hero_choose_variation == 'text-only'):
		include 'part/text-only.php';
	endif;
	if($li_hero_choose_variation == 'form'):
		include 'part/form.php';
	endif;	
	?>
</div>
