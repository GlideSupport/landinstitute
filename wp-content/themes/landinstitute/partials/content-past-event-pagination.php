<?php
$paged       = get_query_var('paged');
$total_pages = get_query_var('total_pages');
?>

<div class="pagination-container pagination-append-container">
    <div class="pagination-container">

        <!-- Desktop -->
        <div class="desktop-pages">

            <?php
            $prev_page     = $paged - 1;
            $prev_disabled = $paged <= 1;

            $prev_url = $prev_disabled
                ? 'javascript:void(0);'
                : ($prev_page === 1
                    ? trailingslashit(home_url('/events/'))
                    : trailingslashit(home_url('/events/')) . 'page/' . $prev_page . '/'
                );
            ?>

            <a class="arrow-btn prev page-btn <?php echo $prev_disabled ? 'disabled' : ''; ?>"
               href="<?php echo esc_url($prev_url); ?>"
               data-page="<?php echo esc_attr($prev_page); ?>">

                <div class="site-btn">Previous</div>
            </a>

            <!-- Numbers -->
            <div class="pagination-list">
                <?php
                $range     = 2;
                $show_dots = false;

                for ($i = 1; $i <= $total_pages; $i++) :

                    if ($i === 1 || $i === $total_pages || ($i >= $paged - $range && $i <= $paged + $range)) :

                        if ($show_dots) {
                            echo '<span class="dots">...</span>';
                            $show_dots = false;
                        }

                        $page_url = ($i === 1)
                            ? trailingslashit(home_url('/events/'))
                            : trailingslashit(home_url('/events/')) . 'page/' . $i . '/';
                ?>
                        <a class="page-btn <?php echo ($i === $paged ? 'active' : ''); ?>"
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

            <?php
            $next_page     = $paged + 1;
            $next_disabled = $paged >= $total_pages;

            $next_url = $next_disabled
                ? 'javascript:void(0);'
                : trailingslashit(home_url('/events/')) . 'page/' . $next_page . '/';
            ?>

            <a class="arrow-btn next page-btn <?php echo $next_disabled ? 'disabled' : ''; ?>"
               href="<?php echo esc_url($next_url); ?>"
               data-page="<?php echo esc_attr($next_page); ?>">

                <div class="site-btn">Next</div>
            </a>

        </div>

    </div>
</div>