<?php
if ($li_t_choose_variation === 'single' && !empty($li_t_selector_testimonial_single)) :

    $args = [
        'post_type'      => 'testimonial',
        'post__in'       => $li_t_selector_testimonial_single,
        'orderby'        => 'post__in',
        'posts_per_page' => -1,
    ];

    $testimonial_query = new WP_Query($args);

    if ($testimonial_query->have_posts()) :
        $total_testimonials = $testimonial_query->found_posts; ?>
        <div class="testimonial-single-view-slider <?php echo esc_attr($border_options); ?>">
            <div class="testimonial-slide-group">
                <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                    $testimonial_id     = get_the_ID();
                    $title              = get_the_title();
                    $wysiwyg            = get_field('li_cpt_t_wysiwyg', $testimonial_id);
                    $author_name        = get_field('li_cpt_t_name', $testimonial_id);
                    $author_company     = get_field('li_cpt_t_company', $testimonial_id);
                    $author_image_id    = get_post_thumbnail_id($testimonial_id);
                ?>
                <div class="slide-head">
                    <?php echo !empty($li_t_kicker) ? '<div class="eyebrow-title ui-eyebrow-18-16-regular">' . esc_html($li_t_kicker) . '</div>' : ''; ?>
                    <?php echo (!empty($li_t_kicker) && !empty($title)) ? '<div class="gl-s12"></div>' : ''; ?>
                    <?php echo !empty($title) ? '<h2 class="heading-2 card-title mb-0">' . esc_html($title) . '</h2>' : ''; ?>
                    <?php echo !empty($title) ? '<div class="gl-s44"></div>' : ''; ?>
                </div>

                <div class="slide-inner">
                    <div class="col-left">
                        <?php echo !empty($wysiwyg) ? '<div class="card-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
                        <?php echo (!empty($wysiwyg) && !empty($author_name)) ? '<div class="gl-s30"></div>' : ''; ?>
                        <?php echo !empty($author_name) ? '<div class="author-name ui-eyebrow-18-16-regular">' . esc_html($author_name) . '</div>' : ''; ?>
                        <?php echo !empty($author_company) ? '<div class="author-description body-18-16-regular">' . esc_html($author_company) . '</div>' : ''; ?>
                        <?php echo (!empty($author_name) || !empty($author_company)) ? '<div class="gl-s44"></div>' : ''; ?>
                        <?php echo !empty($li_t_button) ? '<div class="block-btn">' . BaseTheme::button($li_t_button, 'site-btn text-link') . '</div>' : ''; ?>
                        <?php echo !empty($li_t_button) ? '<div class="gl-s80"></div>' : ''; ?>
                    </div>

                    <div class="col-right">
                        <div class="testimonial-author-image">
                            <div class="optional-title ui-14-13-bold">Placeholder Image</div>
                            <?php echo wp_get_attachment_image($author_image_id, 'thumb_500'); ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
<?php
    wp_reset_postdata();
    endif;
endif;
?>
