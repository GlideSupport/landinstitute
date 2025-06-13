<?php
/**
 * Template Name: Donate
 * Template Post Type: page
 *
 * This template is for displaying donate page.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */
wp_head();
?>

<?php 
list($bst_var_post_id, $bst_fields, $bst_option_fields) = BaseTheme::defaults();

$bst_var_header_logo = $bst_option_fields['bst_var_header_logo'] ?? null;
$li_td_name = $bst_fields['li_td_name'];
$li_td_wysiwyg = $bst_fields['li_td_wysiwyg'];
$li_td_image = $bst_fields['li_td_image'];
$li_td_kicker = $bst_fields['li_td_kicker'];
$li_td_text = $bst_fields['li_td_text'];
$li_td_sub_text = $bst_fields['li_td_sub_text'];
$li_td_content = $bst_fields['li_td_content'];
?>

<section class="container-1280 bg-lime-green">
    <div class="wrapper">
        <div class="sticky-part-row">
            <div class="col-left bg-base-cream">
                <div class="gl-s36"></div>
                <div class="single-logo">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="site logo" title="site logo">
					<?php echo wp_get_attachment_image($bst_var_header_logo, 'admin-landscape', false, array('class' => 'site-logo')); ?>
				</a>
                </div>
                <div class="gl-s64"></div>
                <div class="donate-content">
                    <?php if ( !empty($li_td_name) ) : ?>
                        <h3 class="heading-3 block-title mb-0"><?php echo esc_html($li_td_name); ?></h3>
                        <div class="gl-s20"></div>
                    <?php endif; ?>
                    <?php if ( !empty($li_td_wysiwyg) ) : ?>
                        <div class="body-18-16-regular block-content">
                            <?php echo html_entity_decode($li_td_wysiwyg); ?> 
                        </div>
                        <div class="gl-s44"></div>
                    <?php endif; ?>
                    <div class="donate-form">
                        <script src="https://raisedonorsprod.azureedge.net/embed/embed.js"
                            data-rd="82f05fbf-c026-42c8-ad6d-015f2d9bcba3" data-organizationId="41634">
                        </script>
                    </div>
                    <div class="gl-s80"></div>
                    <div class="card-arrow-links">
                        <div class="ui-18-16-bold-uc block-subhead">Other Ways to Give</div>
                        <div class="gl-s8"></div>
                        <div class="card-pdf-list">
                            <a href="#" class="card-item">
                                <div class="card-item-left">
                                    <div class="card-title ui-20-18-bold">Legacy Giving</div>
                                </div>
                                <div class="card-item-right">
                                    <div class="dot-btn">
                                        <img src="../assets/src/images/right-circle-arrow.svg">
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="card-item">
                                <div class="card-item-left">
                                    <div class="card-title ui-20-18-bold">Donor Advised Fund</div>
                                </div>
                                <div class="card-item-right">
                                    <div class="dot-btn">
                                        <img src="../assets/src/images/right-circle-arrow.svg">
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="card-item">
                                <div class="card-item-left">
                                    <div class="card-title ui-20-18-bold">More Ways to Give</div>
                                </div>
                                <div class="card-item-right">
                                    <div class="dot-btn">
                                        <img src="../assets/src/images/right-circle-arrow.svg">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="gl-s80"></div>
            </div>
            <div class="col-right">
                <div class="top-sticky-parent">
                    <div class="top-sticky-top-touch">
                        <?php if ( !empty($li_td_image) || !empty($li_td_kicker) || !empty($li_td_text) || !empty($li_td_sub_text) || !empty($li_td_content) ) : ?>
                            <div class="donate-group">
                                <?php if ( !empty($li_td_image) ) : ?>
                                    <div class="donate-image">
                                        <?php echo wp_get_attachment_image($li_td_image, 'thumb_400', false); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="lbs-block">
                                    <div class="gl-s30"></div>
                                    <div class="gl-s128"></div>
                                    <?php if ( !empty($li_td_kicker) ) : ?>
                                        <div class="ui-18-16-bold-uc blocksubhead"><?php echo esc_html($li_td_kicker); ?></div>
                                        <div class="gl-s20"></div>
                                    <?php endif; ?>

                                    <?php if ( !empty($li_td_text) ) : ?>
                                        <div class="ui-72-52-bold block-title"><?php echo esc_html($li_td_text); ?></div>
                                    <?php endif; ?>

                                    <?php if ( !empty($li_td_sub_text) ) : ?>
                                        <div class="ui-20-18-bold lbs-sub"><?php echo esc_html($li_td_sub_text); ?></div>
                                    <?php endif; ?>

                                    <?php if ( !empty($li_td_content) ) : ?>
                                        <div class="gl-s24"></div>
                                        <div class="body-18-16-regular block-content">
                                            <?php echo html_entity_decode($li_td_content); ?> 
                                        </div>
                                    <?php endif; ?>

                                    <div class="gl-s52"></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
