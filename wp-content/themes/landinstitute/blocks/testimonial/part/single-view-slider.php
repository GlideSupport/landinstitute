<?php
if ($li_t_choose_variation === 'single-view-slider' && !empty($li_t_selector_testimonial)) :

    $args = [
        'post_type'      => 'testimonial',
        'post__in'       => $li_t_selector_testimonial,
        'orderby'        => 'post__in',
        'posts_per_page' => -1,
    ];

    $testimonial_query = new WP_Query($args);

    if ($testimonial_query->have_posts()) :
        $total_testimonials = $testimonial_query->found_posts; ?>
        <div class="testimonial-single-view-slider">
            <?php if (!empty($li_t_kicker)) : ?>
                <div class="eyebrow-title ui-eyebrow-18-16-regular"><?php echo esc_html($li_t_kicker); ?></div>
                <div class="gl-s12"></div>
            <?php endif; ?>
            <div class="single-view-slide swiper">
                <div class="swiper-wrapper">
                    <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post(); ?>
                        <?php
                        $testimonial_id            = get_the_ID();
                        $title              = get_the_title();
                        $wysiwyg            = get_field('li_cpt_t_wysiwyg', $testimonial_id);
                        $author_name        = get_field('li_cpt_t_name', $testimonial_id);
                        $author_company     = get_field('li_cpt_t_company', $testimonial_id);
                        $author_image_id    = get_post_thumbnail_id($testimonial_id);
                        ?>
                        <div class="swiper-slide">
                            <div class="testimonial-slide-group">
                                <div class="slide-head">
                                    <h2 class="heading-2 card-title mb-0"><?php echo esc_html($title); ?></h2>
                                    <div class="gl-s44"></div>
                                </div>

                                <div class="slide-inner">
                                    <div class="col-left">
                                        <?php echo !empty($wysiwyg) ? '<div class="card-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
                                        <?php echo (!empty($wysiwyg) && !empty($author_name)) ? '<div class="gl-s30"></div>' : ''; ?>
                                        <?php echo !empty($author_name) ? '<div class="author-name ui-eyebrow-18-16-regular">' . esc_html($author_name) . '</div>' : '' ?>
                                        <?php echo !empty($author_company) ? '<div class="author-description body-18-16-regular">' . esc_html($author_company) . '</div>' : '' ?>
                                        <div class="gl-s64"></div>
                                    </div>
                                    <?php if (!empty($author_image_id)) : ?>
                                        <div class="col-right">
                                            <div class="testimonial-author-image">
                                                <div class="optional-title ui-14-13-bold">Placeholder Image</div>
                                                <?php echo wp_get_attachment_image($author_image_id, 'thumb_500'); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php if ($total_testimonials > 1) : ?>
                <div class="slider-btn">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            <?php endif; ?>
            <div class="gl-s80"></div>
        </div>
<?php
    endif;
    wp_reset_postdata();
endif;
?>