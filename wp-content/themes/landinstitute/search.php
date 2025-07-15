<?php
/**
 * The template for displaying search results pages.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

get_header();

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

set_query_var( 'search_query', $wp_query );
set_query_var( 'paged_var', $paged );

?>

<div id="page-section" class="page-section search-main" >
	<!-- Hero Start -->
	<section id="hero-section" class="hero-section hero-section-default hero-alongside-search">
		<div class="bg-pattern">
			<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/TLI-Pattern-Repair-SkyBlue-sticky.jpg" alt="" />
		</div>
		<div class="hero-default">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left bg-lime-green">
						<div class="hero-content">
							<div class="ui-eyebrow-18-16-regular sub-head"><?php esc_html_e( 'Search Results', 'land_institute' ); ?></div>
							<div class="gl-s12"></div>
							<h1 id="search-heading" class="heading-1 mb-0 block-title">
								<?php
								printf(
									esc_html__( 'Results for "%s"', 'land_institute' ),
									esc_html( get_search_query() )
								);
								?>
							</h1>
							<div class="gl-s96"></div>
						</div>
					</div>
					<div class="col-right">
						<div class="bg-pattern pattern-top-align">
							<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/TLI-Pattern-Repair-SkyBlue-sticky.jpg" alt="" />
						</div>
					</div>
				</div>

				<div class="search-clicks">
					<div class="search-everything tab-dropdown tab-dropdown-filter">
						<button  id="search-type" aria-expanded="false" aria-haspopup="true" aria-controls="search-type" class="dropdown-toggle jump-arrow btn-butter-yellow"><?php esc_html_e( 'Search everything', 'land_institute' ); ?>
							<div class="arrow-icon"></div>
						</button>
					</div>
						
					<div class="search-row">
						<div class="not-found-search">
							<form role="search" id="searchForm" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<label>
									<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'land_institute' ); ?></span>
									<input type="search" id="search-field" class="search-field" placeholder="<?php esc_attr_e( 'Search …', 'land_institute' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
								</label>
								<button type="submit" class="site-btn sm-btn btn-lemon-yellow">
									<?php esc_html_e( 'Search', 'land_institute' ); ?>
								</button>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
<div class="search-list-filter" >
			<ul id="search-type" class="dropdown-menu" role="menu" aria-labelledby="search-type" >
				<li class="active" style="animation-delay: 0s;"><a href="javascript:void(0)" data-post="all" data-taxonomy="search-type">All types</a></li>
				<li style="animation-delay: 0.1s;">
					<a href="javascript:void(0)" data-post="page" data-taxonomy="search-type">Page</a>
				</li>
				<li style="animation-delay: 0.2s;">
					<a href="javascript:void(0)" data-post="news" data-taxonomy="search-type">News</a>
				</li>
				<li style="animation-delay: 0.2s;">
					<a href="javascript:void(0)" data-post="post" data-taxonomy="search-type">Learn</a>
				</li>
				<li style="animation-delay: 0.2s;">
					<a href="javascript:void(0)" data-post="event" data-taxonomy="search-type">Event</a>
				</li>
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
						<?php get_template_part( 'partials/content', 'search-list' ); ?>
					</div>

					<div class="fillter-bottom">
						<div class="append-search-result-pagination">
							<?php get_template_part( 'partials/content', 'search-pagination' ); ?>
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
				<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/TLI-Pattern-Repair-SkyBlue-sticky.jpg" alt="" />
			</div>
		</div>
	</section>
</div>

<?php get_footer(); ?>
