<?php
$post_id = $args['post_id'] ?? get_the_ID();

$event_title   = get_the_title($post_id);
$event_link    = get_permalink($post_id);
$excerpt       = get_the_excerpt($post_id);
$event_content = wp_trim_words($excerpt, 25, '...');
$event_date    = get_formatted_event_datetime($post_id);
$city_state    = get_field('li_cpt_event_city_state', $post_id);
?>

<div class="filter-content-card-item">
    <a href="<?php echo esc_url($event_link); ?>" class="filter-content-card-link">

        <div class="filter-card-content">

            <div class="gl-s52"></div>

            <div class="eyebrow ui-eyebrow-16-15-regular">
                <?php echo $event_date; ?>
            </div>

            <div class="gl-s6"></div>

            <div class="eyebrow ui-eyebrow-16-15-regular">
                <?php echo esc_html($city_state); ?>
            </div>

            <div class="gl-s4"></div>

            <div class="card-title heading-6 mb-0">
                <?php echo html_entity_decode($event_title); ?>
            </div>

            <div class="gl-s16"></div>

            <div class="description ui-18-16-regular">
                <?php echo $event_content; ?>
            </div>

            <div class="gl-s20"></div>

            <div class="read-more-link">
                <div class="border-text-btn">Event Details</div>
            </div>

            <div class="gl-s80"></div>

        </div>

    </a>
</div>