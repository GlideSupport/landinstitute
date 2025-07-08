<?php
/**
 * Template part for displaying single event
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object ) = BaseTheme::defaults();

// Post Tags & Categories.
$bst_var_post_categories = get_categories( $bst_var_post_id );

$title = get_the_title();
$start_date = $bst_fields['li_cpt_event_start_date'];
$end_date = $bst_fields['li_cpt_event_end_date'];
$start_time = $bst_fields['li_cpt_event_start_time'];
$end_time = $bst_fields['li_cpt_event_end_time'];
$all_day = $bst_fields['li_cpt_event_all_day'];
$link = $bst_fields['li_cpt_link'];
$bg_pattern = $bst_fields['li_cpt_bg_pattern'];
$li_cpt_more_event = $bst_fields['li_cpt_more_event'];
$li_cpt_more_event_check = BaseTheme::headline_check($li_cpt_more_event);
$li_cpt_related_events = $bst_fields['li_cpt_related_events'] ?? null;
$newsletter_form_visible = $bst_fields['newsletter_form_visible'];
$headline = $bst_fields['li_cpt_headline'];
$headline_check = BaseTheme::headline_check($headline);
$kicker = $bst_fields['li_cpt_kicker'];
$form_selector = $bst_fields['li_cpt_form_selector'];

//Date Format
$start_date = $start_date ? strtotime($start_date) : false;
$end_date   = $end_date ? strtotime($end_date) : false;

// Format
$start_day_full = $start_date ? date('l, F j, Y', $start_date) : '';
$end_day_full   = $end_date ? date('l, F j, Y', $end_date) : '';
$start_day_short = $start_date ? date('M j, Y', $start_date) : '';
$start_time_fmt = $start_time ? date('g:i a', strtotime($start_time)) . ' CDT' : '';
$end_time_fmt   = $end_time ? date('g:i a', strtotime($end_time)) . ' CDT' : '';

$event_date = '';

if ($start_date && $end_date) {
	// Multi-day
	if (date('Ymd', $start_date) !== date('Ymd', $end_date)) {
		if ($all_day) {
			// Example: Friday, May 2, 2025 - Saturday, May 3, 2025 All Day
			$event_date = "$start_day_full - $end_day_full All Day";
		} elseif ($start_time && $end_time) {
			// Example: Friday, May 2, 2025 12:00 pm CDT - Saturday, May 3, 2025 1:00 pm CDT
			$event_date = "$start_day_full $start_time_fmt - $end_day_full $end_time_fmt";
		} else {
			$event_date = "$start_day_short";
		}
	} else {
		// Single-day
		if ($all_day) {
			// Example: Friday, May 2, 2025 All Day
			$event_date = "$start_day_full All Day";
		} elseif ($start_time && $end_time) {
			// Example: Friday, May 2, 2025 12:00 pm CDT - 1:00 pm CDT
			$event_date = "$start_day_full $start_time_fmt - $end_time_fmt";
		} else {
			$event_date = "$start_day_short";
		}
	}
} elseif ($start_date) {
	// Only start date
	if ($all_day) {
		$event_date = "$start_day_full All Day";
	} elseif ($start_time && $end_time) {
		$event_date = "$start_day_full $start_time_fmt - $end_time_fmt";
	} else {
		$event_date = "$start_day_short";
	}
} else {
	$event_date = '';
}
					
?>

<section id="hero-section"
	class="hero-section hero-section-default hero-alongside-menu variation-width variation-details">
	<!-- hero start -->
	<?php echo !empty($bg_pattern) ? '<div class="bg-pattern">' . wp_get_attachment_image($bg_pattern, 'thumb_1600') . '</div>' : ''; ?>
	<div class="hero-default has-border-bottom">
		<div class="wrapper">
			<div class="hero-alongside-block">
				<div class="col-left bg-lime-green">
					<div class="hero-content">
						<?php echo !empty($event_date) ? '<div class="ui-eyebrow-18-16-regular">' . esc_html($event_date) . '</div>' : ''; ?>
						<?php echo (!empty($event_date) && !empty($title)) ? '<div class="gl-s12"></div>' : ''; ?>
						<?php echo !empty($title) ? '<div class="heading-2 mb-0 block-title">' . esc_html($title) . '</div>' : ''; ?>
						<?php echo (!empty($title) && !empty($link)) ? '<div class="gl-s30"></div>' : ''; ?>
						<?php echo !empty($link) ? '<div class="block-btn">' . BaseTheme::button($link, 'site-btn text-link') . '</div>' : ''; ?>
						<div class="gl-s96"></div>
					</div>
				</div>
				<div class="col-right">
					<div class="bg-pattern">
						<img src="https://landinstdev.wpenginepowered.com/wp-content/uploads/2025/05/TLI-Pattern-Repair-Sky-Blue-scaled.jpg"
							width="" height="" alt="" />
					</div>	
					<?php echo has_post_thumbnail() ? '<div class="block-image-center">' . get_the_post_thumbnail(get_the_ID(), 'thumb_500', ['alt' => get_the_title()]) . '</div>' : ''; ?>
				</div>
			</div>
		</div>
	</div>
</section>			

<?php the_content(); ?>

<section class="container-1280 bg-base-cream">
	<div class="gl-s128"></div>
	<div class="wrapper">
		<div class="read-more-block">
			<?php echo !empty($li_cpt_more_event_check) ? BaseTheme::headline($li_cpt_more_event, 'heading-2 block-title mb-0') : ''; ?>
			<div class="gl-s52"></div>
			<div class="border-variable-slider">
				<!-- Swiper -->
				<div class="swiper-container read-slide-preview cursor-drag-icon">
					<div class="swiper-wrapper">
						<?php
						if (!empty($li_cpt_related_events)) :
							$args = [
								'post_type'      => 'event',
								'post__in'       => $li_cpt_related_events,
								'orderby'        => 'post__in'
							];
							$events_query = new WP_Query($args);

							while ($events_query->have_posts()) : $events_query->the_post();
								$event_id = get_the_ID();
								$title = get_the_title();
								$permalink = get_permalink();
								$start_date = get_field('li_cpt_event_start_date', $event_id);
								$end_date = get_field('li_cpt_event_end_date', $event_id);
								$start_time = get_field('li_cpt_event_start_time', $event_id);
								$end_time = get_field('li_cpt_event_end_time', $event_id);
								$all_day = get_field('li_cpt_event_all_day', $event_id);
								$wysiwyg = get_the_excerpt($event_id);

								// Date formatting
								$start_date = $start_date ? strtotime($start_date) : false;
								$end_date   = $end_date ? strtotime($end_date) : false;

								$start_day_full = $start_date ? date('l, F j, Y', $start_date) : '';
								$end_day_full   = $end_date ? date('l, F j, Y', $end_date) : '';
								$start_day_short = $start_date ? date('M j, Y', $start_date) : '';
								$start_time_fmt = $start_time ? date('g:i a', strtotime($start_time)) . ' CDT' : '';
								$end_time_fmt   = $end_time ? date('g:i a', strtotime($end_time)) . ' CDT' : '';

								$event_date = '';

								if ($start_date && $end_date) {
									if (date('Ymd', $start_date) !== date('Ymd', $end_date)) {
										if ($all_day) {
											$event_date = "$start_day_full - $end_day_full All Day";
										} elseif ($start_time && $end_time) {
											$event_date = "$start_day_full $start_time_fmt - $end_day_full $end_time_fmt";
										} else {
											$event_date = "$start_day_short";
										}
									} else {
										if ($all_day) {
											$event_date = "$start_day_full All Day";
										} elseif ($start_time && $end_time) {
											$event_date = "$start_day_full $start_time_fmt - $end_time_fmt";
										} else {
											$event_date = "$start_day_short";
										}
									}
								} elseif ($start_date) {
									if ($all_day) {
										$event_date = "$start_day_full All Day";
									} elseif ($start_time && $end_time) {
										$event_date = "$start_day_full $start_time_fmt - $end_time_fmt";
									} else {
										$event_date = "$start_day_short";
									}
								}
						?>
							<div class="swiper-slide">
								<div class="image-card-caption">
									<a href="<?php echo esc_url($permalink); ?>" class="caption-card-link">
										<div class="image">
											<?php echo wp_get_attachment_image(get_post_thumbnail_id($event_id), 'thumb_800'); ?>
										</div>
										<div class="caption-card-content">
											<div class="gl-s52"></div>
											<div class="eyebrow ui-eyebrow-16-15-regular"><?php echo esc_html($event_date); ?></div>
											<?php echo (!empty($event_date) && !empty($title)) ? '<div class="gl-s6"></div>' : ''; ?>
											<?php echo !empty($title) ? '<div class="card-title heading-7">' . esc_html($title) . '</div>' : ''; ?>
											<?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s12"></div>' : ''; ?>
											<?php echo !empty($wysiwyg) ? '<div class="description ui-18-16-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
											<?php echo (!empty($wysiwyg)) ? '<div class="gl-s20"></div>' : ''; ?>
											<div class="read-more-link">
												<div class="border-text-btn">Read more</div>
											</div>
											<div class="gl-s80"></div>
										</div>
									</a>
								</div>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
						<?php endif; ?>
					</div> <!-- swiper-wrapper -->
				</div> <!-- swiper-container -->
			</div> <!-- border-variable-slider -->
		</div> <!-- read-more-block -->
	</div> <!-- wrapper -->
</section>


<?php if ($newsletter_form_visible == 1): ?>
	<section class="container-720 bg-butter-yellow">
		<div class="gl-s156"></div>
		<div class="wrapper">
			<div class="newsletter-block">
				<div class="block-row">
					<?php echo !empty($kicker) ? '<div class="ui-eyebrow-18-16-regular sub-head">' . esc_html($kicker) . '</div>' : ''; ?>	
					<?php echo (!empty($kicker) && !empty($headline_check)) ? '<div class="gl-s12"></div>' : ''; ?>
					<?php echo !empty($headline_check) ? BaseTheme::headline($headline, 'heading-2 mb-0 block-title') : ''; ?>
					<?php echo (!empty($headline_check) && !empty($form_selector)) ? '<div class="gl-s44"></div>' : ''; ?>
					<div class="newsletter-form">
						<?php echo !empty($form_selector) ? do_shortcode('[gravityform id="' . $form_selector . '" title="false" ajax="true" tabindex="0"]') : ''; ?>
					</div>
					<div class="gl-s80"></div>
				</div>
			</div>
		</div>
		<div class="gl-s128"></div>
	</section>
<?php endif; ?>
<?php get_footer(); ?>