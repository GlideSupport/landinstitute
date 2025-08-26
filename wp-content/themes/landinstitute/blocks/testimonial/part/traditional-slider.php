<?php
if ($li_t_choose_variation === 'traditional-slider' && !empty($li_t_selector_testimonial)) :

    $args = [
        'post_type'      => 'testimonial',
        'post__in'       => $li_t_selector_testimonial,
        'orderby'        => 'post__in',
        'posts_per_page' => -1,
    ];
    $testimonial_query = new WP_Query($args);

    if ($testimonial_query->have_posts()) :
        $total_testimonials = $testimonial_query->found_posts;
        $unique_id = 'tslider_' . uniqid(); ?>
        <div class="testimonial-traditional-block <?php echo esc_attr($unique_id); ?>">
            <?php echo !empty($li_t_kicker) ? '<div class="ui-20-18-bold-uc block-sub-title">' . esc_html($li_t_kicker) . '</div><div class="gl-s52"></div>' : '' ?>
            <div class="testimonial-traditional-slider">
                <div class="traditional-slide swiper-container">
                    <div class="swiper-wrapper">
                        <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                            $testimonial_id     = get_the_ID();
                            $title              = html_entity_decode(get_the_title());
                            $wysiwyg            = get_field('li_cpt_t_wysiwyg', $testimonial_id);
                            $author_name        = get_field('li_cpt_t_name', $testimonial_id);
                            $author_company     = get_field('li_cpt_t_company', $testimonial_id);
                            $author_image_id    = get_post_thumbnail_id($testimonial_id);
                        ?>
                            <div class="swiper-slide">
                                <div class="testimonial-slide-group">
                                    <div class="slide-inner">
                                        <div class="col-left">
                                            <h3 class="heading-3 card-title mb-0"><?php echo esc_html($title); ?></h3>
                                            <?php echo (!empty($wysiwyg) && !empty($title)) ? '<div class="gl-s36"></div>' : ''; ?>
                                            <?php echo !empty($wysiwyg) ? '<div class="card-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
                                            <?php echo (!empty($wysiwyg) && !empty($author_name)) ? '<div class="gl-s30"></div>' : ''; ?>
                                            <?php echo !empty($author_name) ? '<div class="author-name ui-eyebrow-18-16-regular">' . esc_html($author_name) . '</div>' : ''; ?>
                                            <?php echo !empty($author_company) ? '<div class="author-description body-18-16-regular">' . esc_html($author_company) . '</div>' : ''; ?>
                                        </div>
                                        <div class="col-right">
                                            <div class="testimonial-author-image">
                                                <?php echo wp_get_attachment_image($author_image_id, 'thumb_500'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
               <?php if ($total_testimonials > 1) : ?>
                    <div class="slider-btn">
                        <div  class="swiper-button-prev prev-<?php echo esc_attr($unique_id); ?>" role="button" tabindex="0" aria-label="Previous testimonial"></div>
                        <div class="swiper-button-next next-<?php echo esc_attr($unique_id); ?>" role="button"  tabindex="0" aria-label="Next testimonial"></div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
<?php
    endif;
    wp_reset_postdata();
endif;
?>
