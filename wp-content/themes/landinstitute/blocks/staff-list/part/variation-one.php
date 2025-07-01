<div class="staff-list-block">
    <?php
    if (!empty($li_sl_headline)) {
        echo BaseTheme::headline($li_sl_headline, 'heading-2 block-title mb-0');
        echo '<div class="gl-s52"></div>';
    }

    if ($li_sl_choose_variation === 'variation-one' && !empty($li_sl_staff_selector)) :

        $staff_query = new WP_Query([
            'post_type'      => 'staff',
            'post__in'       => $li_sl_staff_selector,
            'orderby'        => 'post__in',
            'posts_per_page' => -1,
        ]);

        if ($staff_query->have_posts()) : ?>
            <div class="staff-list-row">
                <?php while ($staff_query->have_posts()) : $staff_query->the_post();
                    $post_id   = get_the_ID();
                    $title     = get_the_title($post_id);
                    $position  = get_field('staff_designation', $post_id);
                    $content   = get_the_excerpt($post_id);
                    $image     = get_post_thumbnail_id($post_id) ? wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumb_400') : '';
                    $permalink = get_permalink($post_id);
                ?>
                    <div class="staff-list-col">
                        <div class="row-flex">
                            <?php if ($title && $image) : ?>
                                <div class="cl-left">
                                    <div class="team-img"><?= $image; ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="cl-right">
                                <?php if ($title) : ?>
                                    <h5 class="heading-5 block-title mb-0"><?= esc_html($title); ?></h5>
                                    <div class="gl-s2"></div>
                                <?php endif; ?>

                                <?php if ($position) : ?>
                                    <div class="ui-eyebrow-16-15-regular team-sub"><?= esc_html($position); ?></div>
                                    <div class="gl-s20"></div>
                                <?php endif; ?>

                                <?php if ($content) : ?>
                                    <div class="team-content body-20-18-regular"><?= wp_kses_post($content); ?></div>
                                    <div class="gl-s6"></div>
                                <?php endif; ?>

                                <?php if ($permalink) : ?>
                                    <div class="team-btn">
                                        <a href="<?= esc_url($permalink); ?>" class="border-text-btn">Read more</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
    <?php endif;
    endif; ?>
</div>