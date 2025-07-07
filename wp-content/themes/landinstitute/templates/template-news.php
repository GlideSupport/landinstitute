<?php

/**
 * Template Name: News
 * Template Post Type: page
 *
 * This template is for displaying News page.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

// Include header.
get_header();
list( $bst_var_post_id, $bst_fields, $bst_option_fields ) = BaseTheme::defaults();

$li_news_temp_kicker_text = $bst_fields['li_news_temp_kicker_text'] ?? null;
$li_news_temp_headline_text = $bst_fields['li_news_temp_headline_text'] ?? null;
$li_news_headline_check  = BaseTheme::headline_check($li_news_temp_headline_text);
$li_news_temp_bg_image = $bst_fields['li_news_temp_bg_image'] ?? null;
$li_news_temp_logo_list_title = $bst_fields['li_news_temp_logo_list_title'] ?? null;
$li_news_temp_logo_list_repeater = $bst_fields['li_news_temp_logo_list_repeater'] ?? null;

?>

<div id="page-section" class="page-section">
<?php
$terms = get_terms([
	'taxonomy'   => 'news-type',
	'hide_empty' => true,
]);

$topic_terms = get_terms([
	'taxonomy'   => 'news-topic',
	'hide_empty' => true,
]);
?>

<!-- news list -->

<section id="hero-section" class="hero-section hero-section-default hero-alongside-standard">
	<!-- hero start -->
	<?php echo !empty($li_news_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_news_temp_bg_image, 'thumb_900') . '</div>' : ''; ?>
	<div class="hero-default has-border-bottom">
		<div class="wrapper">
			<div class="hero-alongside-block">
				<div class="col-left bg-lime-green">
					<div class="hero-content">
						<?php if($li_news_temp_kicker_text): ?>
							<div class="ui-eyebrow-20-18-regular">
								<?php echo html_entity_decode($li_news_temp_kicker_text); ?>
							</div>
							<div class="gl-s20"></div>
						<?php endif; ?>
							<?php if($li_news_headline_check): ?>
							<?php echo BaseTheme::headline($li_news_temp_headline_text, 'heading-1 mb-0 block-title'); ?>
							<div class="gl-s96"></div>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-right">
					<?php echo !empty($li_news_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_news_temp_bg_image, 'thumb_1600') . '</div>' : ''; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="container-1280 bg-lilac">
	<div class="gl-s36"></div>
	<div class="wrapper">
		<div class="logo-list-block">
			<?php echo (!empty($li_news_temp_logo_list_title)) ? '<div class="ui-20-18-bold-uc eybrow-title">' . esc_html($li_news_temp_logo_list_title) . '</div>' : ''; ?>			
			<div class="gl-s30"></div>
			<div class="logo-list-row">
				<div class="swiper logolist-wrapp">
					<?php if (!empty($li_news_temp_logo_list_repeater)): ?>
						<div class="swiper-wrapper">
							<?php foreach ($li_news_temp_logo_list_repeater as $li_news_temp_logo_list_rep):
								$li_news_temp_logo = $li_news_temp_logo_list_rep['li_news_temp_logo'] ?? '';
								$li_news_temp_title = $li_news_temp_logo_list_rep['li_news_temp_title'] ?? '';
								$li_news_temp_text = $li_news_temp_logo_list_rep['li_news_temp_text'] ?? '';
								$li_news_temp_link = $li_news_temp_logo_list_rep['li_news_temp_link'] ?? null;

								$url = $li_news_temp_link['url'];

								if (!empty($li_news_temp_logo) || !empty($li_news_temp_title) || !empty($li_news_temp_text) || !empty($li_news_temp_link)): ?>
									<div class="swiper-slide">
									<?php echo !empty($li_news_temp_link) ? '<a href="' . esc_url($url) . '" class="logo-list-col">' : '<div class="logo-list-col">'; ?>
									<?php echo !empty($li_news_temp_logo) ? '<div class="brand-logo-img">' . wp_get_attachment_image($li_news_temp_logo, 'thumb_200') . '</div><div class="gl-s24"></div>' : ''; ?>
										<div class="card-list">
											<div class="card-item link-with-title with-arrow">
												<?php if (!empty($li_news_temp_title) || !empty($li_news_temp_text)): ?>
													<div class="card-item-left">
														<?php echo (!empty($li_news_temp_title)) ? '<div class="card-title ui-18-16-bold">' . esc_html($li_news_temp_title) . '</div>' : ''; ?>
														<?php echo (!empty($li_news_temp_title) && !empty($li_news_temp_text)) ? '<div class="gl-s2"></div>' : ''; ?>
														<?php echo (!empty($li_news_temp_text)) ? '<div class="card-content body-18-16-regular">' . esc_html($li_news_temp_text) . '</div>' : ''; ?>
													</div>
												<?php endif; ?>
												<div class="card-item-right">
													<div class="dot-btn">
														<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" alt="View PDF">
													</div>
												</div>
											</div>
										</div>
									<?php echo !empty($li_news_temp_link) ? '</a>' : '</div>'; ?>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="gl-s64"></div>
</section>
<section class="container-1280 bg-base-cream">
	<div class="wrapper">
		<div class="news-list-filter-title full-width-content has-border-bottom">
			<div class="filter-block">
				<div class="filter">
					<div class="filter-title ui-18-16-bold">Filter:</div>
					<div class="filter-mobile-dropdown icon-add ui-18-16-bold">Show Filter</div>
					<div class="filter-dropdown-row">
						<div class="tab-dropdown tab-dropdown-filter">
							<button class="dropdown-toggle" id="types-view" aria-expanded="false"
								aria-haspopup="true" aria-controls="news-type">Post type: All types<div class="arrow-icon"></div>
							</button>

							<ul id="news-type" class="dropdown-menu" role="menu" aria-labelledby="types-view">
								<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="news-type">All types</a></li>
								<?php if (!empty($terms) && !is_wp_error($terms)) : ?>
									<?php foreach ($terms as $term) : ?>
										<li>
											<a href="javascript:void(0)" data-term="<?php echo esc_attr($term->slug); ?>" data-taxonomy="news-type">
												<?php echo esc_html($term->name); ?>
											</a>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
						<div class="tab-dropdown tab-dropdown-filter">
							<button class="dropdown-toggle" id="topic-view" aria-expanded="false"
								aria-haspopup="true" aria-controls="news-topic">Topic: All topics<div class="arrow-icon"></div>
							</button>

							<ul id="news-topic" class="dropdown-menu" role="menu" aria-labelledby="topic-view">
								<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="news-topic">All Topics</a></li>
								<?php if (!empty($topic_terms) && !is_wp_error($topic_terms)) : ?>
									<?php foreach ($topic_terms as $topic_term) : ?>
										<li>
											<a href="javascript:void(0)" data-term="<?php echo esc_attr($topic_term->slug); ?>" data-taxonomy="news-topic">
												<?php echo esc_html($topic_term->name); ?>
											</a>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<?php
				$args = [
					'post_type'      => 'news',
					'posts_per_page' => 9,
					'order'          => 'DESC',
					'post_status'    => 'publish',
				];
				$news = new WP_Query($args);

				if ($news->have_posts()) : ?>
				<div class="filter-content-cards-grid">
					<?php while ($news->have_posts()) : $news->the_post(); 
						$title = get_the_title();
						$date = get_the_date( 'M j, Y' );
						$permalink = get_the_permalink();
						$short_Desc = get_the_excerpt();
						$short_content = wp_trim_words($short_Desc, 15, '...');
						$topics = get_the_terms(get_the_ID(), 'news-topic');
						$topics_name = !empty($topics) && !is_wp_error($topics) ? $topics[0]->name : '';
					?>
					<div class="filter-content-card-item">
						<a href="<?php echo esc_html($permalink); ?>" class="filter-content-card-link">
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="top-sub-list d-flex flex-wrap">
									<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html($date); ?></div>
									<?php if($topics_name): ?>
										<div class="ui-eyebrow-16-15-regular">•</div>
									<?php endif; ?>
									<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html($topics_name); ?></div>
								</div>
								<div class="gl-s8"></div>
								<div class="card-title heading-7"><?php echo esc_html($title); ?>
								</div>
								<?php if($short_content): ?>
								<div class="gl-s16"></div>
								<div class="description ui-18-16-regular"><?php echo html_entity_decode($short_content); ?>
								</div>
								<?php endif; ?>
								
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<?php endwhile; ?>

				</div>

				<?php endif; ?>

				<div class="fillter-bottom">
					<div class="pagination-container">
						<div class="desktop-pages">
							<div class="arrow-btn prev">
								<div class="site-btn">Previous</div>
							</div>
							<div class="pagination-list">
								<button class="page-btn active">1</button>
								<button class="page-btn">2</button>
								<button class="page-btn">3</button>
								<span class="dots">...</span>
								<button class="page-btn">12</button>
							</div>
							<div class="arrow-btn next">
								<div class="site-btn">Next</div>
							</div>
						</div>
						<!-- Mobile Pagination -->
						<div class="mobile-pagination">
							<button id="prevBtn" class="arrow-btn"><img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" title="right-circle-arrow" alt="right-circle-arrow" />
							</button>
							<button id="pageTrigger" class="page-trigger ui-18-16-bold">1/26</button>
							<button id="nextBtn" class="arrow-btn"><img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/right-circle-arrow.svg" title="right-circle-arrow" alt="right-circle-arrow" />
							</button>
						</div>

						<!-- Mobile Popup -->
						<div id="paginationPopup" class="pagination-popup">
							<div class="popup-body">
								<div id="popupGrid" class="popup-grid"><button
										class="page-btn active">1</button><button
										class="page-btn">2</button><button
										class="page-btn">3</button><button
										class="page-btn">4</button><button
										class="page-btn">5</button><button
										class="page-btn">6</button><button
										class="page-btn">7</button><button
										class="page-btn">8</button><button
										class="page-btn">9</button><button
										class="page-btn">10</button><button
										class="page-btn">11</button><button class="page-btn">12</button>
								</div>
								<button id="popupPrev" class="arrow-btn"></button>
								<button id="popupNext" class="arrow-btn"></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
		
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			// Include specific template for the content.
			get_template_part( 'partials/content', 'page' );
		}
	} 
	?>
<?php
get_footer(); ?>