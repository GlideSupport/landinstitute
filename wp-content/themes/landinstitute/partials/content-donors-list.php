<?php

$image_id = get_post_thumbnail_id(get_the_ID());
$title    = html_entity_decode(get_the_title());

$title_words   = explode(' ', trim($title));
$first_initial = !empty($title_words[0]) ? strtoupper($title_words[0][0]) : '';
$last_initial  = !empty($title_words[1]) ? strtoupper($title_words[1][0]) : '';
$initials      = $first_initial . $last_initial;

$image_html = $image_id
    ? wp_get_attachment_image($image_id, 'full', false, [
        'width'  => 200,
        'height' => 102,
        'alt'    => esc_attr($title),
    ])
    : '';

$levels     = get_the_terms(get_the_ID(), 'donation-level');
$level_name = (!empty($levels) && !is_wp_error($levels)) ? $levels[0]->name : '';
?>

<div class="filter-logos-col">
    <div class="filter-logos-click">

        <?php if ($image_html) : ?>
            <div class="brand-logo brand-lists">
                <?php echo $image_html; ?>
            </div>
        <?php else : ?>
            <div class="brand-name brand-lists">
                <div class="brand-group-name">
                    <?php echo esc_html($initials); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="logo-content">
            <div class="gl-s24"></div>

            <div class="ui-20-18-bold logo-title">
                <?php echo $title; ?>
            </div>

            <div class="gl-s2"></div>

            <?php if ($level_name) : ?>
                <div class="body-18-16-regular logo-content">
                    <?php echo esc_html($level_name); ?>
                </div>
            <?php endif; ?>

            <div class="gl-s24"></div>
        </div>

    </div>
</div>