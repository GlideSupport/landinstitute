<?php

$requestdbyajax = get_query_var('requestdbyajax');

if ($news->have_posts()) :
while ($news->have_posts()) : $news->the_post();
    $title         = html_entity_decode(get_the_title());
    $date          = get_the_date('M j, Y');
    $permalink     = get_the_permalink();
    $short_Desc    = apply_filters('the_content', get_the_content());
    $short_content = wp_trim_words($short_Desc, 25, '...');
    $topics        = get_the_terms(get_the_ID(), 'news-type');
    $topics_name   = (!empty($topics) && !is_wp_error($topics)) ? $topics[0]->name : '';
    ?>
    <div class="filter-content-card-item">
        <a href="<?php echo esc_url($permalink); ?>" class="filter-content-card-link">
            <div class="filter-card-content">
                <div class="gl-s52"></div>
                <div class="top-sub-list d-flex flex-wrap">
                    <div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html($date); ?></div>
                    <?php if ($topics_name): ?>
                        <div class="ui-eyebrow-16-15-regular">•</div>
                    <?php endif; ?>
                    <div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html($topics_name); ?></div>
                </div>
                <div class="gl-s8"></div>
                <div class="card-title heading-7"><?php echo $title; ?></div>
                <?php if ($short_content): ?>
                    <div class="gl-s16"></div>
                    <div class="description ui-18-16-regular"><?php echo html_entity_decode($short_content); ?></div>
                <?php endif; ?>
                <div class="gl-s20"></div>
                <div class="read-more-link">
                    <div class="border-text-btn">Read more</div>
                </div>
                <div class="gl-s80"></div>
            </div>
        </a>
    </div>
<?php endwhile;
else : 
if($requestdbyajax){
?>
<div class="not-found-block">
	<div class="not-found">No News found.</div>
</div>
<?php } endif;
wp_reset_postdata();
