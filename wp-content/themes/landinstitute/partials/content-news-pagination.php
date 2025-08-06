<?php
/**
 * Pagination partial (news)
 * Replaces manual REQUEST_URI building with get_pagenum_link() to avoid double /page/X segments.
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
$current_page = max(
    1,
    intval(
        get_query_var( 'paged' )
        ?: ( isset( $_POST['paged'] ) ? intval( $_POST['paged'] ) : 1 )
    )
);

if ( $total_pages > 1 ) : ?>
    <div class="pagination-container news-pagination-append-container">

        <!-- Desktop Pagination -->
        <div class="desktop-pages">

            <!-- Prev -->
            <?php $prev_disabled = ( $current_page === 1 ); ?>
            <div class="arrow-btn prev <?php echo $prev_disabled ? 'disabled' : ''; ?>">
                <?php if ( ! $prev_disabled ) :
                    $prev_page = $current_page - 1;
                    $prev_url  = esc_url( get_pagenum_link( $prev_page ) );
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
                        $page_url = esc_url( get_pagenum_link( $i ) );
                        $active = $i === $current_page ? ' active' : '';
                        printf(
                            '<a class="page-btn%s" href="%s" data-page="%s">%s</a>',
                            esc_attr( $active ),
                            $page_url,
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
                    $next_url  = esc_url( get_pagenum_link( $next_page ) );
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
            $prev_href = $current_page > 1 ? esc_url( get_pagenum_link( $prev_page ) ) : '#';
            $next_href = $current_page < $total_pages ? esc_url( get_pagenum_link( $next_page ) ) : '#';
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
                        $page_url = esc_url( get_pagenum_link( $i ) ); ?>
                        <a class="page-btn <?php echo $i === $current_page ? 'active' : ''; ?>" href="<?php echo $page_url; ?>" data-page="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></a>
                    <?php endfor; ?>
                </div>
                <button id="popupPrev" class="arrow-btn" data-page="<?php echo esc_attr( max( 1, $current_page - 1 ) ); ?>"></button>
                <button id="popupNext" class="arrow-btn" data-page="<?php echo esc_attr( min( $total_pages, $current_page + 1 ) ); ?>"></button>
            </div>
        </div>
    </div>
<?php endif; ?>
