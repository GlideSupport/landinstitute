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
get_header(); 

list( $bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object ) = BaseTheme::defaults();

?>

<?php 
$bst_var_learn_bg_pattern = $bst_option_fields['bst_var_learn_bg_pattern'] ?? null;
$bst_var_dl_headline = $bst_option_fields['bst_var_dl_headline'] ?? null;
$bst_var_dl_repeater = $bst_option_fields['bst_var_dl_repeater'] ?? null;
$bst_var_dl_image = $bst_option_fields['bst_var_dl_image'] ?? null;  
$bst_var_tf_title = $bst_option_fields['bst_var_tf_title'] ?? null;
$bst_var_tf_kicker = $bst_option_fields['bst_var_tf_kicker'] ?? null;
$bst_var_tf_form_selector = $bst_option_fields['bst_var_tf_form_selector'] ?? null;
?>
<main id="main-section" class="main-section">
	<div class="page-section">
		<section id="hero-section" class="hero-section hero-section-default hero-alongside-menu">
			<!-- Hero Start -->
			<?php echo !empty($bst_var_learn_bg_pattern) ? '<div class="bg-pattern">' . wp_get_attachment_image($bst_var_learn_bg_pattern, 'thumb_1600') . '</div>' : ''; ?>
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
							<?php echo !empty($bst_var_learn_bg_pattern) ? '<div class="bg-pattern">' . wp_get_attachment_image($bst_var_learn_bg_pattern, 'thumb_1600') . '</div>' : ''; ?>
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
												<img src="<?php echo esc_url( wp_get_attachment_image_url( BASETHEME_DEFAULT_IMAGE, 'full' ) ); ?>" alt="Default thumbnail" width="500" height="300" />
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
						<?php echo !empty($bst_var_dl_image) ? '<div class="col-left sticky-img "><div class="sticky-image-stick">' . wp_get_attachment_image($bst_var_dl_image, 'thumb_1200') . '</div></div>' : ''; ?>
						<div class="cl-right">
							<div class="gl-s156"></div>
							<?php echo !empty($bst_var_dl_headline) ? '<h2 class="heading-2 block-title mb-0">' . esc_html($bst_var_dl_headline) . '</h2>' : ''; ?>   	
							<?php echo (!empty($bst_var_dl_headline) && !empty($bst_var_dl_repeater)) ? '<div class="gl-s12"></div>' : ''; ?>
							<?php if (!empty($bst_var_dl_repeater)) : ?>
								<div class="card-list">
								<?php foreach ($bst_var_dl_repeater as $bst_var_dl_rep) : 
									$title = $bst_var_dl_rep['title'] ?? '';
									$wysiwyg = $bst_var_dl_rep['wysiwyg'] ?? '';
									$link = $bst_var_dl_rep['link'] ?? null;
								
									$link_url = $link['url'] ?? '';
									$link_title = $link['title'] ?? '';
									$link_target = $link['target'] ?? '_self';
									
									if(!empty($title) || !empty($wysiwyg) || !empty($link)): ?>
										<?php echo !empty($link_url) ? '<a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '" class="card-item link-with-title with-arrow">' : '<div class="card-item link-with-title with-arrow">'; ?>								
											<?php if(!empty($title) || !empty($wysiwyg)): ?>
												<div class="card-item-left">
													<?php echo !empty($title) ? '<div class="card-title ui-24-21-bold">' . esc_html($title) . '</div>' : ''; ?>   
													<?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s4"></div>' : ''; ?>
													<?php echo !empty($wysiwyg) ? '<div class="card-content body-18-16-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>   
												</div>
											<?php endif; ?>
											<?php if(!empty($link_url)) :?>
												<div class="card-item-right">
													<div class="dot-btn">
														<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/src/images/right-circle-arrow.svg" title="right-circle-arrow" alt="right-circle-arrow">
													</div>
												</div>
											<?php endif; ?>
										<?php echo !empty($link) ? '</a>' : '</div>'; ?>
									<?php  endif; endforeach; ?>
								</div>
							<?php endif; ?>
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
						<?php echo !empty($bst_var_tf_kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($bst_var_tf_kicker) . '</div>' : ''; ?>	
						<?php echo (!empty($bst_var_tf_kicker) && !empty($bst_var_tf_title)) ? '<div class="gl-s12"></div>' : ''; ?>
						<?php echo !empty($bst_var_tf_title) ? '<h2 class="heading-2 mb-0 block-title">' . esc_html($bst_var_tf_title) . '</h2>' : ''; ?>	
						<div class="gl-s44"></div>
						<div class="newsletter-form">
							<?php echo !empty($bst_var_tf_form_selector) ? do_shortcode('[gravityform id="' . $bst_var_tf_form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
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