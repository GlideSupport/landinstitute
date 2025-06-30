
<?php if(!empty($li_sl_headline_check)): ?>
    <div class="staff-list-block">
        <?php echo !empty($li_sl_headline_check) ? BaseTheme::headline($li_sl_headline, 'heading-2 block-title mb-0') . '<div class="gl-s52"></div>' : ''; ?>
        <?php
        if ($li_sl_choose_variation === 'variation-one' && !empty($li_sl_staff_selector)) :
            $args = [
                'post_type' => 'staff',
                'post__in'       => $li_sl_staff_selector,
                'orderby'        => 'post__in',
                'posts_per_page' => -1,
            ];
            $staff_query = new WP_Query($args);
            if ($staff_query->have_posts()) : ?>
                <div class="staff-list-row">
                    <?php while ($staff_query->have_posts()) : $staff_query->the_post(); ?>
                        <?php
                            $title = get_the_title();
                            $position = get_field('staff_designation', get_the_ID());
                            $content =  get_field('staff_bio_description', get_the_ID());
                            $company = get_field('staff_company', get_the_ID());
                            $permalink   = get_permalink(get_the_ID());
                        ?>
                        <div class="staff-list-col">
                            <div class="row-flex">
                            <?php echo !empty($title) ? '<div class="cl-left"><div class="team-img">' . wp_get_attachment_image(get_post_thumbnail_id(get_the_ID(), 'thumb_400')) . '</div></div>' : ''; ?>
                                <div class="cl-right">
                                <?php echo !empty($title) ? '<h5 class="heading-5 block-title mb-0">' . esc_html($title) . '</h5><div class="gl-s2"></div>' : ''; ?>
                                <?php echo !empty($position) || !empty($company) ? '<div class="ui-eyebrow-16-15-regular team-sub">' . esc_html($position) . (!empty($company) ? ', ' . esc_html($company) : '') . '</div><div class="gl-s20"></div>': ''; ?>
                                <?php echo !empty($content)?'<div class="team-content body-20-18-regular">' . html_entity_decode($content) . '</div><div class="gl-s6"></div>' : ''; ?>
                                <?php echo !empty($permalink) ? '<div class="team-btn"><a href="' . esc_url($permalink) . '" class="border-text-btn">Read more</a></div>' : ''; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif;
            wp_reset_postdata();
        endif; ?>
    </div>
<?php endif; ?>