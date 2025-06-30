<?php
/**
 * Block Name: CTA Columns
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

$bst_block_name   = str_replace('acf/', '', $block['name']);
$bst_block_styles = BaseTheme::convert_to_css($block);
// Set the preview thumbnail for this block for gutenberg editor view.
if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
}

// ACF Fields
$li_cc_headline        = $bst_block_fields['li_cc_headline'] ?? null;
$li_cc_headline_check  = BaseTheme::headline_check($li_cc_headline);
$li_cc_repeater        = $bst_block_fields['li_cc_repeater'] ?? null;
?>

<?php if (!empty($li_cc_headline_check) || !empty($li_cc_repeater)): ?>
	<div class="cta-columns-block">
		<div class="cta-columns-two-block">
			<?php echo !empty($li_cc_headline_check) ? BaseTheme::headline($li_cc_headline, 'heading-2 block-title mb-0') : ''; ?>
			<?php echo !empty($li_cc_headline_check) ? '<div class="gl-s52"></div>' : ''; ?>
			<div class="cta-two-column-row">
				<?php if (!empty($li_cc_repeater)) : ?>
					<?php foreach ($li_cc_repeater as $li_cc_rep) : 
						$title  = $li_cc_rep['title'] ?? '';
						$text   = $li_cc_rep['text'] ?? '';
						$button = $li_cc_rep['button'] ?? '';
						$image  = $li_cc_rep['image'] ?? '';

						if (!empty($title) || !empty($text) || !empty($button) || !empty($image)) :
							$link_url = $button['url'] ?? '#';
							$link_title = $button['title'] ?? 'Learn More';
							$link_target = $button['target'] ?? '_self';
					?>
					<div class="cta-two-column-col">
						<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="cta-border-card">
							<?php echo !empty($image) ? '<div class="cta-image">' . wp_get_attachment_image($image, false) . '</div>' : ''; ?>
							<div class="cta-content">
								<?php echo (!empty($title) || !empty($text) || !empty($button)) ? '<div class="gl-s64"></div>' : ''; ?>
								<?php echo !empty($title) ? '<h3 class="heading-3 block-title mb-0">' . esc_html($title) . '</h3>' : ''; ?>
								<?php echo (!empty($title) && !empty($text)) ? '<div class="gl-s20"></div>' : ''; ?>
								<?php echo !empty($text) ? '<div class="block-content body-20-18-regular">' . esc_html($text) . '</div>' : ''; ?>
								<?php echo (!empty($text) && !empty($button)) ? '<div class="gl-s16"></div>' : ''; ?>
								<?php echo !empty($button) ? '<div class="block-btn"><div class="site-btn text-link" role="button" aria-label="' . esc_attr($link_title) . '">' . esc_html($link_title) . '</div></div>' : ''; ?>
								<?php echo (!empty($title) || !empty($text) || !empty($button)) ? '<div class="gl-s80"></div>' : ''; ?>
							</div>
						</a>
					</div>
					<?php endif; endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

