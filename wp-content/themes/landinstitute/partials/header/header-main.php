<header id="header-section" class="header-section">
    <?php include get_template_directory() . '/partials/header/hello-bar.php'; ?>

    <div class="header-wrapper header-inner d-flex align-items-center justify-content-between">
        <div class="header-logo logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="site logo" title="site logo">
                <?php echo wp_get_attachment_image($bst_var_header_logo, 'admin-landscape', false, array('class' => 'site-logo')); ?>
            </a>
        </div>
        <div class="right-header header-navigation">
            <div class="nav-overlay">
                <div class="nav-container" role="navigation">
                    <nav class="header-nav">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'header-nav',
                                'fallback_cb' => 'BaseTheme::nav_fallback',
                            )
                        );
                        ?>
                    </nav>
                    <?php if ($bst_var_tohdr_btn) { ?>
                        <div class="header-btns desktop-hide">
                            <?php
                            if ($bst_var_tohdr_btn) {
                                echo BaseTheme::button($bst_var_tohdr_btn, 'button');
                            }
                            ?>

                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="menu-btn">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
            </div>
        </div>
        <?php if ($bst_var_tohdr_btn) { ?>
            <div class="header-btns">
                <?php
                if ($bst_var_tohdr_btn) {
                    echo BaseTheme::button($bst_var_tohdr_btn, 'button');
                }
                ?>
            </div>
        <?php } ?>
        <!-- header buttons -->
    </div>
    <!-- Header End -->
</header>