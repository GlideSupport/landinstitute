<?php
/**
 * Template part for event item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Circuit of the Americas
 * @since 1.0.0
 */
$pID = $args['event']['post_id'];
$length = $args['event']['length'];
$current_length = $args['event']['current-length'];
$item_class = $args['item_class'];
$date = $args['date'];
$cu_day_name = date('l', strtotime($date)); // 'l' (lowercase L) gives full day name

$last_day = $args['last_day'];
$first_day = $args['first_day'];
$color = '#FDF9D0';
$post_fields = get_fields($pID);
$cota_cpt_event_title = (isset($post_fields['cota_cpt_event_title']) && $post_fields['cota_cpt_event_title'] != '') ? $post_fields['cota_cpt_event_title'] : get_the_title($pID);
//$thumbnail_url = get_the_post_thumbnail_url($pID, 'full');

$thumbnail_url = "https://landinstdev.wpenginepowered.com/wp-content/uploads/demo.webp";
if (get_the_post_thumbnail_url($pID, 'medium')) {
	$thumbnail_url = get_the_post_thumbnail_url($pID, 'medium');
}


$class = '';
if ($item_class != 'ct-not-in-view') {
	if ($current_length == 0) {
		$class = 'ct-first-day';
	}
	if ($current_length == $length) {
		$class = 'ct-last-day';
	}
}
$has_class = '';
if ($current_length < $length && $last_day == 'ct-last-day-in-month') {
	$has_class = 'ct-has-event-in-next-month';
}
?>

<div data-cudayname="<?php echo $cu_day_name; ?>" data-date="<?php echo $date; ?>" data-id="<?php echo $pID; ?>"
	data-length="<?php echo $length; ?>" data-current-length="<?php echo $current_length; ?>"
	style="background-color:<?php echo $color; ?>;"
	class="calendar-event <?php echo $item_class; ?> <?php echo $class; ?> <?php echo $last_day; ?> <?php echo $first_day; ?> <?php echo $has_class; ?>">
	<?php
	if ($current_length == 1) {
		echo '<div class="event-title-box">';
		if ($thumbnail_url) {
			echo '<img src="' . esc_url($thumbnail_url) . '" alt="" >';
		}
		echo '<div class="event-title-box" scrollamount="2">' . esc_html($cota_cpt_event_title) . '</div>';
		echo '</div>';
	} else if ($cu_day_name == "Sunday" && $current_length != 1) {
		echo '<div class="event-title-box">';
		if ($thumbnail_url) {
			echo '<img src="' . esc_url($thumbnail_url) . '" alt="" >';
		}
		echo '<div class="event-title-box" scrollamount="2">' . esc_html($cota_cpt_event_title) . '</div>';
		echo '</div>';
	} else if ($first_day) {
		echo '<div class="event-div">';
		if ($thumbnail_url) {
			echo '<img src="' . esc_url($thumbnail_url) . '" alt="" >';
		}
		echo '<div class="event-title-box" scrollamount="2">' . esc_html($cota_cpt_event_title) . '</div>';
		echo '</div>';
	} else if ($cu_day_name == "Sunday" && $current_length != 1) {
		echo '<div class="event-div">';
		if ($thumbnail_url) {
			echo '<img src="' . esc_url($thumbnail_url) . '" alt="" >';
		}
		echo '<div class="event-title-box" scrollamount="2">' . esc_html($cota_cpt_event_title) . '</div>';
		echo '</div>';
	} ?>

	<?php ?>

</div>