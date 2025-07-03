<header id="header-section" class="header-section">
	<?php
	if (is_page_template('templates/template-landing.php')) {
		include get_template_directory() . '/partials/header/landing-header.php';
	} else {
	?>
		<div class="header-wrapper header-inner d-flex">
			<div class="header-logo logo">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="site logo" title="site logo">
					<?php echo wp_get_attachment_image($bst_var_header_logo, 'admin-landscape', false, array('class' => 'site-logo')); ?>
				</a>
			</div>
			<div class="right-header header-navigation">
				<?php include get_template_directory() . '/partials/header/hello-bar.php'; ?>
				<div class="bottom-head">
					<div class="nav-overlay">
						<div class="nav-container">
							<div class="header-nav">
								<?php include get_template_directory() . '/partials/header/header-mega-menu.php'; ?>
								<?php if (!empty($bst_var_tohdr_btn)): ?>
									<div class="header-btns desktop-hide">
										<?php echo BaseTheme::button($bst_var_tohdr_btn, 'site-btn btn-sunflower-yellow sm-btn arrow-heart-symbol'); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="search-drop">
								<!-- Add "active-search" on click of "search-popup" it will open sub menu of search  -->
								<a href="javascript:void(0)" class="search-popup">
									<!-- when hover on menu add "active-hover" class -->
									<img class="search-btn" src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/search-icon.svg" width="29" height="29" alt="search-icon" title="search-icon" />
									</a>
								<div class="mega-dropdown search-mega-dropdown" id="mega-dropdown-product">
									<div class="mega-dropdown-card">
										<div class="col-left">
											<?php if (!empty($landinstitute_to_title)): ?>
												<div class="search-everything">
													<a class="site-btn arrow-btn" href=""><?php echo esc_html($landinstitute_to_title); ?></a>
												</div>
											<?php endif; ?>
											<?php
											if ($landinstitute_to_select_post) :
												$query = new WP_Query([
													'post_type' => 'post',
													'post__in' => $landinstitute_to_select_post,
													'post_status' => 'publish',
												]);

												if ($query->have_posts()) :
													while ($query->have_posts()) : $query->the_post();
														$post_type = get_post_type();
														$eyebrow = ucfirst($post_type); // or use a custom field/taxonomy
														$title = get_the_title();
														$permalink = get_permalink();
											?>
														<!-- TO DO -->
														<div class="image-category-card">
															<a class="image-cat-group" href="<?php echo esc_url($permalink); ?>">
																<div class="category-image">
																	<?php if (has_post_thumbnail()) : ?>
																		<?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'thumb_400'); ?>
																	<?php else : ?>
																		<img src="<?php echo esc_url(BASETHEME_DEFAULT_IMAGE); ?>" alt="Default thumbnail" width="367" height="232" />
																	<?php endif; ?>
																	<div class="tag-label">
																		<span class="tags">Popular Resource</span> <!-- You can customize or make this dynamic -->
																	</div>
																</div>
																<div class="post-content">
																	<div class="gl-s30"></div>
																	<div class="ui-eyebrow-16-15-regular eyebrow-label"><?php echo esc_html($eyebrow); ?></div>
																	<div class="gl-s6"></div>
																	<div class="heading-7 card-title mb-0"><?php echo esc_html($title); ?></div>
																	<div class="gl-s30"></div>
																</div>
															</a>
														</div>
											<?php
													endwhile;
													wp_reset_postdata();
												endif;
											endif;
											?>
										</div>
										<div class="col-right">
											<div class="popup-search">
												<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
													<input type="text" name="s" placeholder="What are you serching for?" autofocus>
													<button class="site-btn btn-lemon-yellow sm-btn" type="submit">Search</button>
												</form>
											</div>
											<div class="search-content">
												<div class="mega-menu-row">
													<div class="mega-col">
														<?php if (!empty($landinstitute_to_common_search_title)): ?>
															<div class="ui-24-21-bold mega-menu-title"><?php echo esc_html($landinstitute_to_common_search_title); ?></div>
															<div class="gl-s16"></div>
														<?php endif; ?>
														<?php if (!empty($landinstitute_to_common_search_text)) : ?>
															<ul class="dot-hover">
																<?php foreach ($landinstitute_to_common_search_text as $li_to_common_search_text) :
																	$text = $li_to_common_search_text['landinstitute_search_text'];
																	if (!empty($text)) : ?>
																		<li> <?php echo BaseTheme::button($text, ''); ?></li>
																<?php endif;
																endforeach; ?>
															</ul>
														<?php endif; ?>
													</div>
												</div>
												<div class="gl-s30"></div>
												<div class="tags-cols">
													<?php if (!empty($landinstitute_to_popular_topics_title)): ?>
														<div class="ui-24-21-bold topics-title"><?php echo esc_html($landinstitute_to_popular_topics_title); ?></div>
														<div class="gl-s20"></div>
													<?php endif; ?>
													<?php if (!empty($landinstitute_to_popular_topics)) : ?>
														<ul>
															<?php foreach ($landinstitute_to_popular_topics as $li_to_popular_topics) :
																$landinstitute_topics = $li_to_popular_topics['landinstitute_topics'];
																if (!empty($landinstitute_topics)) : ?>
																	<li><span class="tags"><?php echo BaseTheme::button($landinstitute_topics, ''); ?></span></li>
															<?php endif;
															endforeach; ?>
														</ul>
													<?php endif; ?>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="menu-btn">
						<span class="top"></span>
						<span class="middle"></span>
						<span class="bottom"></span>
					</div>
					<?php if (!empty($bst_var_tohdr_btn)): ?>
						<div class="header-btns">
							<?php echo BaseTheme::button($bst_var_tohdr_btn, 'site-btn btn-sunflower-yellow sm-btn arrow-heart-symbol'); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="right-top-head top-head-mobile">
				<div class="top-list-menu">
					<div class="top-bar" id="top-bar-ajax" data-cookie-days="<?php echo esc_attr($cookie_days); ?>"
						<?php echo isset($_COOKIE['helloBarClosed']) ? 'style="display: none;"' : ''; ?>>

						<div class="top-bar-text">
							<?php
							if (!empty($bst_var_hb_content)):
								echo wp_kses_post(html_entity_decode($bst_var_hb_content));
							endif;
							?>
						</div>

						<div class="top-bar-cross" role="button" tabindex="0"
							aria-label="<?php esc_attr_e('Close top bar', 'land_institute'); ?>" aria-pressed="false">
							<span>
								<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/src/images/topbar-cross-icon.svg'); ?>" 
								width="16" height="16" 
								alt="<?php esc_attr_e('Top bar', 'land_institute'); ?>" 
								title="topbar-cross-icon">
							</span>
						</div>
					</div>
			</div>
		</div>
		</div>
		</div>
	<?php } ?>
	<!-- Header End -->
</header>