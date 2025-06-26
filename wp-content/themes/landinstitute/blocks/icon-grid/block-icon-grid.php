<?php

/**
 * Block Name: Icon Grid
 *
 * The template for displaying the custom gutenberg block named Icon Grid.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
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

// Block variables.
$li_ig_headline = $bst_block_fields['li_ig_headline'] ?? null;
$li_ig_headline_check = BaseTheme::headline_check($li_ig_headline);
$li_ig_wysiwyg = $bst_block_fields['li_ig_wysiwyg'] ?? null;
$li_ig_repeater = $bst_block_fields['li_ig_repeater'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';

if (!empty($li_ig_headline_check) || !empty($li_ig_wysiwyg) || !empty($li_ig_repeater)): ?>
<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?>	">
    <div class="<?php echo esc_attr($border_options); ?> icon-grid-block">
        <div class="heading-max">
            <?php echo !empty($li_ig_headline_check) ? BaseTheme::headline($li_ig_headline, 'heading-2 mb-0 block-title') : ''; ?>
            <?php echo (!empty($li_ig_headline_check) && !empty($li_ig_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
            <?php echo !empty($li_ig_wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_ig_wysiwyg) . '</div>' : ''; ?>   
        </div>
        <?php echo (!empty($li_ig_wysiwyg)) ? '<div class="gl-s64"></div>' : ''; ?>
        <?php if (!empty($li_ig_repeater)) { ?>
                <div class="icon-grid-row">
                    <?php   foreach ($li_ig_repeater as $li_ig_rep) {
                            $title = $li_ig_rep['title'];
                            $text = $li_ig_rep['text']; 
                            $link = $li_ig_rep['link']; 
                            $icon = $li_ig_rep['icon']; 
                            if (!empty($title) || !empty($text) || !empty($link) || !empty($icon)){ ?>
                                <div class="icon-grid-col">
                                    <?php echo !empty($icon) ? '<div class="icon-grid-image">' . wp_get_attachment_image($icon, 'thumb_100') . '</div>' : ''; ?>
                                    <?php echo (!empty($icon) || !empty($title)) ? ' <div class="gl-s24"></div>' : ''; ?>
                                    <?php echo !empty($title) ? '<div class="ui-24-21-bold cta-title">' . esc_html($title) . '</div>' : ''; ?>
                                    <?php echo (!empty($title) || !empty($text)) ? '<div class="gl-s4"></div>' : ''; ?>
                                    <?php echo !empty($text) ? '<div class="cta-content body-20-18-regular">' . esc_html($text) . '</div><div class="gl-s8"></div>' : ''; ?>
                                    <?php echo !empty($link) ? ' <div class="cta-links">' . BaseTheme::button($link, 'border-text-btn') . '</div>' : ''; ?>
                                </div>
                    <?php  } } ?>
                </div>
        <?php } ?>
    </div>
</div>
<?php endif; ?>