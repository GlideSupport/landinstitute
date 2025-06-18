<?php
// Block Fields
$li_hero_video = $bst_block_fields['li_hero_video'] ?? null;
$bg_image = $li_hero_video['bg_image'] ?? null;
$button = $li_hero_video['button'] ?? null;
$short_video_poster = $li_hero_video['short_video_poster'] ?? null;
$short_video = $li_hero_video['short_video'] ?? null;
$video_group = $li_hero_video['video_group'] ?? null;

// Headline fields (added)
$li_hero_headline = $bst_block_fields['li_hero_headline'] ?? null;
$li_hero_headline_check = !empty($li_hero_headline);

// Modal video handling
$video_type = $video_group['choose_video_type'] ?? '';
$youtube_id = $video_group['youtube_video_url'] ?? '';
$vimeo_id = $video_group['vimeo_video_url'] ?? '';
$uploaded_video = $video_group['video_file'] ?? '';

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
                <video class="videos" playsinline autoplay muted loop controls poster="' . esc_url($short_video_poster) . '">
                    <source src="' . esc_url($uploaded_video) . '" type="video/mp4">
                </video>';
        }
        break;
}
?>
<section id="hero-section" class="hero-section hero-section-default hero-video">
    <!-- hero start -->
    <?php echo $bg_image ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_image, 'thumb_1600') . '</div>' : ''; ?>
    <div class="hero-default <?php echo esc_attr($border_options); ?>">
        <div class="wrapper">
            <div class="hero-alongside-block">
                <div class="col-left bg-lime-green">
                    <div class="left-content">
                    <?php echo $li_hero_headline_check ? BaseTheme::headline($li_hero_headline, 'heading-1 mb-0 block-title') : ''; ?>
                    <?php echo ($li_hero_headline_check && !empty($button)) ? '<div class="gl-s30"></div>' : ''; ?>
                    <?php echo !empty($button) ? '<div class="block-btn">' . BaseTheme::button($button, 'site-btn text-link') . '</div>' : ''; ?>
                    </div>
                </div>
                <div class="col-right">
                <?php echo $bg_image ? '<div class="bg-pattern pattern-top-align">' . wp_get_attachment_image($bg_image, 'thumb_1600') . '</div>' : ''; ?>
                    <?php if ($short_video): ?>
                    <div class="video-play-group">
                        <div class="video-play">
                            <video class="videos" playsinline muted preload="metadata" autoplay loop
                                poster="<?php echo esc_url($short_video_poster); ?>" data-video-init>
                                <source src="<?php echo esc_url($short_video); ?>" type="video/mp4">
                            </video>
                            <?php if ($modal_video_embed): ?>
                                <div class="play-icon">
                                    <a href="#hero-video" class="site-btn sm-btn arrow-plus" data-lity>Play Video</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($modal_video_embed && $short_video ): ?>
    <div id="hero-video" class="lity-hide popup-block">
        <div class="popup-video popup-block-design">
            <div class="video-play">
                <?php echo $modal_video_embed; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
