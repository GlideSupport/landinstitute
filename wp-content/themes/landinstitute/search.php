<?php

/**
 * The template for displaying search results pages.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

set_query_var('search_query', $wp_query);
set_query_var('paged_var', $paged);

$posttype = isset($_GET['search-type']) ? sanitize_text_field($_GET['search-type']) : '';
$learntype = isset($_GET['learn-type']) ? sanitize_text_field($_GET['learn-type']) : '';

?>

<div id="page-section" class="page-section search-main">
	<!-- Hero Start -->
	<section id="hero-section" class="hero-section hero-section-default hero-alongside-search">
		<div class="bg-pattern">
			<img src="<?php echo site_url(); ?>/wp-content/uploads/2025/05/TLI-Pattern-Repair-SkyBlue-sticky.jpg" alt="" />
		</div>
		<div class="hero-default">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left bg-lime-green">
						<div class="hero-content">
							<div class="ui-eyebrow-18-16-regular sub-head"><?php esc_html_e('Search Results', 'land_institute'); ?></div>
							<div class="gl-s12"></div>
							<h1 id="search-heading" class="heading-1 mb-0 block-title">
								<?php
								printf(
									esc_html__('Results for "%s"', 'land_institute'),
									esc_html(get_search_query())
								);
								?>
							</h1>
							<div class="gl-s96"></div>
						</div>
					</div>
					<div class="col-right">
						<div class="bg-pattern pattern-top-align">
							<img src="<?php echo site_url(); ?>/wp-content/uploads/2025/05/TLI-Pattern-Repair-SkyBlue-sticky.jpg" alt="" />
						</div>
					</div>
				</div>

				<div class="search-clicks">
					<div class="search-everything tab-dropdown tab-dropdown-filter">
						<button id="search-type-btn" aria-expanded="false" aria-haspopup="true" aria-controls="search-type" class="dropdown-toggle jump-arrow btn-butter-yellow"><?php esc_html_e('Search everything', 'land_institute'); ?>
							<div class="arrow-icon"></div>
						</button>
					</div>

					<div class="search-row">
						<div class="not-found-search">
							<form role="search" id="searchForm" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
								<label>
									<span class="screen-reader-text"><?php esc_html_e('Search for:', 'land_institute'); ?></span>
									<input type="search" id="search-field" class="search-field" placeholder="<?php esc_attr_e('Search …', 'land_institute'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
									<input type="hidden" name="search-type" value="<?php echo $posttype ?>" class="search-type-field">
									<input type="hidden" name="learn-type" value="<?php echo $learntype ?>" class="learn-type-field">
								</label>
								<button type="submit" class="site-btn sm-btn btn-lemon-yellow">
									<?php esc_html_e('Search', 'land_institute'); ?>
									<div class="arrow-icon"></div>
								</button>

							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<?php
	$search_dropdown_options = get_field('search_dropdown_options', 'option');
	?>

	<div class="search-list-filter">
		<ul id="search-type" class="dropdown-menu" role="menu" aria-labelledby="search-type">
			<li class="active" style="animation-delay: 0s;">
				<a href="javascript:void(0)" data-post="all">Everything</a>
				<div class="arrow-icon"></div>
			</li>

			<?php
			$delay = 0.1;

			foreach ($search_dropdown_options as $row):
				$select_type       = $row['select_type'];
				$select_post_type  = $row['select_post_type'];
				$select_learn_type = $row['select_learn_type'];

				if ($select_type === 'post_type') {
					$post_type = $select_post_type;
					$label     = get_post_type_label($post_type);
					$extraAttr = 'data-post="' . esc_attr($post_type) . '"';
				} else {
					$post_type = 'post';
					$label     = $select_learn_type->name;
					$extraAttr = 'data-post="' . esc_attr($post_type) . '" data-taxonomy="' . esc_attr($select_learn_type->slug) . '"';
				}
			?>
				<li style="animation-delay: <?= esc_attr($delay) ?>s;">
					<a href="javascript:void(0)" <?= $extraAttr ?>>
						<?= esc_html($label) ?>
					</a>
				</li>
			<?php
				$delay += 0.1;
			endforeach;
			?>
		</ul>
	</div>

	<!-- Hero End -->

	<section class="container-960 bg-base-cream">
		<div class="wrapper">
			<div class="event-teaser-list-block search-events has-border-bottom">
				<div class="event-teaser-list-row">
					<div class="category-filter">
						<ul class="tabs" id="search-orderby-tabs">
							<li class="tab-link current" data-orderby="date" data-tab="tab-1">Newest First</li>
							<li class="tab-link" data-orderby="title" data-tab="tab-2">Alphabetical</li>
						</ul>
					</div>

					<div class="append-search-result">
						<?php get_template_part('partials/content', 'search-list'); ?>
					</div>

					<div class="fillter-bottom">
						<div class="append-search-result-pagination">
							<?php get_template_part('partials/content', 'search-pagination'); ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

	<div class="ts-100"></div>

	<section class="container-1280">
		<div class="wrapper">
			<div class="bg-pattern-fixed">
				<img src="<?php echo site_url(); ?>/wp-content/uploads/2025/05/TLI-Pattern-Repair-SkyBlue-sticky.jpg" alt="" />
			</div>
		</div>
	</section>
</div>

<?php get_footer(); ?>