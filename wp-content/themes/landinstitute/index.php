<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

get_header();
	list( $bst_var_post_id, $bst_fields, $bst_option_fields,$bst_query_object ) = BaseTheme::defaults();

?>

<section id="page-section" class="page-section">
	<div class="wrapper">
		<div class="<?php BaseTheme::have_post_class( 'three-columns' ); ?>">
			<!-- Content Start -->
			<?php $bst_query = BaseTheme::query(); ?>
			<div class="ts-80"></div>
			<!-- Content End -->
		</div>
	</div>
</section>
<?php get_footer(); ?>
