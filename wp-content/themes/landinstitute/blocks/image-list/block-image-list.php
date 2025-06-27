<?php
/**
* Block Name: Image List
*
* The template for displaying the custom Gutenberg block named Image List.
*
* @package Base Theme Package
* @since 1.0.0
*/
 
list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);
 
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace('acf/', '', $bst_block_name);
$bst_block_styles = BaseTheme::convert_to_css($block);
 
if (isset($block['data']['preview'])) {
	echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
}
 
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';
$bst_var_class_name  = $block['className'] ?? null;
 
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if (!empty($block['anchor'])) {
	$bst_block_html_id = $block['anchor'];
}
 
if ($block['name']) {
	$bst_block_name = str_replace('/', '-', $block['name']);
	$bst_var_name   = 'block-' . $bst_block_name;
}
 
// Block variables

$li_il_headline = $bst_block_fields['li_il_headline'] ?? null;
$li_il_headline_check = BaseTheme::headline_check($li_il_headline);
$li_il_repeater = $bst_block_fields['li_il_repeater'] ?? null;
$border_options = $bst_block_fields['li_global_border_options'] ?? 'none';

if (!empty($li_il_headline_check) || !empty($li_il_repeater)): ?>
    <div class="image-list-block">
        <?php echo !empty($li_il_headline_check) ? BaseTheme::headline($li_il_headline, 'heading-3 block-title mb-0') : ''; ?>
        <?php echo (!empty($li_il_headline_check) && !empty($li_il_repeater)) ? '<div class="gl-s36"></div>' : ''; ?>
        <?php if (!empty($li_il_repeater)) : ?>
            <div class="image-list-row">
            <?php foreach ($li_il_repeater as $li_il_rep):
                $title   = $li_il_rep['title'] ?? '';
                $subtitle = $li_il_rep['subtitle'] ?? '';
                $wysiwyg = $li_il_rep['wysiwyg'] ?? '';
                $image = $li_il_rep['image'] ?? '';
                if (!empty($title) || !empty($subtitle) || !empty($wysiwyg) || !empty($image)): ?>
                    <div class="image-list-col">
                        <div class="row-flex">
                            <div class="cl-left">
                                <?php echo !empty($image) ? '<div class="team-img">' . wp_get_attachment_image($image, false) . '</div>' : ''; ?>
                            </div>
                            <div class="cl-right">
                                <?php echo !empty($title) ? '<h5 class="heading-5 block-title mb-0">' . esc_html($title) . '</h5>' : ''; ?>
								<?php echo (!empty($title) && !empty($subtitle)) ? '<div class="gl-s4"></div>' : ''; ?>
                                <?php echo !empty($subtitle) ? '<div class="ui-eyebrow-16-15-regular team-sub">' . esc_html($subtitle) . '</div>' : ''; ?>
                                <?php echo (!empty($subtitle) && !empty($wysiwyg)) ? '<div class="gl-s16"></div>' : ''; ?>
                                <?php echo !empty($wysiwyg) ? '<div class="team-desc"><div class="team-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div></div>' : ''; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>