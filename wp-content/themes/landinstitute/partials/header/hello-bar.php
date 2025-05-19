<?php if (!empty($bst_var_tbar_vsblty) && $base_theme_option_global_manual == 'global') {
    if (!empty($bst_var_hb_content)) { ?>
        <div class="top-bar center-align global" id="top-bar-ajax" data-cookie-days="<?php echo esc_attr($cookie_days); ?>"
            <?php echo isset($_COOKIE['helloBarClosed']) ? 'style="display: none;"' : ''; ?>>
            <div class="wrapper">
                <div class="top-bar-text ui-label-s-light white_text">
                    <?php
                    if (!empty($bst_var_hb_content)):
                        echo wp_kses_post(html_entity_decode($bst_var_hb_content));
                    endif;
                    ?>
                </div>
            </div>
            <div class="top-bar-cross" role="button" tabindex="0"
                aria-label="<?php esc_attr_e('Close top bar', 'land_institute'); ?>" aria-pressed="false">
                <span>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/src/images/topbar-cross-icon.svg'); ?>"
                        width="16" height="16" alt="<?php esc_attr_e('Top bar', 'land_institute'); ?>">
                </span>
            </div>
        </div>
    <?php }
} elseif ($base_theme_option_global_manual == 'manual') {
    if (!empty($base_theme_option_content)) { ?>
        <div class="top-bar manual" id="top-bar-ajax" data-cookie-days="<?php echo esc_attr($cookie_days); ?>" <?php echo isset($_COOKIE['helloBarClosed']) ? 'style="display: none;"' : ''; ?>>
            <div class="wrapper">
                <div class="top-bar-text ui-label-s-light white_text">
                    <?php
                    if (!empty($base_theme_option_content)):
                        echo wp_kses_post(html_entity_decode($base_theme_option_content));
                    endif;?>
                </div>
            </div>
            <div class="top-bar-cross" role="button" tabindex="0"
                aria-label="<?php esc_attr_e('Close top bar', 'land_institute'); ?>" aria-pressed="false">
                <span>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/src/images/topbar-cross-icon.svg'); ?>"
                        width="16" height="16" alt="<?php esc_attr_e('Top bar', 'land_institute'); ?>">
                </span>
            </div>
        </div>
    <?php }
} ?>