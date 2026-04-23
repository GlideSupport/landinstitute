<?php
$paged       = get_query_var('paged');
$total_pages = get_query_var('total_pages');

$current_url = get_permalink();

$donor_type     = isset($_GET['donor_type']) ? sanitize_text_field($_GET['donor_type']) : '';
$donation_level = isset($_GET['donation_level']) ? sanitize_text_field($_GET['donation_level']) : '';

$query_args = [];

if ($donor_type) {
    $query_args['donor_type'] = $donor_type;
}

if ($donation_level) {
    $query_args['donation_level'] = $donation_level;
}
?>

<div class="fillter-bottom">
    <div class="pagination-container">

        <div class="desktop-pages">

            <!-- Prev -->
            <div class="arrow-btn prev">
                <a class="site-btn"
                   href="<?php
                        if ($paged > 1) {
                            $prev_url = trailingslashit($current_url) . 'page/' . ($paged - 1) . '/';
                            if (!empty($query_args)) {
                                $prev_url .= '?' . http_build_query($query_args);
                            }
                            echo esc_url($prev_url);
                        } else {
                            echo '#';
                        }
                   ?>"
                   <?php if ($paged <= 1) echo 'style="opacity:0.5;pointer-events:none;"'; ?>>
                    Previous
                </a>
            </div>

            <!-- Pages -->
            <div class="pagination-list">
                <?php
                $range     = 2;
                $show_dots = false;

                for ($i = 1; $i <= $total_pages; $i++) :

                    if ($i == 1 || $i == $total_pages || ($i >= $paged - $range && $i <= $paged + $range)) :

                        if ($show_dots) {
                            echo '<span class="dots">...</span>';
                            $show_dots = false;
                        }

                        $page_url = trailingslashit($current_url) . 'page/' . $i . '/';

                        if (!empty($query_args)) {
                            $page_url .= '?' . http_build_query($query_args);
                        }
                ?>
                        <a class="page-btn <?php echo ($i == $paged ? 'active' : ''); ?>"
                           href="<?php echo esc_url($page_url); ?>"
                           data-page="<?php echo esc_attr($i); ?>">
                            <?php echo esc_html($i); ?>
                        </a>
                <?php
                    else :
                        $show_dots = true;
                    endif;

                endfor;
                ?>
            </div>

            <!-- Next -->
            <div class="arrow-btn next">
                <a class="site-btn"
                   href="<?php
                        if ($paged < $total_pages) {
                            $next_url = trailingslashit($current_url) . 'page/' . ($paged + 1) . '/';
                            if (!empty($query_args)) {
                                $next_url .= '?' . http_build_query($query_args);
                            }
                            echo esc_url($next_url);
                        } else {
                            echo '#';
                        }
                   ?>"
                   <?php if ($paged >= $total_pages) echo 'style="opacity:0.5;pointer-events:none;"'; ?>>
                    Next
                </a>
            </div>

        </div>

    </div>
</div>