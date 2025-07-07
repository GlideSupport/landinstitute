<?php

/**
 * Template Name: Learn
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

$li_learn_temp_headline_text = $bst_fields['li_learn_temp_headline_text'] ?? null;
$li_learn_headline_check  = BaseTheme::headline_check($li_learn_temp_headline_text);
$li_learn_temp_bg_image = $bst_fields['li_learn_temp_bg_image'] ?? null;

?>

<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu">
	<?php echo !empty($li_learn_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_learn_temp_bg_image, 'thumb_900') . '</div>' : ''; ?>
	<div class="hero-default has-border-bottom">
		<div class="wrapper">
			<div class="hero-alongside-block">
				<div class="col-left bg-lime-green">
					<div class="hero-content">
					<?php echo !empty($li_learn_headline_check) ? BaseTheme::headline($li_learn_temp_headline_text, 'heading-1 mb-0 block-title') : ''; ?>
					<div class="gl-s96"></div>
					</div>
				</div>
				<div class="col-right">
					<?php echo !empty($li_learn_temp_bg_image) ? '<div class="bg-pattern">' . wp_get_attachment_image($li_learn_temp_bg_image, 'thumb_1600') . '</div>' : ''; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="container-1280 bg-base-cream">
	<div class="gl-s128"></div>
	<div class="wrapper">
		<div class="resoruce-filter-title full-width-content has-border-bottom">
			<h2 class="heading-2 mb-0 block-title">Resources</h2>
			<div class="gl-s52"></div>
			<div class="filter-block">
				<div class="filter">
					<div class="filter-title ui-18-16-bold">Filter:</div>
					<div class="filter-mobile-dropdown icon-add ui-18-16-bold">Show Filter</div>
					<div class="filter-dropdown-row">
						<div class="tab-dropdown">
							<button class="dropdown-toggle" id="category-view" aria-expanded="false"
								aria-haspopup="true" aria-controls="category-view">Post type: All types<div
									class="arrow-icon"></div>
							</button>
						</div>
						<div class="tab-dropdown">
							<button class="dropdown-toggle" id="category-view" aria-expanded="false"
								aria-haspopup="true" aria-controls="category-view">Topic: All topics<div
									class="arrow-icon"></div>
							</button>
						</div>
						<div class="tab-dropdown">
							<button class="dropdown-toggle" id="category-view" aria-expanded="false"
								aria-haspopup="true" aria-controls="category-view">Crop: All crops<div
									class="arrow-icon"></div>
							</button>
						</div>
					</div>
				</div>
				<div class="filter-cards-grid">
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-one.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Publication</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Fire Frequency Driven Increases in Burn
									Heterogeneity
									Promote Microbial Beta Diversity: A Test of the
									Pyrodiversity-Biodiversity Hypothesis</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Researchers conducted a study at
									the
									Perennial
									Agriculture Project (PAP) Field Station (a joint venture between The
									Lan…
								</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-two.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Story</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Intercropping Alters Phytochemicals
									Associated
									With
									Insect Herbivory</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Researchers conducted a study at
									the
									Perennial
									Agriculture Project (PAP) Field Station (a joint venture between The
									Lan…
								</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-3.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Case Study</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">A study of the vernalisation requirements
									of
									mountain
									rye (Secale strictum syn. S. montanum) may help explain low grain
									yields of perennial cereals compared to wheat</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Researchers conducted a study at
									the
									Perennial
									Agriculture Project (PAP) Field Station (a joint venture between The
									Lan…
								</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-4.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Podcast</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">The Scoop on Kernza®, a Multi-functional
									Perennial
									Grain Crop</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Hana Fancher, Market Stewardship
									Specialist at
									The Land Institute, along with Kernza research collaborator Nicole
									Tautges from the Michael Fields Agricultural Institute, spoke on the
									Come
									Rain
									or
									Shine podcast about the multiple
									environmental benefits of the perennial grain and the future direction
									of
									the
									Kernza
									market.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-5.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Staff Presentation</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Introducing James Norman, Senior Research
									Associate at
									the Land Institute</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Aliquet placerat a convallis nisl
									sit.
									Vulputate ligula urna proin amet viverra tellus sit ac. Duis facilisis
									nisi
									egestas ut et Aliquet placerat a convallis nisl sit. Vulputate ligula
									urna
									proin
									amet viverra tellus sit ac. Duis
									facilisis nisi egestas ut et.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-6.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Publication</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Modeling carbon allocation strategies for
									high-yielding perennial crops</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">The Land Institute’s Lee DeHaan
									and
									Tim
									Crews
									co-authored a paper with colleagues from Loyola University that
									documents
									a model outlining the path to breeding high-yielding perennial crops
									that
									balance
									perenniality, yield, and ecological
									considerations, particularly as it pertains to plant carbon allocation
									and
									considerations for regenerative agriculture.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-7.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Publication</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Choice of companion legume influences lamb
									liveweight
									output and grain yields in a dual use perennial wheat/legume
									intercrop system</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Research partners in Australia
									analyzed
									the
									role of perennial wheat, a crop in development at The Land Institute, as
									a
									dual-purpose grain and forage crop. The authors of this study documented
									the
									dietary
									impact of these crops when grazed
									by lambs and the impacts of intercropping and grazing on perennial wheat
									grain
									yields.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-8.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Publication</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Breeding Potential for Increasing Carbon
									Sequestration
									via Rhizomatous Grain Sorghum</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Building on existing knowledge of
									perennial
									sorghum development through The Land Institute’s breeding program and
									considerations around the benefits of perennial grain agriculture
									through
									research
									from The Land Institute and research
									partners, a research paper from Texas A&M University details the
									breeding
									potential
									of perennial sorghum to enhance
									carbon sequestration while maintaining grain yields.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>

					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-9.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Podcast</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">From Grain to Glass: Why you should be
									drinking
									beer
									brewed with Kernza® grain</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Conservation organization Clean
									Wisconsin
									interviewed research partner Nicole Tautges at Michael Fields
									Agricultural
									Institute in Wisconsin and Joe Walts, brewer at Karben4 Brewing, for
									their
									latest
									podcast episode discussing Kernza®
									perennial grain momentum in the craft brewing space. This episode also
									covers
									the
									progression in the Kernza supply chain
									in Wisconsin and the role of growers, grain processors, and brewers in
									developing
									community excitement around beer as an
									agricultural product.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-10.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Publication</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Flour composition, dough, and bread
									properties
									of
									intermediate wheatgrass (Thinopyrum intermedium) compared to annual
									wheat species</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Researchers in Norway released
									findings
									around
									the properties of Kernza perennial grain in flour, dough, and bread
									compared to annual wheat using intermediate wheatgrass provided by Lee
									DeHaan,
									The
									Land Institute’s Lead Scientist in
									the Kernza Domestication Program. This research looked at traits such as
									dough
									structure, aggregation, protein networks,
									and more.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-11.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Publication</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">Introducing intermediate wheatgrass as a
									perennial
									grain crop into farming systems: insights into the decision-making
									process of pioneer farmers</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Building on existing knowledge of
									perennial
									sorghum development through The Land Institute’s breeding program and
									considerations around the benefits of perennial grain agriculture
									through
									research
									from The Land Institute and research
									partners, a research paper from Texas A&M University details the
									breeding
									potential
									of perennial sorghum to enhance
									carbon sequestration while maintaining grain yields.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
					<div class="filter-card-item">
						<a href="#" class="filter-card-link">
							<div class="image">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/image-12.png"
									alt="">
							</div>
							<div class="filter-card-content">
								<div class="gl-s52"></div>
								<div class="eyebrow ui-eyebrow-16-15-regular">Podcast</div>
								<div class="gl-s6"></div>
								<div class="card-title heading-7">A Perennial Green Revolution to address
									21st-century
									food insecurity and malnutrition</div>
								<div class="gl-s12"></div>
								<div class="description ui-18-16-regular">Researchers at Colorado State
									University
									published a paper discussing the benefits of pursuing a “Perennial Green
									Revolution” where the further development of perennial grains like
									Kernza®,
									silflower (a perennial oilseed crop), and
									other perennial food crops could simultaneously address ecological
									crises,
									food
									security, and nutritional concerns
									globally.</div>
								<div class="gl-s20"></div>
								<div class="read-more-link">
									<div href="#" class="border-text-btn">Read more</div>
								</div>
								<div class="gl-s80"></div>
							</div>
						</a>
					</div>
				</div>
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
							<button id="prevBtn" class="arrow-btn"><img
									src="../assets/src/images/right-circle-arrow.svg" /></button>
							<button id="pageTrigger" class="page-trigger ui-18-16-bold">1/26</button>
							<button id="nextBtn" class="arrow-btn"><img
									src="../assets/src/images/right-circle-arrow.svg" /></button>
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