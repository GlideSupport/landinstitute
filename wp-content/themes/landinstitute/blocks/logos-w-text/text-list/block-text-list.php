<?php

/**
 * Block Name: Text List
 *
 * The template for displaying the custom gutenberg block named Text List.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

// Set the block name for its ID & class from its file name.
$bst_block_name = $block['name'];
$bst_block_name = str_replace('acf/', '', $bst_block_name);
$bst_block_styles = BaseTheme::convert_to_css($block);

// Set preview thumbnail
if (isset($block['data']['preview'])) {
    echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
}

// Create align class
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';
$bst_var_class_name = $block['className'] ?? null;

// Make unique ID
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if (!empty($block['anchor'])) {
    $bst_block_html_id = $block['anchor'];
}
if ($block['name']) {
    $bst_block_name = str_replace('/', '-', $block['name']);
    $bst_var_name = 'block-' . $bst_block_name;
}

// Block variables
$li_tl_headline = $bst_block_fields['li_tl_headline'] ?? null;
$li_tl_headline_check = BaseTheme::headline_check($li_tl_headline);
$li_tl_wysiwyg = $bst_block_fields['li_tl_wysiwyg'] ?? null;
$li_tl_repeater = $bst_block_fields['li_tl_repeater'] ?? null;
$li_tl_image = $bst_block_fields['li_tl_image'] ?? null;
$li_tl_link = $bst_block_fields['li_tl_link'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';
?>

<?php if (!empty($li_tl_headline_check) || !empty($li_tl_wysiwyg) || !empty($li_tl_repeater) || !empty($li_tl_image) || !empty($li_tl_link) ): ?>
    <div class="download-list sticky-lft-block <?php echo esc_attr($border_options); ?>">
        <div class="row-flex">
            <?php if (!empty($li_tl_image)) : ?>
                <div class="col-left sticky-img">
                    <?php echo wp_get_attachment_image($li_tl_image, 'thumb_800', false); ?>
                </div>
            <?php endif; ?>
            <div class="cl-right">
                <?php echo (!empty($li_tl_headline_check)) ? '<div class="gl-s156"></div>' : ''; ?>
                <?php echo (!empty($li_tl_headline_check)) ? BaseTheme::headline($li_tl_headline, 'heading-2 block-title mb-0') : ''; ?>
                <?php echo (!empty($li_tl_headline_check) && !empty($li_tl_wysiwyg)) ? '<div class="gl-s30"></div>' : ''; ?>
                <?php echo (!empty($li_tl_wysiwyg)) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($li_tl_wysiwyg) . '</div>' : ''; ?>
                <?php echo (!empty($li_tl_wysiwyg) && !empty($li_tl_repeater)) ? '<div class="gl-s30"></div>' : ''; ?>
                <?php if (!empty($li_tl_repeater)) : ?>
                <div class="card-list">
                        <?php foreach ($li_tl_repeater as $li_tl_rep) :
                            $title = $li_tl_rep['title'] ?? '';
                            $wysiwyg = $li_tl_rep['wysiwyg'] ?? '';
                            if(!empty($title) || !empty($$wysiwyg) ): ?>
                            <a href="#" class="card-item link-with-title">
                                <div class="card-item-left">
                                    <?php echo (!empty($title)) ? '<div class="card-title ui-24-21-bold">' . esc_html($title) . '</div>' : ''; ?>
                                    <?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s4"></div>' : ''; ?>
                                    <?php echo (!empty($wysiwyg)) ? '<div class="card-content body-18-16-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
                                </div>
                            </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php echo (!empty($li_tl_repeater) && !empty($li_tl_link)) ? '<div class="gl-s96"></div>' : ''; ?>
                <?php echo (!empty($li_tl_link)) ? '<div class="block-btn">' . BaseTheme::button($li_tl_link, 'site-btn') . '</div>' : ''; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
