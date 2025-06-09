<?php
/**
 * Block Name: Accordion with Image
 *
 * The template for displaying the custom Gutenberg block named Accordion with Image.
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

$li_awi_headline        = $bst_block_fields['li_awi_headline'] ?? null;
$li_awi_headline_check  = BaseTheme::headline_check($li_awi_headline);
$li_awi_wysiwyg       = $bst_block_fields['li_awi_wysiwyg'] ?? null;
$li_awi_repeater        = $bst_block_fields['li_awi_repeater'] ?? null;
$li_awi_image       = $bst_block_fields['li_awi_image'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';
?>

<?php if (!empty($li_awi_headline_check) || !empty($li_awi_repeater)): ?>
<div class="tab-content-block has <?php echo esc_attr($border_options); ?>">
	<div class="heading-max">
	    <?php echo !empty($li_awi_headline_check) ? BaseTheme::headline($li_awi_headline, 'heading-2 block-title mb-0') : ''; ?>
		<div class="gl-s30"></div>
		<?php echo !empty($li_awi_wysiwyg ) ? '<div class="block-content">' . html_entity_decode($li_awi_wysiwyg) . '</div>' : ''; ?>
	</div>
	<div class="gl-s64"></div>
	<?php if (!empty($li_awi_repeater)): ?>
	<div class="tab-click-row">
		<div class="cl-left">
			<div class="faq-block number-tab-block">
				<ol class="faq_main_container number-tab-row">
					<?php foreach ($li_awi_repeater as $li_awi_rep): 
						$short_text = $li_awi_rep['short_text'] ?? '';
						$wysiwyg = $li_awi_rep['wysiwyg'] ?? '';
						if (!empty($short_text) || !empty($wysiwyg)): ?>
						<li class="faq_container number-tab-col">
							<div class="faq_question accordion-col number-list-col">
								<div class="faq_question-text">
									<?php echo !empty($short_text) ? '<div class="faq-title mb-0 ui-20-18-bold">' . esc_html($short_text) . '</div>' : ''; ?>
								</div>
							</div>
							<div class="answercont">
								<div class="answer number-list-show">
									<?php echo !empty($li_awi_wysiwyg ) ? '<div class="body-20-18-regular faq-content">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
								</div>
							</div>
						</li>
					<?php endif; endforeach; ?>
				</ol>
			</div>
			<div class="gl-s96"></div>
		</div>
		<?php endif; ?>
		<div class="cl-right">
			<?php echo !empty($li_awi_image) ? '<div class="tab-image">' . wp_get_attachment_image($li_awi_image, 'thumb_800') . '</div>' : ''; ?>
		</div>
	</div>
</div>
<?php endif; ?>
				

