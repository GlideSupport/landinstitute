<?php

/**
 * Template part for displaying single staff details
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

list($bst_var_post_id, $bst_fields, $bst_option_fields, $bst_queried_object) = BaseTheme::defaults();

// Post Tags & Categories.
$bst_var_staff_title = $bst_fields['bst_var_posttitle'] ?? get_the_title();
$staff_description = get_the_content();
$bst_var_post_categories = get_categories($bst_var_post_id);
$staff_designation = get_field('staff_designation', $bst_var_post_id);
$staff_email = get_field('staff_email_address', $bst_var_post_id);





?>
<section class="container-1280">
	<div class="wrapper">
		<div class="staff-detail-layout bg-lilac">
			<div class="row-flex">
				<div class="col-left">
					<div class="sticky-block">
						<div class="back-btn">
							<a class="site-btn arrow-pointing-left btn-lilac" href="/staff-directory/" title="" role="Button"
								aria-label="Button">Back to All Staff
							</a>
						</div>
						<div class="staff-image">
							<?php
							if (! has_post_thumbnail($bst_var_post_id)) {
								echo '<img class="" src="' . esc_url(get_template_directory_uri()) . '/assets/build/images/admin/defaults/default-avatar.webp" >';
							} else {
								echo get_the_post_thumbnail($bst_var_post_id, 'thumb_900',);
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-right">
					<div class="gl-s80"></div>
					<h1 class="block-title heading-1 mb-0">
						<?php echo esc_html($bst_var_staff_title); ?>
					</h1>
					<div class="gl-s12"></div>
					<?php if ($staff_designation): ?>
						<div class="ui-eyebrow-18-16-regular sub-head">
							<?php echo html_entity_decode($staff_designation); ?>
						</div>
					<?php endif; ?>

					<?php if ($staff_description): ?>
						<div class="gl-s52"></div>
						<h3 class="block-inner-heading heading-3 mb-0">Bio</h3>
						<div class="gl-s16"></div>
						<div class="block-content body-20-18-regular">
							<?php echo $staff_description; ?>
						</div>
					<?php endif; ?>

					<?php if ($staff_email): ?>
						<h3 class="block-inner-heading heading-3 mb-0">Contact Info</h3>
						<div class="gl-s16"></div>
						<div class="user-info body-20-18-regular">
							<span>Email:</span>
							<a
								href="mailto:<?php echo html_entity_decode($staff_email); ?>">
								<?php echo html_entity_decode($staff_email); ?>
							</a>
						</div>
						<div class="gl-s52"></div>
					<?php endif; ?>

					<?php get_template_part('partials/content'); ?>


					<div class="gl-s64"></div>
				</div>
			</div>
		</div>
	</div>
</section>