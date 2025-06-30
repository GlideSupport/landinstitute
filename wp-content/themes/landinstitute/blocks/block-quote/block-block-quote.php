<?php
/**
 * Block Name: Block Quote
 *
 * The template for displaying the custom gutenberg block named Block Quote.
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
$li_bq_kicker = $bst_block_fields['li_bq_kicker'] ?? null;
$li_bq_quote = $bst_block_fields['li_bq_quote'] ?? null;
$li_bq_name = $bst_block_fields['li_bq_name'] ?? null;
$li_bq_title = $bst_block_fields['li_bq_title'] ?? null;
 


if (!empty($li_bq_kicker) || !empty($li_bq_quote) || !empty($li_bq_name) || !empty($li_bq_title)) : ?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>">
	<div class="quote-block">
		<blockquote class="block-quote">
		<?php echo !empty($li_bq_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_bq_kicker) . '</div>' : ''; ?>
		<?php echo (!empty($li_bq_kicker) && !empty($li_bq_quote)) ? '<div class="gl-s12"></div>' : ''; ?>
		<?php echo !empty($li_bq_quote) ? '<h4 class="heading-4 mb-0 quote-title">' . html_entity_decode($li_bq_quote) . '</h4><div class="gl-s44"></div>' : ''; ?>	
			<div class="block-quote-author">
				<div class="author-details">
				<?php echo !empty($li_bq_name) ? '<div class="author-name ui-eyebrow-18-16-regular">' . esc_html($li_bq_name) . '</div>' : ''; ?>
				<?php echo !empty($li_bq_title) ? '<div class="author-designation body-18-16-regular">' . esc_html($li_bq_title) . '</div><div class="gl-s80"></div>' : ''; ?>
				</div>
			</div>
		</blockquote>
	</div>
</div>
<?php endif; ?>