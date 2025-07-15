<?php
/**
 * The template for displaying search results pages.
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

get_header();
?>

<div id="page-section" class="page-section">
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
							<h1 class="heading-1 mb-0 block-title">
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
					<div class="search-everything">
						<a href="#" class="jump-arrow btn-butter-yellow"><?php esc_html_e( 'Search everything', 'land_institute' ); ?>
							<div class="arrow-icon"></div>
						</a>
					</div>
					<div class="search-row">
						<div class="not-found-search">
							<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<label>
									<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'land_institute' ); ?></span>
									<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search …', 'land_institute' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
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

	<div class="search-list-filter">
		<ul id="search-type" class="dropdown-menu open" role="menu" aria-labelledby="types-view" style="display: block; position: absolute; top: 992.703px; left: 137.5px; width: 593.328px; z-index: 1;">
			<li class="active" style="animation-delay: 0s;"><a href="javascript:void(0)" data-term="all" data-taxonomy="search-type">All types</a></li>
												<li style="animation-delay: 0.1s;">
						<a href="javascript:void(0)" data-term="case-study" data-taxonomy="search-type">
							Case Study						</a>
					</li>
									<li style="animation-delay: 0.2s;">
						<a href="javascript:void(0)" data-term="publications" data-taxonomy="search-type">
							Publications						</a>
					</li>
									</ul>
		<ul id="search-topic" class="dropdown-menu" role="menu" aria-labelledby="topic-view" style="display: none;">
			<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="learn-topic">All Topics</a></li>
												<li>
						<a href="javascript:void(0)" data-term="2014-prairie-festival" data-taxonomy="learn-topic">
							2014 Prairie Festival						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="2015-prairie-festival" data-taxonomy="learn-topic">
							2015 Prairie Festival						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="2016-prairie-festival" data-taxonomy="learn-topic">
							2016 Prairie Festival						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="2017-prairie-festival" data-taxonomy="learn-topic">
							2017 Prairie Festival						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="2018-prairie-festival" data-taxonomy="learn-topic">
							2018 Prairie Festival						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="2019-prairie-festival" data-taxonomy="learn-topic">
							2019 Prairie Festival						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="2022-prairie-festival" data-taxonomy="learn-topic">
							2022 Prairie Festival						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="audio" data-taxonomy="learn-topic">
							Audio						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="barley" data-taxonomy="learn-topic">
							Barley						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="civic-science" data-taxonomy="learn-topic">
							Civic Science						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="crop-protection" data-taxonomy="learn-topic">
							Crop Protection						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="ecology" data-taxonomy="learn-topic">
							Ecology						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="ecosphere-studies" data-taxonomy="learn-topic">
							Ecosphere Studies						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="food-production" data-taxonomy="learn-topic">
							Food Production						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="food-science" data-taxonomy="learn-topic">
							Food Science						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="genetic-analysis" data-taxonomy="learn-topic">
							Genetic Analysis						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="intermediate-wheatgrass" data-taxonomy="learn-topic">
							Intermediate Wheatgrass						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="kernza" data-taxonomy="learn-topic">
							Kernza						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="kernza-conference" data-taxonomy="learn-topic">
							Kernza Conference						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="legumes" data-taxonomy="learn-topic">
							Legumes						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="lunch-and-learn" data-taxonomy="learn-topic">
							Lunch and Learn						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="partner-videos-of-our-work" data-taxonomy="learn-topic">
							Partner Videos of Our Work						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="perennial-crops" data-taxonomy="learn-topic">
							Perennial Crops						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="perennial-cultures" data-taxonomy="learn-topic">
							Perennial Cultures						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="perennial-practice" data-taxonomy="learn-topic">
							Perennial Practice						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="perennial-rice" data-taxonomy="learn-topic">
							Perennial Rice						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="podcast" data-taxonomy="learn-topic">
							Podcast						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="season-of-thanks" data-taxonomy="learn-topic">
							Season of Thanks						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="silphium" data-taxonomy="learn-topic">
							Silphium						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="sorghum" data-taxonomy="learn-topic">
							Sorghum						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="staff-presentations" data-taxonomy="learn-topic">
							Staff Presentations						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="technician-and-resident-takeovers" data-taxonomy="learn-topic">
							Technician and Resident Takeovers						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="video" data-taxonomy="learn-topic">
							Video						</a>
					</li>
									<li>
						<a href="javascript:void(0)" data-term="wheat" data-taxonomy="learn-topic">
							Wheat						</a>
					</li>
									</ul>
		<ul id="learn-crops" class="dropdown-menu" role="menu" aria-labelledby="topic-view" style="display: none;">
			<li class="active"><a href="javascript:void(0)" data-term="all" data-taxonomy="learn-crops">All Crops</a></li>
												<li>
						<a href="javascript:void(0)" data-term="learn-crop" data-taxonomy="learn-crop">
							learn Crop						</a>
					</li>
									</ul>
	</div>

	<!-- Hero End -->

	<section class="container-960 bg-base-cream">
		<div class="wrapper">
			<div class="event-teaser-list-block search-events has-border-bottom">
				<div class="event-teaser-list-row">
					<div class="category-filter">
						<ul class="tabs">
							<li class="tab-link current" data-tab="tab-1">Newest First</li>
							<li class="tab-link" data-tab="tab-2">Alphabetical</li>
						</ul>
					</div>

					<div class="append-search-result">
						<?php get_template_part( 'partials/content', 'search-list' ); ?>
					</div>

					<div class="fillter-bottom">
						<div class="append-search-result">
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
