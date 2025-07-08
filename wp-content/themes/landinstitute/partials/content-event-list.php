<?php
/**
 * Template part for event list items
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Circuit of the Americas
 * @since 1.0.0
 */

 $formatedsdate = ""; 
 $formateenddate = "";

 if ($start_date) {
    $start_obj = new DateTime($start_date);
    $formatedsdate =  date_i18n('l, F j, Y', $start_obj->getTimestamp());
}

if ($end_date) {
    $end_obj = new DateTime($end_date);
    $formateenddate = ' – ' . date_i18n('l, F j, Y', $end_obj->getTimestamp());
}

?>

<div class="event-teaser-list-col">
    <a href="<?php echo esc_url($url); ?>" class="event-teaser-list-card">
        <div class="event-teaser-list-image">
            <img src="<?php echo esc_url($image); ?>" alt="">
        </div>
        <div class="event-teaser-list-content">
            <div class="gl-s64"></div>
            <div class="ui-eyebrow-18-16-regular block-subhead">
                <?php echo esc_html($formatedsdate); ?>
                <?php if ($formateenddate): ?> <?php echo esc_html($formateenddate); ?><?php endif;      
                if ($all_day) {
                    echo ' All Day';
                }
?>
            </div>
            <div class="gl-s4"></div>
            <h4 class="heading-4 mb-0 block-title"><?php the_title(); ?></h4>

            <div class="gl-s16"></div>
            <div class="block-content body-20-18-regular">
                <?php echo wp_trim_words($excerpt, 30, '...'); ?>
            </div>

            <div class="gl-s20"></div>
            <div class="block-btns">
                <div class="site-btn text-link" role="button" aria-label="Event Details">
                    Event Details
                </div>
            </div>
            <div class="gl-s64"></div>
        </div>
    </a>
</div>
