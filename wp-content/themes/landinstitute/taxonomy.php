<?php
/**
 * The template for displaying all posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

// Include header.
get_header(); ?>

<main id="main-section" class="main-section">
	<div class="page-section">
		<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu">
			<!-- Hero Start -->
			<div class="bg-pattern">
				<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/tli-pattern-successionpink-large.png" alt="" />
			</div>
			<div class="hero-default has-border-bottom">
				<div class="wrapper">
					<div class="hero-alongside-block">
						<div class="col-left bg-lime-green">
							<div class="hero-content">
								<h1 class="heading-1 mb-0 block-title"><?php single_cat_title(); ?></h1>
								<div class="gl-s30"></div>
								<div class="hero-content body-20-18-regular">
									<?php echo category_description(); ?>
								</div>
								<div class="gl-s96"></div>
							</div>
						</div>
						<div class="col-right">
							<div class="bg-pattern">
								<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/tli-pattern-successionpink-large.png" alt="" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="container-1280 bg-base-cream">
			<div class="wrapper">
				<div class="resoruce-filter-title full-width-content has-border-bottom">
					<div class="filter-block fixed-category">
						<!-- Dynamic Post Cards Start -->
						<div class="filter-cards-grid">
							<?php if (have_posts()) : ?>
								<?php while (have_posts()) : the_post(); ?>
									<div class="filter-card-item">
										<a href="<?php the_permalink(); ?>" class="filter-card-link">
											<div class="image">
											<?php if (has_post_thumbnail()) : ?>
												<?php echo wp_get_attachment_image(get_post_thumbnail_id($post_id), 'thumb_500'); ?>
											<?php else : ?>
												<img src="<?php echo esc_url(BASETHEME_DEFAULT_IMAGE); ?>" alt="Default thumbnail" width="500" height="300" />
											<?php endif; ?>
											</div>
											<div class="filter-card-content">
												<div class="gl-s52"></div>
												<div class="eyebrow ui-eyebrow-16-15-regular">
													<?php $cats = get_the_category(); echo $cats ? esc_html($cats[0]->name) : 'Uncategorized'; ?>
												</div>
												<div class="gl-s6"></div>
												<div class="card-title heading-7"><?php echo get_the_title(); ?></div>
												<div class="gl-s12"></div>
												<div class="description ui-18-16-regular"><?php echo wp_trim_words(get_the_excerpt(), 35); ?></div>
												<div class="gl-s20"></div>
												<div class="read-more-link">
													<div class="border-text-btn">Read more</div>
												</div>
												<div class="gl-s80"></div>
											</div>
										</a>
									</div>
								<?php endwhile; ?>
							<?php else : ?>
								<p>No posts found in this category.</p>
							<?php endif; ?>
						</div>

						<!-- Pagination -->
						<div class="fillter-bottom">
							<?php BaseTheme::pagination(); ?>
						</div>

					</div>
				</div>
			</div>
		</section>
		<section class="container-1280 bg-base-cream">
				<div class="wrapper">
					<div class="download-list sticky-lft-block variation-2 has-border-bottom">
						<div class="row-flex">
							<div class="col-left sticky-img">
								<div class="sticky-image-stick">
									<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/tli-pattern-mollisol-orange.png"
										width="" height="" alt="" />
								</div>
							</div>
							<div class="cl-right">
								<div class="gl-s156"></div>
								<h2 class="heading-2 block-title mb-0">More For</h2>
								<div class="gl-s12"></div>
								<div class="card-list">
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Donors
											</div>
											<div class="card-content body-18-16-regular">
												Commodo magna cursus et vulputate dolor sit sapien dignissim.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Researchers & Scientists
											</div>
											<div class="card-content body-18-16-regular">
												Gravida urna diam odio leo mattis volutpat massa.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Farmers
											</div>
											<div class="card-content body-18-16-regular">
												In sit placerat orci mauris magnis amet pellentesque sagittis blandit ut
												orci risus.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Producers
											</div>
											<div class="card-content body-18-16-regular">
												Feugiat nulla erat phasellus suspendisse aliquet sed vitae.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Advocates
											</div>
											<div class="card-content body-18-16-regular">
												Eros malesuada pretium proin interdum dis adipiscing ullamcorper.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Educators
											</div>
											<div class="card-content body-18-16-regular">
												Gravida pulvinar ut in amet. Viverra aliquam leo nec risus egestas.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Students
											</div>
											<div class="card-content body-18-16-regular">
												Mattis bibendum tortor viverra sit.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
									<a href="#" class="card-item link-with-title with-arrow">
										<div class="card-item-left">
											<div class="card-title ui-24-21-bold">
												Consumers
											</div>
											<div class="card-content body-18-16-regular">
												Faucibus lobortis nulla amet a et viverra.
											</div>
										</div>
										<div class="card-item-right">
											<div class="dot-btn">
												<img src="../assets/src/images/right-circle-arrow.svg" />
											</div>
										</div>
									</a>
								</div>
								<div class="gl-s156"></div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="container-720 bg-butter-yellow">
				<div class="gl-s156"></div>
				<div class="wrapper">
					<div class="newsletter-block">
						<div class="block-row">
							<div class="ui-eyebrow-18-16-regular sub-head">Subscribe for Newsletter</div>
							<div class="gl-s12"></div>
							<h4 class="heading-2 mb-0 block-title">
								<p>Stay Informed on Our Progress
								</p>
							</h4>
							<div class="gl-s44"></div>
							<div class="newsletter-form">
								<div class="gf_browser_chrome gform_wrapper gform-theme gform-theme--foundation gform-theme--framework gform-theme--orbital"
									data-form-theme="orbital" data-form-index="0" id="gform_wrapper_1">
									<form method="post" enctype="multipart/form-data" target="gform_ajax_frame_1"
										id="gform_1" action="/test-form/" data-formid="1" novalidate="">
										<div class="gform-body gform_body">
											<div id="gform_fields_1"
												class="gform_fields top_label form_sublabel_below description_below validation_below">
												<div id="field_1_8"
													class="gfield gfield--type-text gfield--input-type-text gfield--width-full gfield_contains_required field_sublabel_below gfield--no-description field_description_below field_validation_below gfield_visibility_visible"
													data-js-reload="field_1_8">
													<label class="gfield_label gform-field-label" for="input_1_8">First
														Name<span class="gfield_required"><span
																class="gfield_required gfield_required_text">(Required)</span></span></label>
													<div class="ginput_container ginput_container_text">
														<input name="input_8" id="input_1_8" type="text" value=""
															class="large" placeholder="James" aria-required="true"
															aria-invalid="false">
													</div>
												</div>
												<div id="field_1_8"
													class="gfield  gfield--type-text gfield--input-type-text gfield--width-full gfield_contains_required field_sublabel_below gfield--no-description field_description_below field_validation_below gfield_visibility_visible"
													data-js-reload="field_1_8">
													<label class="gfield_label gform-field-label" for="input_1_8">Last
														Name<span class="gfield_required"><span
																class="gfield_required gfield_required_text">(Required)</span></span></label>
													<div class="ginput_container ginput_container_text">
														<input name="input_8" id="input_1_8" type="text" value=""
															class="large" placeholder="Add Company Name"
															aria-required="true" aria-invalid="false">
													</div>
												</div>
												<div id="field_1_10"
													class="gfield  gfield--type-email gfield--input-type-email gfield--width-full gfield_contains_required field_sublabel_below gfield--no-description field_description_below field_validation_below gfield_visibility_visible"
													data-js-reload="field_1_10">
													<label class="gfield_label gform-field-label"
														for="input_1_10">Email<span class="gfield_required"><span
																class="gfield_required gfield_required_text">(Required)</span></span></label>
													<div class="ginput_container ginput_container_email">
														<input name="input_10" id="input_1_10" type="email" value=""
															class="large" placeholder="james.smith@domain.com"
															aria-required="true" aria-invalid="false">
													</div>
												</div>
											</div>
										</div>
										<div class="gform-footer gform_footer top_label">
											<input type="submit" id="gform_submit_button_1" class="gform_button button"
												onclick="gform.submission.handleButtonClick(this)" value="Subscribe">
											<input type="hidden" name="gform_ajax"
												value="form_id=1&amp;title=&amp;description=&amp;tabindex=0&amp;theme=orbital">
											<input type="hidden" class="gform_hidden" name="gform_submission_method"
												data-js="gform_submission_method_1" value="iframe">
											<input type="hidden" class="gform_hidden" name="is_submit_1" value="1">
											<input type="hidden" class="gform_hidden" name="gform_submit" value="1">

											<input type="hidden" class="gform_hidden" name="gform_unique_id" value="">
											<input type="hidden" class="gform_hidden" name="state_1"
												value="WyJ7XCIzXCI6W1wiNjBkZjJjZjExODU5NmVkZjNjZDFhMDU0NTNkZmQwMGZcIixcIjE4ZTVjYjU2NDEzM2JhZGRmNmQwZDFmODA1Mjc1MDg5XCIsXCIzNWU4N2U4ZTJlY2EzNmZlNTU2M2QwM2Y2NDBhYTM3ZFwiLFwiZDY5ZjhhYzZlY2MyZjBkMzg3OGZkMjI2NjMzM2ExMGNcIixcIjc3ZDAyMGU0ZTUxZGRhYjVlNjNiOWRiNDNhMmNjNzNmXCIsXCI5MDdlZDU0ZmEwODc0MTllMjQ4OWI4MDg1MGE1NmUwYlwiLFwiNjQzMjc2OTM1YWY1ZjBhNDI0ZjVhZWIwM2NmOTI5M2ZcIixcImIwNzFhY2U3ZmYxYTRjZDJkY2Y1ZTJiODU2ZTA5YzVhXCIsXCI1OGM4N2UxMjU2YjUwN2Q2MDM3MTc3MjFjNGU5MGM2MVwiXSxcIjRcIjpbXCI5MDdlZDU0ZmEwODc0MTllMjQ4OWI4MDg1MGE1NmUwYlwiLFwiN2ViNGRlZTE3M2UyZTBhM2Q0YTZiNjRmNmQ2Mzk3YzNcIl19IiwiYjYyOWZlYzZiMDgxMTYxYmQzNzM5MjUwZjQwNjg5N2IiXQ==">
											<input type="hidden" autocomplete="off" class="gform_hidden"
												name="gform_target_page_number_1" id="gform_target_page_number_1"
												value="0">
											<input type="hidden" autocomplete="off" class="gform_hidden"
												name="gform_source_page_number_1" id="gform_source_page_number_1"
												value="1">
											<input type="hidden" name="gform_field_values" value="">
										</div>
									</form>
								</div>
							</div>
							<div class="gl-s80"></div>
						</div>
					</div>
				</div>
				<div class="gl-s128"></div>
			</section>
	</div>
</main>

<?php get_footer(); ?>
