<?php

/**
 * Block Name: CTA Rows
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

$bst_block_name = str_replace('acf/', '', $block['name']);
$bst_block_styles = BaseTheme::convert_to_css($block);
// Set the preview thumbnail for this block for gutenberg editor view.
if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
}
// ACF Fields
$li_cr_headline = $bst_block_fields['li_cr_headline'] ?? null;
$li_cr_headline_check = BaseTheme::headline_check($li_cr_headline);
$li_cr_repeater = $bst_block_fields['li_cr_repeater'] ?? null;
?>

<?php if (!empty($li_cr_headline_check) || !empty($li_cr_repeater)) : ?>
	<div class="cta-rows-block">
		<div class="cta-rows-list-block">
			<?php echo !empty($li_cr_headline_check) ? BaseTheme::headline($li_cr_headline, 'heading-2 block-title mb-0') : ''; ?>
			<?php echo (!empty($li_cr_headline_check) && !empty($li_cr_repeater)) ? '<div class="gl-s52"></div>' : ''; ?>
			<div class="cta-rows-list-row">
				<?php if (!empty($li_cr_repeater)) : ?>
					<?php foreach ($li_cr_repeater as $li_cr_rep) :
						$title  = $li_cr_rep['title'] ?? '';
						$time   = $li_cr_rep['time'] ?? '';
						$text   = $li_cr_rep['text'] ?? '';
						$repeater_buttons = $li_cr_rep['repeater_buttons'] ?? '';
						$image  = $li_cr_rep['image'] ?? '';
					?>
						<?php if($title || $text || $image): ?>
							<div class="cta-rows-list-col">
								<div href="" class="cta-rows-list-card">
									<?php echo !empty($image) ? '<div class="cta-rows-list-image">' . wp_get_attachment_image($image, 'thumb_500') . '</div>' : ''; ?>
									<div class="cta-rows-list-content">
										<?php echo (!empty($title) || !empty($time) || !empty($text) || !empty($repeater_buttons)) ? '<div class="gl-s80"></div>' : ''; ?>
										<?php echo !empty($title) ? '<div class="heading-4 mb-0 block-title">' . esc_html($title) . '</div>' : ''; ?>
										<?php echo (!empty($title) && !empty($time)) ? '<div class="gl-s4"></div>' : ''; ?>
										<?php echo !empty($time) ? '<div class="ui-eyebrow-18-16-regular block-subhead">' . esc_html($time) . '</div>' : ''; ?>
										<?php echo (!empty($title) || !empty($time)) || !empty($text) ? '<div class="gl-s16"></div>' : ''; ?>
										<?php echo !empty($text) ? '<div class="block-content body-20-18-regular">' . esc_html($text) . '</div>' : ''; ?>
										<?php echo (!empty($text) && !empty($repeater_buttons)) ? '<div class="gl-s16"></div>' : ''; ?>
										<?php if (!empty($repeater_buttons)) : ?>
											<div class="block-btns">
												<?php foreach ($repeater_buttons as $rep) :
													$button = $rep['button'] ?? '';
													if (!empty($button)) :
														echo BaseTheme::button($button, 'site-btn text-link');
														echo '<div class="gl-s16"></div>';
													endif;
												endforeach; ?>
											</div>
										<?php endif; ?>
										<?php echo (!empty($title) || !empty($text) || !empty($repeater_buttons)) ? '<div class="gl-s80"></div>' : ''; ?>
									</div>
								</div>
							</div>	
						<?php endif; ?>
						
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>