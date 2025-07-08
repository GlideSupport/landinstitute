<?php

/**
 * Template Name: Event Template
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
list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults();

$ls_event_kicker = $bst_fields['ls_event_kicker'] ?? null;
$ls_event_page_title = $bst_fields['ls_event_page_title'] ?? get_the_title();
$ls_event_bg_pattern = $bst_fields['ls_event_bg_pattern'] ?? $bst_option_fields['li_to_select_default_background_pattern'];

$today = date('Ymd');

$latest_featured_event = new WP_Query(array(
	'post_type'      => 'event',
	'post_status'    => 'publish',
	'posts_per_page' => 1,
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
	'meta_key'       => 'li_cpt_event_start_date',
	'meta_query'     => array(
		array(
			'key'     => 'li_cpt_event_start_date',
			'value'   => $today,
			'compare' => '>=',
			'type'    => 'NUMERIC',
		),
	),
	'tax_query' => array(
		array(
			'taxonomy' => 'event-tags', // make sure this matches your actual taxonomy slug
			'field'    => 'slug',
			'terms'    => 'featured-on-homepage',
		),
	),
));

?>

<div id="page-section" class="page-section">

	<section id="hero-section" class="hero-section hero-section-default hero-text-only">
		<!-- hero start -->
		<?php echo !empty($ls_event_bg_pattern) ? ' <div class="bg-pattern">' . wp_get_attachment_image($ls_event_bg_pattern, 'thumb_2000') . '</div>' : ''; ?>
		<div class="hero-default has-border-bottom">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-content bg-lime-green">
						<div class="gl-s128"></div>
						<div class="hero-content">
							<?php if ($ls_event_kicker): ?>
								<div class="ui-eyebrow-20-18-regular">
									<?php echo html_entity_decode($ls_event_kicker); ?>
								</div>
								<div class="gl-s20"></div>
							<?php endif; ?>
							<?php if ($ls_event_page_title): ?>
								<h1 class="heading-1 mb-0 block-title"><?php echo html_entity_decode($ls_event_page_title); ?></h1>
								<div class="gl-s96"></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	// Featured Upcoming Event
	if ($latest_featured_event->have_posts()) :
		while ($latest_featured_event->have_posts()) : $latest_featured_event->the_post();

			$event_id    = get_the_ID();
			$title       = get_the_title();
			$permalink   = get_permalink();
			$excerpt     = get_the_excerpt();
			$excerpt = wp_trim_words($excerpt, 20, '...');
			$thumbnail   = get_the_post_thumbnail_url($event_id, 'full');

			// Custom fields
			$start_date  = get_field('li_cpt_event_start_date', $event_id);
			$end_date    = get_field('li_cpt_event_end_date', $event_id);
			$start_time  = get_field('li_cpt_event_start_time', $event_id);
			$end_time    = get_field('li_cpt_event_end_time', $event_id);
			$all_day     = get_field('li_cpt_event_all_day', $event_id);
			$timezone    = get_field('timezone', $event_id);
			

			// Parse dates
			$start_ts    = $start_date ? strtotime($start_date) : false;
			$end_ts      = $end_date ? strtotime($end_date) : false;

			// Format values
			$start_day   = $start_ts ? date('l, F j, Y', $start_ts) : '';
			$end_day     = $end_ts ? date('l, F j, Y', $end_ts) : '';
			$start_short = $start_ts ? date('M j, Y', $start_ts) : '';
			$start_fmt   = $start_time ? date('g:i a', strtotime($start_time)) . ' ' . get_timezone_code($timezone) : '';
			$end_fmt     = $end_time ? date('g:i a', strtotime($end_time)) . ' ' . get_timezone_code($timezone) : '';

			// Build event date string
			$event_date = '';
			if ($start_ts && $end_ts && date('Ymd', $start_ts) !== date('Ymd', $end_ts)) {
				// Multi-day event
				if ($all_day) {
					$event_date = "$start_day - $end_day All Day";
				} elseif ($start_time && $end_time) {
					$event_date = "$start_day $start_fmt - $end_day $end_fmt";
				} else {
					$event_date = $start_short;
				}
			} elseif ($start_ts) {
				// Single-day event
				if ($all_day) {
					$event_date = "$start_day All Day";
				} elseif ($start_time && $end_time) {
					$event_date = "$start_day $start_fmt - $end_fmt";
				} else {
					$event_date = $start_short;
				}
			} ?>
			<section class="container-1280 bg-lilac">
				<div class="wrapper">
					<div class="image-alongside-text-touch has-border-bottom">
						<div class="row-flex">
							<div class="cl-left">
								<div class="alongside-image">
									<?php if ($thumbnail): ?>
										<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
									<?php endif; ?>
								</div>
							</div>
							<div class="cl-right">
								<div class="gl-s44"></div>
								<div class="ui-16-15-bold-uc eybrow-title">Featured Event</div>
								<div class="gl-s80"></div>
								<?php if ($event_date): ?>
									<div class="ui-eyebrow-18-16-regular block-subhead">
										<?php echo esc_html($event_date); ?>
									</div>
								<?php endif; ?>
								<div class="gl-s4"></div>
								<h3 class="heading-3 block-title mb-0"><?php echo esc_html($title); ?></h3>
								<div class="gl-s20"></div>
								<div class="block-content body-20-18-regular">
									<?php echo esc_html($excerpt); ?>
								</div>
								<div class="gl-s20"></div>
								<div class="block-btn">
									<a href="<?php echo esc_url($permalink); ?>" class="site-btn text-link" title="<?php echo esc_attr($title); ?>" role="button" aria-label="Event Details: <?php echo esc_attr($title); ?>">Event Details</a>
								</div>
								<div class="gl-s80"></div>
							</div>
						</div>
					</div>
				</div>
			</section>
	<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<?php
	$eventsview = isset($_GET['eventsview']) ? $_GET['eventsview'] : 'list'; // default to 'list'
	?>
	<section class="container-1280 bg-base-cream">
		<div class="wrapper">
			<div class="event-teaser-calendar-block has-border-bottom">
				<div class="event-teaser-list-row event-calendar-card-row">
					<div class="category-filter">
						<ul class="tabs">
							<a href="<?php echo site_url(); ?>/events/?eventsview=list"
								class="tab-link <?php echo ($eventsview === 'list') ? 'current' : ''; ?>"
								data-tab="tab-1">List View</a>
							<a href="<?php echo site_url(); ?>/events/?eventsview=calendar"
								class="tab-link <?php echo ($eventsview === 'calendar') ? 'current' : ''; ?>"
								data-tab="tab-2">Calendar View</a>
						</ul>
					</div>
					<?php

					$calenderstyle = "display:none";
					$customstyle = "";
					// Avoid undefined index warning
					if (isset($_GET['eventsview']) && $_GET['eventsview'] === 'calendar') {
						$customstyle = "display:none";
						$calenderstyle = "display:block";
					}
					?>
					<div id="event-list-view" style="<?php echo $customstyle; ?>">
						<div id="event-list-main-div" class="event-list-main-div">
							<?php

							$eventargs = array(
								'post_type'      => 'event',
								'post_status'    => 'publish',
								'posts_per_page' => 10,
								'orderby'        => 'meta_value',
								'meta_key'       => 'li_cpt_event_start_date',
								'order'          => 'ASC',
								'meta_query'     => array(
									array(
										'key'     => 'li_cpt_event_start_date',
										'value'   => date('Ymd'), // current date in Ymd format (e.g., 20250708)
										'type'    => 'NUMERIC',   // important if the field is stored as number or string
										'compare' => '>='         // only future or today
									)
								)
							);


							// Avoid undefined index warning
							if (isset($_GET['eventsview']) && $_GET['eventsview'] === 'calendar') {
								$eventargs['posts_per_page'] = -1;

								$eventargs['meta_query'] = [
									'relation' => 'AND',
									[
										'key' => 'li_cpt_event_start_date',
										'value' => date('Ymd'),
										'compare' => '>=',
										'type' => 'NUMERIC'
									],
									[
										'key' => 'li_cpt_event_end_date',
										'value' => date('Ymd'),
										'compare' => '>=',
										'type' => 'NUMERIC'
									]
								];
							}

							$event_query = new WP_Query($eventargs);




							if ($event_query->have_posts()):
								while ($event_query->have_posts()):
									$event_query->the_post();
									$start_date = get_field('li_cpt_event_start_date');
									$end_date = get_field('li_cpt_event_end_date');
									$post_id =get_the_ID();
									$image = wp_get_attachment_image_url(BASETHEME_DEFAULT_IMAGE, 'full');;
									if (get_the_post_thumbnail_url(get_the_ID(), 'medium')) {
										$image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
									}
									$all_day = get_field('li_cpt_event_all_day'); // checkbox or true/false


								$start_date_raw = get_field('li_cpt_event_start_date', $post_id);
								$end_date_raw   = get_field('li_cpt_event_end_date', $post_id);
				
								$event_start_time = get_field('li_cpt_event_start_time', $post_id);
								$event_end_time   = get_field('li_cpt_event_end_time', $post_id);
				
								$timezone = get_field('timezone', $post_id);
								$timezone_code = get_timezone_code($timezone); // Assumes you have a function for this
				
								// Format start/end as DateTime objects
								$start_datetime = new DateTime($start_date_raw . ' ' . $event_start_time);
								$end_datetime   = new DateTime($end_date_raw . ' ' . $event_end_time);
								$li_cpt_event_all_day = get_field('li_cpt_event_all_day',$post_id);
								$days= "";
								if($li_cpt_event_all_day){ $days="All days";}

								// Optional: Set timezone if needed (if $timezone is a valid TZ name)
								if (!empty($timezone)) {
									try {
										$tz = new DateTimeZone($timezone);
										$start_datetime->setTimezone($tz);
										$end_datetime->setTimezone($tz);
									} catch (Exception $e) {
										// fallback silently
									}
								}
				
								// Format the full string
								if ($start_datetime->format('Y-m-d') === $end_datetime->format('Y-m-d')) {
									// Same day
									$event_display = $start_datetime->format('l, F j, Y g:i a') . ' ' . $timezone_code.' '.$days;
								} else {
									// Different days
									$event_display = $start_datetime->format('l, F j, Y g:i a') . ' '. $timezone_code.' '.$days;;
								}


									$excerpt     = get_the_excerpt();
									$excerpt = wp_trim_words($excerpt, 20, '...');
									$url = get_permalink();

									// Pass variables to template part
									set_query_var('start_date', $start_date);
									set_query_var('end_date', $end_date);
									set_query_var('image', $image);
									set_query_var('excerpt', $excerpt);
									set_query_var('url', $url);
									set_query_var('all_day', $all_day);
									set_query_var('event_display', $event_display);



									get_template_part('partials/content', 'event-list');
								endwhile;
							else:
								echo '<p>No events found.</p>';
							endif;
							wp_reset_postdata();
							?>
						</div>
						<?php if ($event_query->found_posts > 10) : ?>
							<div class="block-btn-full">
								<a id="load-more-events" class="site-btn sm-btn" data-page="1">Load More Events</a>
							</div>
						<?php endif; ?>

					</div>

					<div id="event-calendar-view" class="event-teaser-list-col" style="<?php echo $calenderstyle; ?>">

						<!-- Calender View Start -->
						<div class="events-ctn event-calendar-ctn calendar-ctn">
							<?php
							if (isset($_GET['eventsview']) && $_GET['eventsview'] === 'calendar') {

								$key = 0;
								$events_data_raw = array();
								$dates_raw = array();
								$dates = array();
								$events_unordered = array();
								$events = array();
								if ($event_query->have_posts()) {
									while ($event_query->have_posts()) {
										$event_query->the_post();
										$pID = get_the_ID();
										$post_fields = get_fields($pID);
										$cota_cpt_event_title = get_the_title($pID);
										$cota_cpt_event_start_date = get_field('li_cpt_event_start_date');
										$cota_cpt_event_end_date = get_field('li_cpt_event_end_date');
										$final_date = date_formatting($cota_cpt_event_start_date, $cota_cpt_event_end_date);
										if ($cota_cpt_event_start_date == '' || $cota_cpt_event_end_date == '') {
											continue;
										}
										$events_data_raw[$key]['post_title'] = $cota_cpt_event_title;
										$events_data_raw[$key]['pID'] = $pID;
										$events_data_raw[$key]['start_date'] = $cota_cpt_event_start_date;
										$events_data_raw[$key]['end_date'] = $cota_cpt_event_end_date;

										$key++;
									}
								} else {
									echo '<p>No events found.</p>';
								}
								foreach ($events_data_raw as $key => $raw_data) {
									$period = array();
									$time = strtotime($raw_data['end_date']);
									$final = date('Y-m-d', strtotime('+1 day', $time));
									$period_raw = new DatePeriod(
										new DateTime($raw_data['start_date']),
										new DateInterval('P1D'),
										new DateTime($final)
									);
									$buffer = array();
									foreach ($period_raw as $k => $value) {
										$month = date('F Y', strtotime($value->format('Y-m-d')));
										$current_month = date('F Y');
										if (strtotime($month) < strtotime($current_month)) {
											continue;
										}
										$current_date = date('Y-m-d');
										if (strtotime($value->format('Y-m-d')) < strtotime($current_date)) {
											continue;
										}

										$period[$k]['date'] = $value->format('Y-m-d');
										$period[$k]['post_id'] = $raw_data['pID'];
										if (in_array($raw_data['pID'], $buffer)) {
											$period[$k]['multiple'] = true;
										} else {
											$period[$k]['multiple'] = false;
										}
										$period[$k]['current-length'] = event_current_length($buffer, $raw_data['pID']);
										$period[$k]['length'] = event_length($events_data_raw, $raw_data['pID']);
										$buffer[] = $raw_data['pID'];
									}
									$dates_raw[$key] = $period;
									// echo '<pre>'; var_dump($periods); echo '</pre>';
								}
								$dates_raw = array_flatten($dates_raw);
								$dates_raw = sort_array($dates_raw, 'length');
								foreach ($dates_raw as $key => $date) {
									$month = date('F Y', strtotime($date['date']));
									$dates[$month][$date['date']][] = $date;
								}
								foreach ($dates as $key => $value) {
									$date_list = date_list($key);
									$date_keys = array_keys($value);
									foreach ($date_list as $date) {
										if (!in_array($date, $date_keys)) {
											$events_unordered[$key][$date] = null;
										} else {
											$events_unordered[$key][$date] = $value[$date];
										}
									}
								}
								$months = month_sort(array_keys($events_unordered));
								foreach ($months as $month) {
									$events[$month] = $events_unordered[$month];
								}
							?>
								<?php
								$number = 1;
								$old = array();
								foreach ($events as $month => $days) {
								?>
									<div class="event-calendar-row ct-<?php echo number_to_words($number); ?>-month">
										<div class="calendar-month">
											<h3 class="heading-5"><?php echo $month; ?></h3>
										</div>
										<div class="calendar-day-name-row">
											<div class="calendar-day-name">
												<span class="mobile-hide"><?php _e('su', 'cota_td'); ?></span> <span
													class="mobile-show"><?php _e('s', 'cota_td'); ?></span>
											</div>
											<div class="calendar-day-name">
												<span class="mobile-hide"><?php _e('Mo', 'cota_td'); ?></span> <span
													class="mobile-show"><?php _e('m', 'cota_td'); ?></span>
											</div>
											<div class="calendar-day-name">
												<span class="mobile-hide"><?php _e('tu', 'cota_td'); ?></span> <span
													class="mobile-show"><?php _e('t', 'cota_td'); ?></span>
											</div>
											<div class="calendar-day-name">
												<span class="mobile-hide"><?php _e('we', 'cota_td'); ?></span> <span
													class="mobile-show"><?php _e('w', 'cota_td'); ?></span>
											</div>
											<div class="calendar-day-name">
												<span class="mobile-hide"><?php _e('th', 'cota_td'); ?></span> <span
													class="mobile-show"><?php _e('t', 'cota_td'); ?></span>
											</div>
											<div class="calendar-day-name">
												<span class="mobile-hide"><?php _e('fr', 'cota_td'); ?></span> <span
													class="mobile-show"><?php _e('f', 'cota_td'); ?></span>
											</div>
											<div class="calendar-day-name">
												<span class="mobile-hide"><?php _e('sa', 'cota_td'); ?></span> <span
													class="mobile-show"><?php _e('s', 'cota_td'); ?></span>
											</div>
											<div class="clear"></div>
										</div>
										<div class="calendar-days-row">
											<?php
											$sure_arr = array(0, 3, 3, 6, 3, 6, 1, 4, 0, 3, 6, 1);
											$month_arr = explode(' ', $month);
											$old_days = array();
											$i = 1;
											foreach ($days as $date => $events) {
												$old_day_class = '';
												$row_class = '';
												$day = date('d', strtotime($date));

												if ($i < 8) {
													$row_class = 'ct-first-row';
												} elseif ($i >= 8 && $i < 15) {
													$row_class = 'ct-second-row';
												} elseif ($i >= 15 && $i < 22) {
													$row_class = 'ct-third-row';
												} elseif ($i >= 22 && $i < 29) {
													$row_class = 'ct-forth-row';
												} elseif ($i >= 29 && $i < 32) {
													$row_class = 'ct-firth-row';
												}
												$col_arr = array(
													array(1, 8, 15, 22, 29),
													array(2, 9, 16, 23, 30),
													array(3, 10, 17, 24, 31),
													array(4, 11, 18, 25),
													array(5, 12, 19, 26),
													array(6, 13, 20, 27),
													array(7, 14, 21, 28),
												);
												$col_class = '';

												if (in_array($i, $col_arr[0])) {
													$col_class = 'ct-first-col';
												} elseif (in_array($i, $col_arr[1])) {
													$col_class = 'ct-second-col';
												} elseif (in_array($i, $col_arr[2])) {
													$col_class = 'ct-third-col';
												} elseif (in_array($i, $col_arr[3])) {
													$col_class = 'ct-forth-col';
												} elseif (in_array($i, $col_arr[4])) {
													$col_class = 'ct-fifth-col';
												} elseif (in_array($i, $col_arr[5])) {
													$col_class = 'ct-sixth-col';
												} elseif (in_array($i, $col_arr[6])) {
													$col_class = 'ct-seventh-col';
												}
												$last_day = '';
												$first_day = '';
												if ($i == count($days)) {
													$last_day = 'ct-last-day-in-month';
												}
												if ($i == 1) {
													$first_day = 'ct-first-day-in-month';
												}
											?>
												<div class="calendar-column <?php echo $row_class; ?> <?php echo $col_class; ?>  <?php
																																	if ($events) {
																																		echo 'col-has-event';
																																	}
																																	?>
							">
													<div class="calendar-date"><?php echo $day; ?></div>
													<?php
													if ($events) {
														foreach ($events as $key => $event) {
															if ($key > 1) {
																continue;
															}
															$item_class = '';
															if ($key == 0) {
																$item_class = 'ct-first-in-view';
															} elseif ($key == 1) {
																$item_class = 'ct-second-in-view';
															}
															$args = array(
																'event' => $event,
																'date' => $date,
																'item_class' => $item_class,
																'last_day' => $last_day,
																'first_day' => $first_day,
															);
															get_template_part('partials/content', 'event-item', $args);
														}
													?>
														<?php
														if ($events) {
															if (count($events) > 2) {
														?>
																<span class="more-btn">+<?php echo count($events) - 2; ?>
																	more</span>
																<div class="more-events" style="display:none;">
																	<?php
																	foreach ($events as $key => $event) {
																		if ($key < 2) {
																			continue;
																		}
																		$args = array(
																			'event' => $event,
																			'date' => $date,
																			'item_class' => 'ct-not-in-view',
																			'last_day' => $last_day,
																			'first_day' => $first_day,
																		);
																		get_template_part('partials/content', 'event-item', $args);
																	}
																	?>
																</div>
														<?php
															}
														}
														?>

														<div class="tooltip" style="display:none;">
															<?php
															foreach ($events as $key => $event) {
																$args = array(
																	'event' => $event,
																	'date' => $date,
																);
																get_template_part('partials/content', 'event-tooltip', $args);
															}
															?>
														</div>
													<?php } ?>
												</div>
											<?php $i++;
											} ?>

										</div>
									</div>
							<?php
									$number++;
									$old = array();
								}
							}
							?>
						</div>
						<!-- Calender View End -->
					</div>

				</div>
			</div>
		</div>

	</section>

	<?php
	global $wp_query;
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			// Include specific template for the content.
			get_template_part('partials/content', 'page');
		}
	}
	?>
</div>
<?php
get_footer(); ?>