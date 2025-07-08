<?php
/**
 * Block Name: Event Teaser
 * Template for displaying the Event Teaser Gutenberg block.
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_block_id, $bst_block_fields) = BaseTheme::defaults($block['id']);

// Prepare variables
$bst_block_name = str_replace('acf/', '', $block['name']);
$bst_block_styles = BaseTheme::convert_to_css($block);
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';
$bst_var_class_name = $block['className'] ?? '';
$bst_block_html_id = !empty($block['anchor']) ? $block['anchor'] : 'block-' . $bst_block_name . '-' . $block['id'];
$bst_var_name = 'block-' . str_replace('/', '-', $block['name']);

// Editor preview image
if (isset($block['data']['preview'])) {
	echo '<img src="' . esc_url(get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview']) . '" style="width:100%; height:auto;">';
	return;
}

// Block fields
$headline       = $bst_block_fields['li_et_headline'] ?? '';
$kicker         = $bst_block_fields['li_et_kicker'] ?? '';
$button         = $bst_block_fields['li_et_button'] ?? '';
$select_option  = $bst_block_fields['li_et_event_select_option'] ?? 'manual';
$manual_events  = $bst_block_fields['li_et_select_manual_event'] ?? [];

$headline_check = BaseTheme::headline_check($headline);

// Query setup
$args = [
	'post_type'      => 'event',
	'post_status'    => 'publish',
	'posts_per_page' => 2,
	'orderby'        => 'meta_value',
	'order'          => 'ASC',
	'meta_key'       => 'li_cpt_event_start_date',
	'meta_type'      => 'DATE',
	'meta_query'     => [
		[
			'key'     => 'li_cpt_event_start_date',
			'value'   => date('Ymd'),
			'compare' => '>=',
			'type'    => 'DATE',
		],
	],
];

// Override if manual selection
if ($select_option === 'manual' && !empty($manual_events)) {
	$args = [
		'post_type'      => 'event',
		'post_status'    => 'publish',
		'post__in'       => $manual_events,
		'orderby'        => 'post__in',
		'posts_per_page' => count($manual_events),
	];
}

$events_query = new WP_Query($args);

if (!empty($headline_check) && $events_query->have_posts()) : ?>
	<div id="<?php echo esc_attr($bst_block_html_id); ?>" class="<?php echo esc_attr(trim("{$bst_var_align_class} {$bst_var_class_name} {$bst_var_name} block-{$bst_block_name}")); ?>" style="<?php echo esc_attr($bst_block_styles); ?>">
		<div class="event-teaser-list-block">
			<div class="heading-max max-800">
				<?php if ($kicker) : ?>
					<div class="ui-eyebrow-18-16-regular block-subhead"><?php echo esc_html($kicker); ?></div>
					<?php if ($headline_check) echo '<div class="gl-s12"></div>'; ?>
				<?php endif; ?>

				<?php if ($headline_check) echo BaseTheme::headline($headline, 'heading-2 block-title mb-0'); ?>
			</div>

			<?php if ($headline_check) echo '<div class="gl-s64"></div>'; ?>

			<div class="event-teaser-list-row">
				<?php while ($events_query->have_posts()) : $events_query->the_post();
					$event_id  = get_the_ID();
					$title     = get_the_title();
					$permalink = get_permalink();
					$excerpt     = get_the_excerpt($event_id);
					$excerpt = wp_trim_words($excerpt, 20, '...');
					$thumb     = wp_get_attachment_image(get_post_thumbnail_id($event_id), 'thumb_800');

					// Fields
					$start_date = strtotime(get_field('li_cpt_event_start_date', $event_id));
					$end_date   = strtotime(get_field('li_cpt_event_end_date', $event_id));
					$start_time = get_field('li_cpt_event_start_time', $event_id);
					$end_time   = get_field('li_cpt_event_end_time', $event_id);
					$all_day    = get_field('li_cpt_event_all_day', $event_id);
					$timezone   = get_field('timezone', $event_id);

					// Format date/time
					$tz         = get_timezone_code($timezone);
					$start_fmt  = $start_time ? date('g:i a', strtotime($start_time)) . " $tz" : '';
					$end_fmt    = $end_time   ? date('g:i a', strtotime($end_time)) . " $tz" : '';

					$event_date = '';
					if ($start_date) {
						$start_str = date('l, F j, Y', $start_date);
						$end_str   = $end_date ? date('l, F j, Y', $end_date) : '';

						if ($end_date && date('Ymd', $start_date) !== date('Ymd', $end_date)) {
							$event_date = $all_day ? "$start_str - $end_str All Day" :
								($start_fmt && $end_fmt ? "$start_str $start_fmt - $end_str $end_fmt" : date('M j, Y', $start_date));
						} else {
							$event_date = $all_day ? "$start_str All Day" :
								($start_fmt && $end_fmt ? "$start_str $start_fmt - $end_fmt" : date('M j, Y', $start_date));
						}
					}
				?>
					<div class="event-teaser-list-col">
						<a href="<?php echo esc_url($permalink); ?>" class="event-teaser-list-card">
							<div class="event-teaser-list-image">
								<?php echo $thumb; ?>
							</div>
							<div class="event-teaser-list-content">
								<?php if ($title || $excerpt) echo '<div class="gl-s64"></div>'; ?>

								<?php if ($event_date): ?>
									<div class="ui-eyebrow-18-16-regular block-subhead"><?php echo esc_html($event_date); ?></div>
								<?php endif; ?>

								<?php if ($event_date && $title) echo '<div class="gl-s4"></div>'; ?>

								<?php if ($title) : ?>
									<h4 class="heading-4 mb-0 block-title"><?php echo esc_html($title); ?></h4>
								<?php endif; ?>

								<?php if ($title && $excerpt) echo '<div class="gl-s16"></div>'; ?>

								<?php if ($excerpt) : ?>
									<div class="block-content body-20-18-regular"><?php echo wp_kses_post($excerpt); ?></div>
									<div class="gl-s20"></div>
								<?php endif; ?>

								<div class="block-btns">
									<div class="site-btn text-link" role="button" aria-label="Event Details: <?php echo esc_attr($title); ?>">Event Details</div>
								</div>

								<div class="gl-s64"></div>
							</div>
						</a>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>

			<?php if ($button) : ?>
				<div class="section-btn full-width-button">
					<?php echo BaseTheme::button($button, 'site-btn'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
