<?php
/**
 * Partial: content-learn-pagination.php
 * Improved pagination markup that avoids double /page/X/page/Y issues,
 * and avoids building base URL from admin-ajax.php when requests are AJAX.
 */

/* Determine current page reliably */
$current_page = intval( get_query_var( 'paged' ) );
if ( $current_page < 1 ) {
    $current_page = isset( $_POST['paged'] ) ? max( 1, intval( $_POST['paged'] ) ) : 1;
}

/* Get WP_Query passed from AJAX handler or fallback to main query */
$query = get_query_var( 'learn_query' );
if ( ! $query || ! is_a( $query, 'WP_Query' ) ) {
    global $wp_query;
    $query = $wp_query;
}

/* Ensure $paged_var is available if other code expects it */
$paged = intval( get_query_var( 'paged_var' ) ?: $current_page );

/* Total pages */
$total_pages = intval( $query->max_num_pages ?: 1 );

/**
 * Build base URL:
 * - For normal requests: use REQUEST_URI (but strip /page/X/).
 * - For AJAX requests: prefer HTTP_REFERER (the real front-end page).
 * - Always strip any /page/{num}/ from the path portion only.
 */
$scheme = is_ssl() ? 'https://' : 'http://';
$host   = isset( $_SERVER['HTTP_HOST'] ) ? wp_strip_all_tags( $_SERVER['HTTP_HOST'] ) : parse_url( home_url(), PHP_URL_HOST );
$base_url = '';

// Helper: remove /page/{num}/ from path portion
$strip_page_from_path = function( $url ) {
    $parts = wp_parse_url( $url );
    $path  = isset( $parts['path'] ) ? $parts['path'] : '/';
    $query = isset( $parts['query'] ) ? $parts['query'] : '';

    // Remove double /page/X/
    $path = preg_replace( '#/page/\d+/?#i', '/', $path );
    $path = '/' === substr( $path, 0, 1 ) ? $path : '/' . $path;

    // Strip the WP install path from REQUEST_URI so we only append relative part
    $install_path = parse_url( home_url(), PHP_URL_PATH );
    if ( $install_path && strpos( $path, $install_path ) === 0 ) {
        $path = substr( $path, strlen( $install_path ) );
    }

    // Ensure at least /
    if ( $path === '' ) {
        $path = '/';
    }

    // Rebuild URL starting from home_url()
    $base = trailingslashit( home_url( $path ) );

    if ( $query ) {
        parse_str( $query, $qargs );
        $base = add_query_arg( $qargs, $base );
    }

    return $base;
};


if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
    // Try HTTP_REFERER first (this should be the actual frontend page)
    if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
        $referer_raw = wp_unslash( $_SERVER['HTTP_REFERER'] );
        $referer_raw = esc_url_raw( $referer_raw );
        $base_url = $strip_page_from_path( $referer_raw );
    } else {
        // Fallback to using home_url + REQUEST_URI (but strip page part)
        $req_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
        $full = $scheme . $host . $req_uri;
        $base_url = $strip_page_from_path( $full );
    }
} else {
    // Non-AJAX request: use REQUEST_URI but strip /page/{num}/
    $req_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
    $full = $scheme . $host . $req_uri;
    $base_url = $strip_page_from_path( $full );
}

/* Final safeguard: if somehow base_url is empty, fallback to home_url() */
if ( empty( $base_url ) ) {
    $base_url = trailingslashit( home_url( '/' ) );
}

/* Finally ensure trailing slash and remove double slashes (except protocol) */
$base_url = trailingslashit( $base_url );
$base_url = preg_replace( '#(?<!:)//+#', '/', $base_url ); // collapse duplicate slashes
$base_url = str_replace( 'http:/', 'http://', $base_url );
$base_url = str_replace( 'https:/', 'https://', $base_url );

if ( $total_pages > 1 ) : ?>
    <div class="pagination-container learn-pagination-append-container">

        <!-- Desktop Pagination -->
        <div class="desktop-pages">
            <!-- Prev -->
            <?php $prev_disabled = ( $current_page === 1 ); ?>
            <div class="arrow-btn prev <?php echo $prev_disabled ? 'disabled' : ''; ?>">
                <?php if ( ! $prev_disabled ) :
                    $prev_page = $current_page - 1;
                    $prev_url  = $prev_page === 1 ? $base_url : trailingslashit( $base_url . 'page/' . $prev_page );
                ?>
                    <a class="site-btn" href="<?php echo esc_url( $prev_url ); ?>" rel="prev" data-page="<?php echo esc_attr( $prev_page ); ?>">Previous</a>
                <?php else : ?>
                    <span class="site-btn">Previous</span>
                <?php endif; ?>
            </div>

            <!-- Page Numbers -->
            <div class="pagination-list">
                <?php
                $range = 2;
                $dots_shown = false;
                for ( $i = 1; $i <= $total_pages; $i++ ) {
                    if ( $i === 1 || $i === $total_pages || ( $i >= $current_page - $range && $i <= $current_page + $range ) ) {
                        $page_url = $i === 1 ? $base_url : trailingslashit( $base_url . 'page/' . $i );
                        echo '<a class="page-btn' . ( $i === $current_page ? ' active' : '' ) . '" href="' . esc_url( $page_url ) . '" data-page="' . esc_attr( $i ) . '">' . esc_html( $i ) . '</a>';
                        $dots_shown = false;
                    } elseif ( ! $dots_shown ) {
                        echo '<span class="dots">...</span>';
                        $dots_shown = true;
                    }
                }
                ?>
            </div>

            <!-- Next -->
            <?php $next_disabled = ( $current_page === $total_pages ); ?>
            <div class="arrow-btn next <?php echo $next_disabled ? 'disabled' : ''; ?>">
                <?php if ( ! $next_disabled ) :
                    $next_page = $current_page + 1;
                    $next_url  = trailingslashit( $base_url . 'page/' . $next_page );
                ?>
                    <a class="site-btn" href="<?php echo esc_url( $next_url ); ?>" rel="next" data-page="<?php echo esc_attr( $next_page ); ?>">Next</a>
                <?php else : ?>
                    <span class="site-btn">Next</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Pagination -->
        <div class="mobile-pagination">
            <?php
            $prev_page = max( 1, $current_page - 1 );
            $next_page = min( $total_pages, $current_page + 1 );
            $prev_href = $current_page > 1 ? ( $prev_page === 1 ? esc_url( $base_url ) : esc_url( trailingslashit( $base_url . 'page/' . $prev_page ) ) ) : '#';
            $next_href = $current_page < $total_pages ? esc_url( trailingslashit( $base_url . 'page/' . $next_page ) ) : '#';
            ?>
            <a id="prevBtn" class="arrow-btn page-btn <?php echo $current_page === 1 ? 'disabled' : ''; ?>"
               href="<?php echo $prev_href; ?>" rel="prev" data-page="<?php echo esc_attr( $prev_page ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Previous" />
            </a>

            <span id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo esc_html( $current_page . '/' . $total_pages ); ?></span>

            <a id="nextBtn" class="arrow-btn page-btn <?php echo $current_page === $total_pages ? 'disabled' : ''; ?>"
               href="<?php echo $next_href; ?>" rel="next" data-page="<?php echo esc_attr( $next_page ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Next" />
            </a>
        </div>

        <!-- Mobile Popup -->
        <div id="paginationPopup" class="pagination-popup">
            <div class="popup-body">
                <div id="popupGrid" class="popup-grid">
                    <?php for ( $i = 1; $i <= $total_pages; $i++ ) :
                        $page_url = $i === 1 ? $base_url : trailingslashit( $base_url . 'page/' . $i );
                        ?>
                        <a class="page-btn <?php echo $i === $current_page ? 'active' : ''; ?>" href="<?php echo esc_url( $page_url ); ?>" data-page="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></a>
                    <?php endfor; ?>
                </div>

                <button id="popupPrev" class="arrow-btn" data-page="<?php echo esc_attr( max( 1, $current_page - 1 ) ); ?>"></button>
                <button id="popupNext" class="arrow-btn" data-page="<?php echo esc_attr( min( $total_pages, $current_page + 1 ) ); ?>"></button>
            </div>
        </div>
    </div>
<?php endif; ?>
