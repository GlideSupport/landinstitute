<?php
/**
 * Block Name: CTA Rows
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

$bst_block_name = str_replace('acf/', '', $block['name']);
$bst_block_styles = BaseTheme::convert_to_css($block);

// ACF Fields
$li_cr_headline = $bst_block_fields['li_cr_headline'] ?? null;
$li_cr_headline_check = BaseTheme::headline_check($li_cr_headline);
$li_cr_repeater = $bst_block_fields['li_cr_repeater'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';
?>

<?php if (!empty($li_cr_headline_check) || !empty($li_cr_repeater)) : ?>
	<div class="cta-rows-block <?php echo esc_attr($border_options); ?>">
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
						<div class="cta-rows-list-col">
							<div href="" class="cta-rows-list-card">
								<?php echo !empty($image) ? '<div class="cta-rows-list-image">' . wp_get_attachment_image($image, false) . '</div>' : ''; ?>
								<div class="cta-rows-list-content">
									<?php echo (!empty($title) || !empty($time) || !empty($text) || !empty($repeater_buttons)) ? '<div class="gl-s80"></div>' : ''; ?>
									<?php echo !empty($title) ? '<h4 class="heading-4 mb-0 block-title">' . esc_html($title) . '</h4>' : ''; ?>
									<?php echo (!empty($title) && !empty($time)) ? '<div class="gl-s4"></div>' : ''; ?>
									<?php echo !empty($time) ? '<div class="ui-eyebrow-18-16-regular block-subhead">' . esc_html($time) . '</div>' : ''; ?>
									<?php echo (!empty($title) || !empty($time)) && !empty($text) ? '<div class="gl-s16"></div>' : ''; ?>
									<?php echo !empty($text) ? '<div class="block-content body-20-18-regular">' . esc_html($text) . '</div>' : ''; ?>
									<?php echo (!empty($text) && !empty($repeater_buttons)) ? '<div class="gl-s16"></div>' : ''; ?>
									<?php if (!empty($repeater_buttons)) : ?>
										<div class="block-btns">
											<?php foreach ($repeater_buttons as $rep) :
												$button      = $rep['button'] ?? '';
												$link_url    = $button['url'] ?? '#';
												$link_title  = $button['title'] ?? 'Learn More';
												$link_target = $button['target'] ?? '_self';
											?>
												<?php echo !empty($button) ? '<div class="site-btn text-link" role="button" aria-label="' . esc_attr($link_title) . '">' . esc_html($link_title) . '</div>' : ''; ?>
												<?php echo !empty($button) ? '<div class="gl-s16"></div>' : ''; ?>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
									<?php echo (!empty($title) || !empty($text) || !empty($repeater_buttons)) ? '<div class="gl-s80"></div>' : ''; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
