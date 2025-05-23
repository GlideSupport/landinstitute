<header id="header-section" class="header-section">
    
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
								<a href="" class="search-popup">
									<!-- when hover on menu add "active-hover" class -->
									<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/search-icon.svg" width="29" height="29" alt="" /></a>
								<div class="mega-dropdown search-mega-dropdown" id="mega-dropdown-product">
									<div class="mega-dropdown-card">
										<div class="col-left">
											<div class="search-everything">
												<a class="site-btn arrow-btn" href="">Search everything</a>
											</div>
											<div class="image-category-card">
												<a class="image-cat-group" href="">
													<div class="category-image">
														<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/Modeling-carbon.jpg"
															width="" height="" alt="" />
														<div class="tag-label"><span class="tags">Popular
																Resource</span>
														</div>
													</div>
													<div class="post-content">
														<div class="gl-s30"></div>
														<div class="ui-eyebrow-16-15-regular eyebrow-label">Podcast
														</div>
														<div class="gl-s6"></div>
														<div class="heading-7 card-title mb-0">Modeling carbon
															allocation
															strategies for high-yielding perennial crops</div>
														<div class="gl-s30"></div>
													</div>
												</a>
											</div>
										</div>
										<div class="col-right">
											<div class="popup-search">
												<form role="search" method="get" action="">
													<input type="text" name="s" placeholder="What are you serching for?"
														autofocus="">
													<button class="site-btn btn-lemon-yellow sm-btn"
														type="submit">Search</button>
												</form>
											</div>
											<div class="search-content">
												<div class="mega-menu-row">
													<div class="mega-col">
														<div class="ui-24-21-bold mega-menu-title">Common Searches</div>
														<div class="gl-s16"></div>
														<ul class="dot-hover">
															<li>
																<a href="">Research & Publications</a>
															</li>
															<li>
																<a href="">Research & Publications</a>
															</li>
															<li>
																<a href="">Interviews</a>
															</li>
															<li>
																<a href="">Interviews</a>
															</li>
															<li>
																<a href="">Podcasts</a>
															</li>
															<li>
																<a href="">Podcasts</a>
															</li>
															<li>
																<a href="">Stories</a>
															</li>
															<li>
																<a href="">Stories</a>
															</li>
														</ul>
													</div>
												</div>
												<div class="gl-s30"></div>
												<div class="tags-cols">
													<div class="ui-24-21-bold topics-title">Popular topics</div>
													<div class="gl-s20"></div>
													<ul>
														<li>
															<span class="tags">
																Research</span>
														</li>
														<li>
															<span class="tags">
																Kernza</span>
														</li>
														<li>
															<span class="tags">
																Perennial crops</span>
														</li>
														<li>
															<span class="tags">
																Crop Development</span>
														</li>
														<li>
															<span class="tags">
																Rice</span>
														</li>
														<li>
															<span class="tags">
																Podcasts</span>
														</li>
														<li>
															<span class="tags">
																Global Network</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="menu-btn menu-hamburger-icon">
						<a href="#" id="trigger" class="menu-trigger">
							<span class="top"></span>
							<span class="middle"></span>
							<span class="bottom"></span>
						</a>
					</div>
                    <?php if (!empty($bst_var_tohdr_btn)): ?>
                        <div class="header-btns">
                            <?php echo BaseTheme::button($bst_var_tohdr_btn, 'site-btn btn-sunflower-yellow sm-btn arrow-heart-symbol'); ?>
                        </div>
                    <?php endif; ?>
				</div>
			</div>
		</div>
   
    <!-- Header End -->
</header>