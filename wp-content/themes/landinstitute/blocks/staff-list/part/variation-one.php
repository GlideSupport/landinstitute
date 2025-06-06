
<?php if(!empty($li_sl_headline_check)): ?>
    <div class="staff-list-block <?php echo esc_attr($border_options); ?>">
        <?php echo !empty($li_sl_headline_check) ? BaseTheme::headline($li_sl_headline, 'heading-2 block-title mb-0') . '<div class="gl-s52"></div>' : ''; ?>
        <?php
        if ($li_sl_choose_variation === 'variation-one' && !empty($li_sl_selector)) :
            $args = [
                'post_type'      => 'team',
                'post__in'       => $li_sl_selector,
                'orderby'        => 'post__in',
                'posts_per_page' => -1,
            ];
            $team_query = new WP_Query($args);
            if ($team_query->have_posts()) : ?>
                <div class="staff-list-row">
                    <?php while ($team_query->have_posts()) : $team_query->the_post(); ?>
                        <?php
                            $team_id      = get_the_ID();
                            $name         = get_the_title($team_id);
                            $designation  = get_field('li_cpt_team_designation', $team_id);
                            $company  = get_field('li_cpt_team_company', $team_id);
                            $wysiwyg      = get_field('li_cpt_team_wysiwyg', $team_id);
                            $permalink    = get_permalink($team_id);
                        ?>
                        <div class="staff-list-col">
                            <div class="row-flex">
                            <?php echo !empty($team_id) ? '<div class="cl-left"><div class="team-img">' . wp_get_attachment_image(get_post_thumbnail_id($team_id), 'thumb_300') . '</div></div>' : ''; ?>
                                <div class="cl-right">
                                <?php echo !empty($name) ? '<h5 class="heading-5 block-title mb-0">' . esc_html($name) . '</h5><div class="gl-s2"></div>' : ''; ?>
                                <?php $company = get_field('li_cpt_team_company', $team_id); echo !empty($designation) || !empty($company) ? '<div class="ui-eyebrow-16-15-regular team-sub">' . esc_html($designation) . (!empty($company) ? ', ' . esc_html($company) : '') . '</div><div class="gl-s20"></div>': ''; ?>
                                <?php echo !empty($wysiwyg) ? '<div class="team-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div><div class="gl-s6"></div>' : ''; ?>
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
