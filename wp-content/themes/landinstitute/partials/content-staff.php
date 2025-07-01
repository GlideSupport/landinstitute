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

$staff_title        = $bst_fields['bst_var_posttitle'] ?? get_the_title();
$staff_bio          = get_the_content();
$staff_designation  = get_field('staff_designation', $bst_var_post_id);
$staff_email        = get_field('staff_email_address', $bst_var_post_id);
?>

<div id="page-section" class="page-section">
	<section id="hero-section" class="hero-section hero-section-default hero-text-only">
		<div class="bg-pattern">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/src/images/tli-pattern-Dandelion-Lilac-scaledbg.jpg" alt="Background Pattern" />
		</div>
	</section>

	<section class="container-1280">
		<div class="wrapper">
			<div class="staff-detail-layout bg-lilac">
				<div class="row-flex">

					<!-- Left Column -->
					<div class="col-left">
						<div class="sticky-parent">
							<div class="sticky-top-touch">

								<div class="back-btn">
									<a class="site-btn arrow-pointing-left btn-lilac" href="/about-us/staff/" role="button" aria-label="Back to All Staff">
										Back to All Staff
									</a>
								</div>

								<div class="staff-image">
									<?php
									if (has_post_thumbnail($bst_var_post_id)) {
										echo get_the_post_thumbnail($bst_var_post_id, 'thumb_900');
									} else {
										echo '<img src="' . esc_url(get_template_directory_uri()) . '/assets/build/images/admin/defaults/default-avatar.webp" alt="Default Avatar">';
									}
									?>
								</div>

							</div>
						</div>
					</div>

					<!-- Right Column -->
					<div class="col-right">
						<div class="gl-s80"></div>

						<h1 class="block-title heading-1 mb-0"><?php echo esc_html($staff_title); ?></h1>

						<?php if (!empty($staff_designation)) : ?>
							<div class="gl-s12"></div>
							<div class="ui-eyebrow-18-16-regular sub-head">
								<?php echo esc_html($staff_designation); ?>
							</div>
						<?php endif; ?>

						<?php if (!empty($staff_bio)) : ?>
							<div class="gl-s52"></div>
							<h3 class="block-inner-heading heading-3 mb-0">Bio</h3>
							<div class="gl-s16"></div>
							<div class="block-content body-20-18-regular">
								<?php get_template_part('partials/content'); ?>
							</div>
						<?php else: ?>
							<div class="gl-s200"></div>
						<?php endif; ?>

						<div class="gl-s64"></div>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>