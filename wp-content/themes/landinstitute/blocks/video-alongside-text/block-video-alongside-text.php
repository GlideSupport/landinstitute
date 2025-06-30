<?php
/**
 * Block Name: Video Alongside Text
 *
 * The template for displaying the custom Gutenberg block named Video Alongside Text.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_block_id, $bst_block_fields ) = BaseTheme::defaults( $block['id'] );

// Set the block name for its ID & class from its file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace( 'acf/', '', $bst_block_name );
$bst_block_styles = BaseTheme::convert_to_css( $block );

// Set the preview thumbnail for this block for Gutenberg editor view.
if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
}

// Create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = ( isset( $block['className'] ) ) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if( !empty($block['anchor']) ) {
	$bst_block_html_id = $block['anchor'];
}

// Making the unique ID for the block.
if ( $block['name'] ) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace( '/', '-', $bst_block_name );
	$bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_vat_headline = $bst_block_fields['li_vat_headline'] ?? null;
$li_vat_headline_check = BaseTheme::headline_check($li_vat_headline);
$li_vat_kicker = $bst_block_fields['li_vat_kicker'] ?? null;
$li_vat_wysiwyg = $bst_block_fields['li_vat_wysiwyg'] ?? null;
$li_vat_short_video_poster = $bst_block_fields['li_vat_short_video_poster'] ?? null;
$li_vat_short_video = $bst_block_fields['li_vat_short_video'] ?? null;
$video_group = $bst_block_fields['li_vat_video'] ?? null;
$border_options = $bst_block_fields['border_options']['li_global_border_options'] ?? 'none';

// Modal video handling
$video_type     = $video_group['li_vat_choose_video_type'] ?? '';
$youtube_id     = $video_group['li_vat_youtube_video_url'] ?? '';
$vimeo_id       = $video_group['li_vat_vimeo_video_url'] ?? '';
$uploaded_video = $video_group['li_vat_video_file'] ?? '';

$modal_video_embed = '';
switch ($video_type) {
    case 'youtube':
        if ($youtube_id) {
            $src = 'https://www.youtube.com/embed/' . esc_attr($youtube_id) . '?autoplay=1&mute=1&rel=0&playsinline=1';
            $modal_video_embed = '<iframe src="' . esc_url($src) . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        }
        break;
    case 'vimeo':
        if ($vimeo_id) {
            $src = 'https://player.vimeo.com/video/' . esc_attr($vimeo_id) . '?autoplay=1&muted=1&title=0&byline=0&portrait=0';
            $modal_video_embed = '<iframe src="' . esc_url($src) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
        }
        break;
    case 'Upload':
        if ($uploaded_video) {
            $modal_video_embed = '
                <video class="videos" playsinline autoplay muted loop controls poster="' . esc_url($li_vat_short_video_poster) . '">
                    <source src="' . esc_url($uploaded_video) . '" type="video/mp4">
                </video>';
        }
        break;
}

?>

<div class="video-alongside-text <?php echo esc_attr($border_options); ?>">
    <?php if(!empty($li_vat_headline_check) || !empty($li_vat_kicker)): ?>
        <div class="heading-max">
            <?php echo !empty($li_vat_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($li_vat_kicker) . '</div>' : ''; ?>
            <?php echo (!empty($li_vat_headline_check) && !empty($li_vat_kicker)) ? '<div class="gl-s12"></div>' : ''; ?>
            <?php echo !empty($li_vat_headline_check) ? BaseTheme::headline($li_vat_headline, 'heading-2 block-title mb-0') : ''; ?>
        </div>
    <?php endif; ?>
    <?php echo (!empty($li_vat_headline_check) && !empty($li_vat_kicker)) ? '<div class="gl-s52"></div>' : ''; ?>
    <div class="video-alongside-row">
        <div class="cl-left">
            <?php echo !empty($li_vat_wysiwyg) ? '<div class="block-content">' . html_entity_decode($li_vat_wysiwyg) . '</div><div class="gl-s96"></div>' : ''; ?> 
        </div>
        <div class="cl-right">
            <div class="video-play-group">
                <div class="video-play">
                    <video class="videos" playsinline="playsinline" muted="muted" preload="metadata" autoplay="autoplay" loop="loop"
                        poster="<?php echo esc_url($li_vat_short_video_poster); ?>" data-video-init="">
                        <source src="<?php echo esc_url($li_vat_short_video); ?>"  type="video/mp4">
                    </video>
                    <?php if ($modal_video_embed): ?>
                        <div class="play-icon">
                            <a href="#lity-iframe-video" class="site-btn sm-btn arrow-plus" data-lity>Play Video</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($modal_video_embed): ?>
    <div id="lity-iframe-video" class="lity-hide popup-block">
        <div class="popup-video popup-block-design">
            <div class="video-play">
                <?php echo $modal_video_embed; ?>
            </div>
        </div>
    </div>
<?php endif; ?>