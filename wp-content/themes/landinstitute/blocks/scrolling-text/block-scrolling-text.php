<?php
/**
 * Block Name: Scrolling Text
 *
 * The template for displaying the custom Gutenberg block named Scrolling Text.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_block_id, $bst_block_fields ) = BaseTheme::defaults( $block['id'] );

$bst_block_name   = $block['name'];
$bst_block_name   = str_replace( 'acf/', '', $bst_block_name );
$bst_block_styles = BaseTheme::convert_to_css( $block );

if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
}

$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';
$bst_var_class_name = ( isset( $block['className'] ) ) ? $block['className'] : null;

$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$bst_block_html_id = $block['anchor'];
}

if ( $block['name'] ) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace( '/', '-', $bst_block_name );
	$bst_var_name   = 'block-' . $bst_block_name;
}

$li_st_headline = $bst_block_fields['li_st_headline'] ?? null;
$li_st_headline_check = BaseTheme::headline_check($li_st_headline);
$li_st_wysiwyg    = $bst_block_fields['li_st_wysiwyg'] ?? null;
$li_st_repeater  = $bst_block_fields['li_st_repeater'] ?? null;

if(!empty($li_st_headline_check) || !empty($li_st_wysiwyg) || !empty($li_st_repeater) ): ?>
	<div class="scrolling-text-block">
		<div class="col-left">
			<div class="sticky-parent">
				<div class="sticky-top-touch">
					<?php echo (!empty($li_st_headline_check) || !empty($li_st_wysiwyg)) ? '<div class="gl-s64"></div>' : ''; ?>
					<?php echo !empty($li_st_headline_check) ? BaseTheme::headline($li_st_headline, 'heading-4 block-title mb-0') : ''; ?>
					<?php echo (!empty($li_st_headline_check) && !empty($li_st_wysiwyg)) ? '<div class="gl-s12"></div>' : ''; ?>
					<?php echo !empty($li_st_wysiwyg) ? '<div class="block-content body-18-16-regular">' . html_entity_decode($li_st_wysiwyg) . '</div>' : ''; ?>
					<?php echo (!empty($li_st_headline_check) || !empty($li_st_wysiwyg)) ? '<div class="gl-s64"></div>' : ''; ?>
				</div>
			</div>
		</div>
		<?php if (!empty($li_st_repeater)) : ?>
		<div class="col-right bg-lilac">
			<div class="scrolling-text-row">
				<?php foreach ($li_st_repeater as $li_st_rep) :
					$title   = $li_st_rep['title'] ?? '';
					$wysiwyg = $li_st_rep['wysiwyg'] ?? '';
					if (!empty($title) || !empty($wysiwyg)) : ?>
					<div class="scrolling-text-col">
						<?php echo (!empty($title) || !empty($wysiwyg)) ? '<div class="gl-s64"></div>' : ''; ?>
						<?php echo !empty($title) ? '<div class="heading-2 block-title mb-0">' . esc_html($title) . '</div>' : ''; ?>
						<?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s20"></div>' : ''; ?>
						<?php echo !empty($wysiwyg) ? '<div class="list-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
						<?php echo (!empty($title) || !empty($wysiwyg)) ? '<div class="gl-s64"></div>' : ''; ?>
					</div>
				<?php endif; endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
</div>
<?php endif; ?>

