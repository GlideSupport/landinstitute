<?php
/**
 * Block Name: Event Teaser
 *
 * The template for displaying the custom gutenberg block named Event Teaser.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list( $bst_block_id, $bst_block_fields ) = BaseTheme::defaults( $block['id'] );

// Set the block name for it's ID & class from it's file name.
$bst_block_name   = $block['name'];
$bst_block_name   = str_replace( 'acf/', '', $bst_block_name );
$bst_block_styles = BaseTheme::convert_to_css( $block );
// Set the preview thumbnail for this block for gutenberg editor view.
if ( isset( $block['data']['preview'] ) ) {
	echo '<img src="' . esc_url( get_template_directory_uri() . '/blocks/' . $bst_block_name . '/' . $block['data']['preview'] ) . '" style="width:100%; height:auto;">';
	return;
}
// create align class ("alignwide") from block setting ("wide").
$bst_var_align_class = $block['align'] ? 'align' . $block['align'] : '';

// Get the class name for the block to be used for it.
$bst_var_class_name = ( isset( $block['className'] ) ) ? $block['className'] : null;

// Making the unique ID for the block.
$bst_block_html_id = 'block-' . $bst_block_name . '-' . $block['id'];
if( !empty($block['anchor']) ) {
	$bst_block_html_id = $block['anchor'];
}
// Making the unique ID for the block.
if ( $block['name'] ) {
	$bst_block_name = $block['name'];
	$bst_block_name = str_replace( '/', '-', $bst_block_name );
	$bst_var_name   = 'block-' . $bst_block_name;
}

// Block variables.
$li_et_headline = $bst_block_fields['li_et_headline'] ?? null;
$li_et_headline_check = BaseTheme::headline_check($li_et_headline);
$li_et_event_select_option = $bst_block_fields['li_et_event_select_option'] ?? 'manual';
$li_et_select_manual_event = $bst_block_fields['li_et_select_manual_event'] ?? null;
$li_et_kicker = $bst_block_fields['li_et_kicker'] ?? null;
$li_et_button = $bst_block_fields['li_et_button'] ?? null;

// Query posts based on selection
$today = date('Ymd');

$args = array(
	'post_type'      => 'event',
	'post_status'    => 'publish',
	'posts_per_page' => 2,
	'orderby'        => 'meta_value',
	'order'          => 'ASC',
	'meta_key'       => 'li_cpt_event_start_date', 
	'meta_type'      => 'DATE',
	'meta_query'     => array(
		array(
			'key'     => 'li_cpt_event_start_date',
			'value'   => $today,
			'compare' => '>=',
			'type'    => 'DATE',
		),
	),
);

// Modify args based on selection
switch ($li_et_event_select_option) {
	case 'manual':
		if (!empty($li_et_select_manual_event)) {
			
			$args['post__in'] = $li_et_select_manual_event;
			$args['orderby'] = 'post__in';
			$args['posts_per_page'] = count($li_et_select_manual_event);
			unset($args['meta_query'], $args['meta_key'], $args['meta_type']); // Remove upcoming filter for manual
		}
		break;

	case 'most-recent':
		// already handled above
		break;
}

$events_query = new WP_Query($args);

if(!empty($li_et_headline_check) && $events_query->have_posts()): ?>
	<div id="<?php echo esc_html($bst_block_html_id); ?>" class="<?php echo esc_html($bst_var_align_class . ' ' . $bst_var_class_name . ' ' . $bst_var_name); ?> block-<?php echo esc_html($bst_block_name); ?>" style="<?php echo esc_html($bst_block_styles); ?> ">
		<div class="event-teaser-list-block">
			<div class="heading-max max-800">
				<?php echo !empty($li_et_kicker) ? '<div class="ui-eyebrow-18-16-regular block-subhead">' . esc_html($li_et_kicker) . '</div>' : ''; ?>
				<?php echo (!empty($li_et_kicker) && !empty($li_et_headline_check)) ? '<div class="gl-s12"></div>' : ''; ?>
				<?php echo !empty($li_et_headline_check) ? BaseTheme::headline($li_et_headline, 'heading-2 block-title mb-0') : ''; ?>
			</div>
	
			<?php echo (!empty($li_et_headline_check)) ? '<div class="gl-s64"></div>' : ''; ?>
	
			<div class="event-teaser-list-row">
				<?php while ($events_query->have_posts()) : $events_query->the_post(); 
					$event_id = get_the_ID();
					$title = get_the_title();
					$permalink = get_the_permalink();
					$start_date = get_field('li_cpt_event_start_date', $event_id);
					$end_date = get_field('li_cpt_event_end_date', $event_id);
					$start_time = get_field('li_cpt_event_start_time', $event_id);
					$end_time = get_field('li_cpt_event_end_time', $event_id);
					$all_day = get_field('li_cpt_event_all_day', $event_id);
					$wysiwyg = get_the_excerpt($event_id);

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
				<div class="event-teaser-list-col">
					<a href="<?php echo esc_url($permalink); ?>" class="event-teaser-list-card">
						<div class="event-teaser-list-image">
							<?php echo wp_get_attachment_image(get_post_thumbnail_id($event_id), 'thumb_800'); ?>
						</div>
						<div class="event-teaser-list-content">
	
							<?php echo (!empty($title) || !empty($wysiwyg)) ? '<div class="gl-s64"></div>' : ''; ?>

							<div class="ui-eyebrow-18-16-regular block-subhead">
								<?php echo esc_html($event_date); ?>
							</div>

							<?php echo (!empty($event_date) && !empty($title)) ? '<div class="gl-s4"></div>' : ''; ?>
							<?php echo !empty($title) ? '<h4 class="heading-4 mb-0 block-title">' . esc_html($title) . '</h4>' : ''; ?>
							<?php echo (!empty($title) && !empty($wysiwyg)) ? '<div class="gl-s16"></div>' : ''; ?>
							<?php echo !empty($wysiwyg) ? '<div class="block-content body-20-18-regular">' . html_entity_decode($wysiwyg) . '</div>' : ''; ?>
							<?php echo (!empty($wysiwyg)) ? '<div class="gl-s20"></div>' : ''; ?>
	
							<div class="block-btns">
								<div class="site-btn text-link" title="" role="Button" aria-label="Button">
									Event Details
								</div>
							</div>
							<div class="gl-s64"></div>
						</div>
					</a>
				</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
	
			<?php echo !empty($li_et_button) ? '<div class="section-btn full-width-button">' . BaseTheme::button($li_et_button, 'site-btn') . '</div>' : ''; ?>
		</div>
	</div>
<?php endif; ?>
	