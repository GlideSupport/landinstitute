<?php
/**
 * Template part for event item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Circuit of the Americas
 * @since 1.0.0
 */
$pID=$args['event']['post_id'];
$date=$args['date'];
$color='#1b83cf';
$post_fields                   = get_fields( $pID );
$cota_cpt_event_title          =  get_the_title( $pID );
// $term_obj_list = get_the_terms( $pID, 'event-cat' );
// if ($term_obj_list ) {
// 	$term = $term_obj_list[0];
// 	if ( get_field( 'cota_term_event_cat_color', $term->taxonomy . '_' . $term->term_id ) ) {
// 		$color = get_field( 'cota_term_event_cat_color', $term->taxonomy . '_' . $term->term_id );
// 	}
// }

$permalink= array(
	'url'=>get_the_permalink($pID),
	'title'=>'Detail',
	'target'=>''
);
$cota_cpt_event_btn_des         = ( isset( $post_fields['cota_cpt_event_btn_des'] ) ) ? $post_fields['cota_cpt_event_btn_des'] : 'normal';
$cota_cpt_event_button         = ( isset( $post_fields['cota_cpt_event_button'] ) && $post_fields['cota_cpt_event_button']!='' ) ? $post_fields['cota_cpt_event_button'] : $permalink;
$cota_cpt_event_external_links         = ( isset( $post_fields['cota_cpt_event_external_links'] ) ) ? $post_fields['cota_cpt_event_external_links'] : 'normal';

$cota_cpt_event_start_date     = $post_fields['li_cpt_event_start_date'];
$cota_cpt_event_end_date       = $post_fields['li_cpt_event_end_date'];
$final_date                    = date_formatting( $cota_cpt_event_start_date, $cota_cpt_event_end_date );
$src                           = wp_get_attachment_image_url( get_post_thumbnail_id( $pID ), 'thumb_300' );
if ( ! has_post_thumbnail() ) {
	$src = esc_url( get_template_directory_uri() ) . '/assets/img/admin/defaults/default-image.webp';
} else {
	$src = $src;
}
?>
<div class="tooltip-inner">
	<div class="tooltip-items">
		<span class="close-event-btn"><img
				src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/img/event-close-icon.svg">
		</span>
		<div class="tooltip-item tooltip-image">
			<a href="<?php if($cota_cpt_event_external_links == "true") {  echo $cota_cpt_event_button['url']; ?>" target="_blank <?php } else {  echo get_the_permalink($pID); } ?>">
				<img height="200" width="200" src="<?php echo $src; ?>" alt="image">
			</a>
		</div>
		<div class="tooltip-item tooltip-content">
			<div class="tooltip-tags">
				<div class="tooltip-heading">
					<a href="<?php if($cota_cpt_event_external_links == "true") {  echo $cota_cpt_event_button['url']; ?>" target="_blank <?php } else {  echo get_the_permalink($pID); } ?>"><?php echo $cota_cpt_event_title; ?></a>
				</div>
				<div class="tooltip-date">
					<a href="<?php if($cota_cpt_event_external_links == "true") {  echo $cota_cpt_event_button['url']; ?>" target="_blank <?php } else {  echo get_the_permalink($pID); } ?>"><?php echo $final_date; ?></a>
				</div>
				<a href="<?php if($cota_cpt_event_external_links == "true") {  echo $cota_cpt_event_button['url']; ?>" target="_blank <?php } else {  echo get_the_permalink($pID); } ?>" class="button <?php if($cota_cpt_event_btn_des=='gray'){ echo 'gray-btn';  } ?>">
					<?php if($cota_cpt_event_btn_des=='normal'){ ?>
						<span class="reset-bg" style="background-image: url(<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/ticket-icon.svg);"></span>
						<?php } ?>
						<?php echo $cota_cpt_event_button['title']; ?>
				</a>
			</div>
		</div>
	</div>
</div>
