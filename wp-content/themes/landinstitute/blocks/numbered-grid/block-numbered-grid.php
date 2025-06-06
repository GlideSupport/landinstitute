<?php
/**
 * Block Name: Numbered Grid
 *
 * The template for displaying the custom Gutenberg block named Numbered Grid.
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

$li_ng_headline        = $bst_block_fields['li_ng_headline'] ?? null;
$li_ng_headline_check  = BaseTheme::headline_check($li_ng_headline);
$li_ng_wysiwyg         = $bst_block_fields['li_ng_wysiwyg'] ?? null;
$li_ng_repeater        = $bst_block_fields['li_ng_repeater'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';

if (!empty($li_ng_headline_check) || !empty($li_ng_wysiwyg) || !empty($li_ng_repeater) ): ?>
	<div class="numbered-grid-block <?php echo esc_attr($border_options); ?>">
		<div class="heading-max">
			<?php echo !empty($li_ng_headline_check) ? BaseTheme::headline($li_ng_headline, 'heading-2 block-title mb-0') : ''; ?>
			<?php echo (!empty($li_ng_headline_check) && !empty($li_ng_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
			<?php echo !empty($li_ng_wysiwyg) ? '<div class="block-content">' . html_entity_decode($li_ng_wysiwyg) . '</div>' : ''; ?>
		</div>
		<?php if (!empty($li_ng_repeater)): ?>
			<div class="gl-s64"></div>
			<div class="numbered-grid-row">
				<ol>
					<?php foreach ($li_ng_repeater as $li_ng_rep):
						$title   = $li_ng_rep['title'] ?? '';
						$wysiwyg = $li_ng_rep['wysiwyg'] ?? '';
						if (!empty($title) || !empty($wysiwyg)): ?>
							<li>
								<?php echo !empty($title) ? '<div class="ui-24-21-bold number-title">' . esc_html($title) . '</div>' : ''; ?>
								<?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s4"></div>' : ''; ?>
								<?php echo !empty($wysiwyg) ? '<div class="body-20-18-regular number-content">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
							</li>
					<?php endif; endforeach; ?>
				</ol>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
