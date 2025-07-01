<?php
/**
 * The template  displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Base Theme Package
 * @since   1.0.0
 */

// Include header.
get_header();

list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults();

// 404 Page - Advanced custom fields variables.
$bst_var_error_headline = $bst_option_fields['bst_var_error_headline'] ?? null;
$bst_var_error_sub_headline = $bst_option_fields['bst_var_error_sub_headline'] ?? null;
$bst_var_error_text = $bst_option_fields['bst_var_error_text'] ?? null;
$bst_var_error_search = $bst_option_fields['bst_var_error_search'] ?? false;

?>
<section id="hero-section" class="hero-section hero-section-default">
	<section id="page-section" class="page-section">
		<div class="center-align error-page-hero">
			<div class="gl-s156"></div>
			<div class="wrapper">
				<h1 class="block-title mb-0 heading-1"><?php echo esc_html($bst_var_error_headline); ?></h1>
				</h1>
				<div class="gl-s24"></div>
				<div class="banner-text">
					<h2 class="heading-5 mb-0 block-title"><?php echo esc_html($bst_var_error_sub_headline); ?></h2>
				</div>
				<div class="gl-s20"></div>
				<div class="error-404 not-found center-align">
					<div class="page-content">
						<?php
						if ($bst_var_error_text) {
							echo html_entity_decode($bst_var_error_text);
						}
						?>
					</div>
					<div class="gl-s30"></div>
					<div class="form-404 search-popup-content">
						<?php if (!$bst_var_error_search) { ?>
							<div class="not-found-search">
								<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
									<label>
										<span class="screen-reader-text"><?php _e('Search for:', 'textdomain'); ?></span>
										<input type="search" class="search-field" placeholder="Search …" value="<?php echo get_search_query(); ?>" name="s" />
									</label>
									<button type="submit" class="site-btn sm-btn btn-lemon-yellow">Search</button>
								</form>
							</div>
						<?php } ?>
					</div>
					<div class="gl-s30"></div>
					<div class="back-to-home">
						<a href="<?php echo esc_url(home_url('/')); ?>" title="Back To Home" role="Back To Home"
							aria-label="Back To Home" class="site-btn">
							Back To Home </a>

					</div>
				</div><!-- .error-404 -->
			</div>
			<div class="gl-s156"></div>
		</div>
	</section>
</section>
<?php
get_footer();
