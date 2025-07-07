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

$news_temp_kicker_text = $bst_fields['news_temp_kicker_text'] ?? null;
$news_temp_headline_text = $bst_fields['news_temp_headline_text'] ?? null;
$news_headline_check = BaseTheme::headline_check($news_temp_headline_text);
?>

<div id="page-section" class="page-section">



	<section id="hero-section" class="hero-section hero-section-default hero-alongside-standard">
		<!-- hero start -->
		<div class="bg-pattern">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/TLI-Pattern-Repair-SkyBlue-stickys.jpg"
				width="" height="" alt="TLI-Pattern-Repair-SkyBlue-stickys"
				title="TLI-Pattern-Repair-SkyBlue-stickys" />
		</div>
		<div class="hero-default has-border-bottom">
			<div class="wrapper">
				<div class="hero-alongside-block">
					<div class="col-left bg-lime-green">
						<div class="hero-content">
							<?php if ($news_temp_kicker_text): ?>
								<div class="ui-eyebrow-20-18-regular">
									<?php echo html_entity_decode($news_temp_kicker_text); ?>
								</div>
								<div class="gl-s20"></div>
							<?php endif; ?>
							<?php if ($news_headline_check): ?>
								<?php echo BaseTheme::headline($news_temp_headline_text, 'heading-1 mb-0 block-title'); ?>
								<div class="gl-s96"></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-right">
						<div class="bg-pattern">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/src/images/TLI-Pattern-Repair-SkyBlue-stickys.jpg"
								width="" height="" alt="TLI-Pattern-Repair-SkyBlue-stickys"
								title="TLI-Pattern-Repair-SkyBlue-stickys" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

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
								'post_type' => 'event',
								'post_status' => 'publish',
								'posts_per_page' => 10,
								'orderby' => 'meta_value',
								'meta_key' => 'li_cpt_event_start_date',
								'order' => 'ASC'
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

									$image = "https://landinstdev.wpenginepowered.com/wp-content/uploads/demo.webp";
									if (get_the_post_thumbnail_url(get_the_ID(), 'medium')) {
										$image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
									}




									$excerpt = get_the_excerpt();
									$url = get_permalink();

									// Pass variables to template part
									set_query_var('start_date', $start_date);
									set_query_var('end_date', $end_date);
									set_query_var('image', $image);
									set_query_var('excerpt', $excerpt);
									set_query_var('url', $url);

									get_template_part('partials/content', 'event-list');
								endwhile;
							else:
								echo '<p>No events found.</p>';
							endif;
							wp_reset_postdata();
							?>
						</div>
						<div class="block-btn-full">
						<a id="load-more-events" class="site-btn sm-btn" data-page="1">LoadMore</a>
						</div>

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