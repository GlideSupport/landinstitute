<?php
/**
 * Block Name: Logos w text
 *
 * The template for displaying the custom Gutenberg block named Logos w text.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */
list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

 // Set the block name for it's ID & class from it's file name.
 $bst_block_name   = $block['name'];
 $bst_block_name   = str_replace('acf/', '', $bst_block_name);
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
	 $bst_var_name   = 'block-' . $bst_block_name;
 }

$li_lwt_headline        = $bst_block_fields['li_lwt_headline'] ?? null;
$li_lwt_headline_check  = BaseTheme::headline_check($li_lwt_headline);
$li_lwt_repeater_logo        = $bst_block_fields['li_lwt_repeater_logo'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';
?>

<?php if (!empty($li_lwt_headline_check) || !empty($li_lwt_repeater_logo)): ?>
	<div class="logos-w-text has <?php echo esc_attr($border_options); ?>">
		<div class="heading-max">
			<?php echo !empty($li_lwt_headline_check) ? BaseTheme::headline($li_lwt_headline, 'heading-2 block-title mb-0') : ''; ?>
		</div>
		<div class="gl-s64"></div>
		<?php if (!empty($li_lwt_repeater_logo)): ?>
			<div class="logos-w-text-row">
				<?php foreach ($li_lwt_repeater_logo as $li_lwt_rep): 
					$text = $li_lwt_rep['text'] ?? '';
					$logo = $li_lwt_rep['logo'] ?? '';
					$wysiwyg = $li_lwt_rep['wysiwyg'] ?? '';
					if (!empty($logo) || !empty($wysiwyg)): ?>
						<div class="logos-w-text-col">
							<div class="row-flex">
								<?php echo !empty($logo) ? '<div class="logo-left">' . wp_get_attachment_image($logo, 'full', false, array( 'width' => 160, 'height' => 160, 'alt' => 'logos' )) . '</div>' : ''; ?>
								<div class="cl-right">
									<?php echo !empty($text) ? '<div class="ui-26-23-bold logo-title">' . esc_html($text) . '</div><div class="gl-s16"></div>' : ''; ?>
									<?php echo !empty($wysiwyg) ? '<div class="logo-content">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>