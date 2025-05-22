<?php

/**
 * Block Name: Video Alongside Text
 *
 * The template for displaying the custom gutenberg block named Video Alongside Text.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);


// Set the block name for it's ID & class from it's file name.
$bst_block_name = $block['name'];
$bst_block_name = str_replace('acf/', '', $bst_block_name);
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
if (!empty($block['anchor'])) {
    $bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ($block['name']) {
    $bst_block_name = $block['name'];
    $bst_block_name = str_replace('/', '-', $bst_block_name);
    $bst_var_name = 'block-' . $bst_block_name;
}

// Block variables.
$aot_vat_headline = $bst_block_fields['aot_vat_headline'] ?? null;
$aot_vat_headline_check = BaseTheme::headline_check($aot_vat_headline);
$aot_vat_description = $bst_block_fields['aot_vat_description'] ?? null;
$aot_vat_button = $bst_block_fields['aot_vat_button'] ?? null;
$aot_vat_button_two = $bst_block_fields['aot_vat_button_two'] ?? null;
$link_url = (isset($aot_vat_button_two['url'])) ? $aot_vat_button_two['url'] : '';
$link_title = (isset($aot_vat_button_two['title'])) ? $aot_vat_button_two['title'] : '';
$link_target = (isset($aot_vat_button_two['target'])) ? $aot_vat_button_two['target'] : '_self';
$aot_vat_select_video = $bst_block_fields['aot_vat_select_video'] ?? null;
?>

<div id="<?php echo esc_html($bst_block_html_id); ?>"
    class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>"
    style="<?php echo esc_html($bst_block_styles); ?>    ">
    <?php if (!empty($aot_vat_select_video) || !empty($aot_vat_headline_check) || !empty($aot_vat_description) || !empty($aot_vat_button)) { ?>
    <div class="video-alongside-text bg-with-border">
        <div class="cl-left relative">
            <?php
                foreach ($aot_vat_select_video as $videos) {
                    $video_id = get_field('aot_cpt_video_url', $videos->ID);
                    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_id, $matches);

                    $video_poster = get_field('aot_cpt_video_thumbnail', $videos->ID);
                    $name = get_field('aot_cpt_video_name', $videos->ID);
                    $designation = get_field('aot_cpt_video_designation', $videos->ID);
                    if (!empty($video_id) || !empty($video_poster)) { ?>
            <div class="pop-video-column">
                <a class="single-video open-modal" href="https://www.youtube.com/embed/<?php echo $video_id; ?>"
                    data-lity>
                    <div class="video-group-play">
                        <?php if (!empty($video_poster)) {
                                        echo wp_get_attachment_image($video_poster, 'thumb_800');
                                    } else {
                                        $youtube_thumbnail = "https://img.youtube.com/vi/" . $video_id . "/sddefault.jpg"; ?>
                        <img src="<?php echo esc_attr($youtube_thumbnail); ?>">
                        <?php } ?>
                    </div>
                    <div class="video-author-name">
                        <?php if (!empty($name)) { ?>
                        <div class="label-l-med author-title"><?php echo esc_html($name); ?></div>
                        <?php } ?>
                        <?php if (!empty($designation)) { ?>
                        <div class="text-s-reg author-position"><?php echo esc_html($designation); ?></div>
                        <?php } ?>
                    </div>
                    <?php if (!empty($video_id)) { ?>
                    <div class="video-play-icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/images/play-icon.svg"
                            width="30" height="30" alt="Play icon" />
                    </div>
                    <?php } ?>
                </a>
            </div>
            <?php }
                } ?>
        </div>
        <?php if (!empty($aot_vat_headline_check) || !empty($aot_vat_description) || !empty($aot_vat_button)) { ?>
        <div class="cl-right relative">
            <?php if (!empty($aot_vat_headline_check)) {
                        echo BaseTheme::headline($aot_vat_headline, 'heading-3 block-title mb-0');
                    } ?>
            <?php if (!empty($aot_vat_description)) { ?>
            <div class="gl-s24"></div>
            <div class="text-l-reg block-content">
                <?php echo html_entity_decode($aot_vat_description); ?>
            </div>
            <?php } ?>
            <?php if (!empty($aot_vat_button) || !empty($aot_vat_button_two)) { ?>
            <div class="gl-s36"></div>
            <div class="block-btn two-btn">
                <?php echo BaseTheme::button($aot_vat_button, 'site-btn btn-py13-t18'); ?>
                <?php if (!empty($aot_vat_button_two)) { ?>
                <a class="site-btn white-btn" href="<?php echo esc_url($link_url); ?>" download title="PDF"
                    role="button" aria-label="PDF"
                    target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?>
                </a>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>