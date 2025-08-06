<?php
/**
 * Partial: content-learn-pagination.php
 * Improved pagination markup that avoids double /page/X/page/Y issues.
 */

/* Determine current page reliably */
$current_page = intval( get_query_var( 'paged' ) );
if ( $current_page < 1 ) {
    $current_page = isset( $_POST['paged'] ) ? max(1, intval( $_POST['paged'] )) : 1;
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

/* Build base URL safely.
   We avoid using $_SERVER['REQUEST_URI'] unmodified (it may contain /page/N/).
   If you want the minimal patch, strip any /page/{num}/ part from REQUEST_URI.
*/
$scheme = is_ssl() ? 'https://' : 'http://';
$host   = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : parse_url( home_url(), PHP_URL_HOST );

// Use REQUEST_URI but remove any /page/{num}/ segment (the minimal change)
$req_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
$base_url = $scheme . $host . $req_uri;

/* Strip existing /page/<num>/ from base URL to prevent double segments */
$base_url = preg_replace( '#/page/\d+/?#i', '/', $base_url );
$base_url = trailingslashit( $base_url );

/* If somehow base_url is empty fallback to home_url() */
if ( empty( $base_url ) ) {
    $base_url = trailingslashit( home_url( '/' ) );
}

if ( $total_pages > 1 ) : ?>
    <div class="pagination-container learn-pagination-append-container">

        <!-- Desktop Pagination -->
        <div class="desktop-pages">
            <!-- Prev -->
            <?php $prev_disabled = ( $current_page === 1 ); ?>
            <div class="arrow-btn prev <?php echo $prev_disabled ? 'disabled' : ''; ?>">
                <?php if ( ! $prev_disabled ) : 
                    $prev_page = $current_page - 1;
                    $prev_url  = esc_url( $prev_page === 1 ? $base_url : $base_url . 'page/' . $prev_page . '/' );
                ?>
                    <a class="site-btn" href="<?php echo $prev_url; ?>" rel="prev" data-page="<?php echo esc_attr( $prev_page ); ?>">Previous</a>
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
                        $page_url = $i === 1 ? $base_url : $base_url . 'page/' . $i . '/';
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
                    $next_url  = esc_url( $base_url . 'page/' . $next_page . '/' );
                ?>
                    <a class="site-btn" href="<?php echo $next_url; ?>" rel="next" data-page="<?php echo esc_attr( $next_page ); ?>">Next</a>
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
            $prev_href = $current_page > 1 ? ( $prev_page === 1 ? esc_url( $base_url ) : esc_url( $base_url . 'page/' . $prev_page . '/' ) ) : '#';
            $next_href = $current_page < $total_pages ? esc_url( $base_url . 'page/' . $next_page . '/' ) : '#';
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
                        $page_url = $i === 1 ? $base_url : $base_url . 'page/' . $i . '/';
                        ?>
                        <a class="page-btn <?php echo $i === $current_page ? 'active' : ''; ?>" href="<?php echo esc_url( $page_url ); ?>" data-page="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></a>
                    <?php endfor; ?>
                </div>

                <button id="popupPrev" class="arrow-btn" data-page="<?php echo esc_attr( max(1, $current_page - 1) ); ?>"></button>
                <button id="popupNext" class="arrow-btn" data-page="<?php echo esc_attr( min($total_pages, $current_page + 1) ); ?>"></button>
            </div>
        </div>
    </div>
<?php endif; ?>
