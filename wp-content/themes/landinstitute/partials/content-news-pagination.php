<?php
/**
 * Pagination partial (news)
 * Builds frontend pagination links (e.g. /news/page/4/) even when called via AJAX.
 */

/* Resolve the query object (supports $news passed in or fallback) */
$news_query = ( isset( $news ) && $news instanceof WP_Query ) ? $news : get_query_var( 'news_query' );
if ( ! $news_query || ! ( $news_query instanceof WP_Query ) ) {
    global $wp_query;
    $news_query = $wp_query;
}

/* Total pages */
$total_pages = max( 1, intval( $news_query->max_num_pages ) );

/* Current page: prefer query var, then POST (AJAX), otherwise 1 */
$current_page = intval( get_query_var( 'paged' ) );
if ( $current_page < 1 ) {
    $current_page = isset( $_POST['paged'] ) ? max( 1, intval( $_POST['paged'] ) ) : 1;
}

/**
 * Get a sane front-end base URL for the news listing.
 * Strategy:
 * 1) If AJAX, prefer HTTP_REFERER (strip any /page/X/).
 * 2) Try post type archive link for 'news' (if it's a CPT archive).
 * 3) Try a page with slug 'news'.
 * 4) Fall back to home_url('/news/').
 */
$get_news_base = function() {
    // Helper: strip /page/{num}/ from a URL path
    $strip_page = function( $url ) {
        $parts = wp_parse_url( $url );
        $path  = isset( $parts['path'] ) ? $parts['path'] : '/';
        $path  = preg_replace( '#/page/\d+/?#i', '/', $path );
        $path  = '/' === substr( $path, 0, 1 ) ? $path : '/' . $path;

        // Ensure path is relative to home_url
        $install_path = parse_url( home_url(), PHP_URL_PATH );
        if ( $install_path && strpos( $path, $install_path ) === 0 ) {
            $path = substr( $path, strlen( $install_path ) );
        }

        $base = trailingslashit( home_url( $path ) );
        if ( isset( $parts['query'] ) && $parts['query'] ) {
            parse_str( $parts['query'], $qargs );
            $base = add_query_arg( $qargs, $base );
        }
        return $base;
    };

    // 1) If doing AJAX, prefer referer
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX && ! empty( $_SERVER['HTTP_REFERER'] ) ) {
        $referer = esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) );
        if ( $referer ) {
            return $strip_page( $referer );
        }
    }

    // 2) Try post type archive for 'news' (if registered)
    if ( post_type_archive_title( '', false ) ) {
        // If 'news' is the current queried post type archive, get archive link for news.
        if ( post_type_exists( 'news' ) ) {
            $archive = get_post_type_archive_link( 'news' );
            if ( $archive ) {
                return trailingslashit( $archive );
            }
        }
    }

    // 3) Try to find a page with slug 'news'
    $news_page = get_page_by_path( 'news' );
    if ( $news_page ) {
        return trailingslashit( get_permalink( $news_page ) );
    }

    // 4) Final fallback
    return trailingslashit( home_url( '/news/' ) );
};

/**
 * Build a proper front-end page link for the news listing.
 * Returns base for page 1, or /news/page/{n}/ for other pages.
 */
$news_pagenum_link = function( $page = 1 ) use ( $get_news_base ) {
    $base = $get_news_base();
    $base = untrailingslashit( $base ); // ensure consistent formatting

    if ( intval( $page ) <= 1 ) {
        return trailingslashit( $base );
    }

    // Append page/{n}/ — ensure single slashes
    $url = trailingslashit( $base ) . 'page/' . intval( $page ) . '/';
    // Normalize double slashes (but preserve protocol)
    $url = preg_replace( '#(?<!:)//+#', '/', $url );
    $url = str_replace( 'http:/', 'http://', $url );
    $url = str_replace( 'https:/', 'https://', $url );

    return $url;
};

if ( $total_pages > 1 ) : ?>
    <div class="pagination-container news-pagination-append-container">

        <!-- Desktop Pagination -->
        <div class="desktop-pages">

            <!-- Prev -->
            <?php $prev_disabled = ( $current_page === 1 ); ?>
            <div class="arrow-btn prev <?php echo $prev_disabled ? 'disabled' : ''; ?>">
                <?php if ( ! $prev_disabled ) :
                    $prev_page = $current_page - 1;
                    $prev_url  = $news_pagenum_link( $prev_page );
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
                        $page_url = $news_pagenum_link( $i );
                        $active = $i === $current_page ? ' active' : '';
                        printf(
                            '<a class="page-btn%s" href="%s" data-page="%s">%s</a>',
                            esc_attr( $active ),
                            esc_url( $page_url ),
                            esc_attr( $i ),
                            esc_html( $i )
                        );
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
                    $next_url  = $news_pagenum_link( $next_page );
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
            $prev_href = $current_page > 1 ? $news_pagenum_link( $prev_page ) : '#';
            $next_href = $current_page < $total_pages ? $news_pagenum_link( $next_page ) : '#';
            ?>
            <a id="prevBtn" class="arrow-btn page-btn <?php echo $current_page === 1 ? 'disabled' : ''; ?>"
               href="<?php echo esc_url( $prev_href ); ?>" rel="prev" data-page="<?php echo esc_attr( $prev_page ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Previous" />
            </a>

            <span id="pageTrigger" class="page-trigger ui-18-16-bold"><?php echo esc_html( $current_page . '/' . $total_pages ); ?></span>

            <a id="nextBtn" class="arrow-btn page-btn <?php echo $current_page === $total_pages ? 'disabled' : ''; ?>"
               href="<?php echo esc_url( $next_href ); ?>" rel="next" data-page="<?php echo esc_attr( $next_page ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Next" />
            </a>
        </div>

        <!-- Mobile Popup -->
        <div id="paginationPopup" class="pagination-popup">
            <div class="popup-body">
                <div id="popupGrid" class="popup-grid">
                    <?php for ( $i = 1; $i <= $total_pages; $i++ ) :
                        $page_url = $news_pagenum_link( $i ); ?>
                        <a class="page-btn <?php echo $i === $current_page ? 'active' : ''; ?>" href="<?php echo esc_url( $page_url ); ?>" data-page="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></a>
                    <?php endfor; ?>
                </div>
                <button id="popupPrev" class="arrow-btn" data-page="<?php echo esc_attr( max( 1, $current_page - 1 ) ); ?>"></button>
                <button id="popupNext" class="arrow-btn" data-page="<?php echo esc_attr( min( $total_pages, $current_page + 1 ) ); ?>"></button>
            </div>
        </div>
    </div>
<?php endif; ?>
