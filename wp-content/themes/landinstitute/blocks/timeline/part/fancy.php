<?php if (!empty($li_t_repeater) || !empty($li_t_kicker)) : ?>
<div class="timeline-block <?php echo esc_attr($border_options); ?>">
    <?php echo !empty($li_t_kicker) ? '<div class="ui-20-18-bold-uc kicker-title mb-0">' . esc_html($li_t_kicker) . '</div><div class="gl-s64"></div>' : ''; ?>
    <?php if (!empty($li_t_repeater)) : ?>
    <div class="timeline-slides-block timeline-block-fancy">
        <div class="swiper-container timeline-slider-fancy cursor-drag-icon">
            <div class="swiper-wrapper">
                <?php foreach ($li_t_repeater as $item) :
							$year = $item['li_t_year'] ?? '';
							$title = $item['li_t_title'] ?? '';
							$content = $item['li_t_wysiwyg'] ?? '';
							$image = $item['li_t_image'] ?? '';
							if(!empty($year) || !empty($title) || !empty($content) || !empty($image)): ?>
                <div class="swiper-slide">
                    <div class="border-card fancy-border-card">
                        <div class="border-card-click">
                            <?php echo !empty($year) ? '<div class="gl-s52"></div><div class="ui-20-18-bold card-sub-head">' . esc_html($year) . '</div><div class="gl-s4"></div>' : ''; ?>
                            <?php echo !empty($title) ? '<h4 class="heading-4 mb-0 block-title">' . esc_html($title) . '</h4><div class="gl-s20"></div>' : ''; ?>
                            <?php echo !empty($content) ? '<div class="body-18-16-regular block-content">' . html_entity_decode($content) . '</div><div class="gl-s44"></div>' : ''; ?>
                            <?php echo !empty($image) ? '<div class="block-image">' . wp_get_attachment_image($image, 'thumb_1000') . '</div>' : ''; ?>
                            <div class="gl-s128"></div>
                        </div>
                    </div>
                </div>
                <?php endif; endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
</div>
<?php endif; ?>