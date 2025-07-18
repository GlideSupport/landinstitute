<?php


// Use passed custom query or fallback to global
$custom_query  = isset( $search_query ) ? $search_query : $wp_query;
$total_pages   = $custom_query->max_num_pages;


$current_page  = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
if ( isset( $paged_var ) && $paged_var > 0 ) {
    $current_page = (int) $paged_var;
}
?>

<div class="pagination-container append-search-result-pagination">
    <?php if ( $total_pages > 1 ) : ?>

    <!-- Desktop Pagination -->
    <div class="desktop-pages">
        <div class="arrow-btn prev">
            <?php if ( $current_page > 1 ) : ?>
                <a rel="prev" class="site-btn" data-page="<?php echo esc_attr( $current_page - 1 ); ?>" href="<?php echo esc_url( get_pagenum_link( $current_page - 1 ) ); ?>">
                    <?php esc_html_e( 'Previous', 'land_institute' ); ?>
                </a>
            <?php else : ?>
                <div class="site-btn disabled"><?php esc_html_e( 'Previous', 'land_institute' ); ?></div>
            <?php endif; ?>
        </div>

        <div class="pagination-list">
            <?php
            $range     = 2;
            $show_dots = true;
for ( $i = 1; $i <= $total_pages; $i++ ) {
    if ( $i == 1 || $i == $total_pages || ( $i >= $current_page - $range && $i <= $current_page + $range ) ) {
        
        // Set rel attribute conditionally
        $rel = '';
        if ( $i == $current_page - 1 ) {
            $rel = 'prev';
        } elseif ( $i == $current_page + 1 ) {
            $rel = 'next';
        }

        if ( $i == $current_page ) {
            echo '<button class="page-btn active">' . esc_html( $i ) . '</button>';
        } else {
            echo '<a href="' . esc_url( get_pagenum_link( $i ) ) . '" data-page="' . esc_attr( $i ) . '" class="page-btn"' . ( $rel ? ' rel="' . esc_attr( $rel ) . '"' : '' ) . '>' . esc_html( $i ) . '</a>';
        }

        $show_dots = true;
    } elseif ( $show_dots ) {
        echo '<span class="dots">…</span>';
        $show_dots = false;
    }
}

            ?>
        </div>

        <div class="arrow-btn next">
            <?php if ( $current_page < $total_pages ) : ?>
                <a rel="next" class="site-btn" data-page="<?php echo esc_attr( $current_page + 1 ); ?>" href="<?php echo esc_url( get_pagenum_link( $current_page + 1 ) ); ?>">
                    <?php esc_html_e( 'Next', 'land_institute' ); ?>
                </a>
            <?php else : ?>
                <div class="site-btn disabled"><?php esc_html_e( 'Next', 'land_institute' ); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile Pagination -->
    <div class="mobile-pagination">
        <?php if ( $current_page > 1 ) : ?>
            <a id="prevBtn" rel="prev" class="arrow-btn" data-page="<?php echo esc_attr( $current_page - 1 ); ?>" href="<?php echo esc_url( get_pagenum_link( $current_page - 1 ) ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Previous" />
            </a>
        <?php else : ?>
            <div class="arrow-btn disabled">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Previous" />
            </div>
        <?php endif; ?>

        <button id="pageTrigger" class="page-trigger ui-18-16-bold">
            <?php echo esc_html( "$current_page / $total_pages" ); ?>
        </button>

        <?php if ( $current_page < $total_pages ) : ?>
            <a rel="next" id="nextBtn" class="arrow-btn" data-page="<?php echo esc_attr( $current_page + 1 ); ?>" href="<?php echo esc_url( get_pagenum_link( $current_page + 1 ) ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Next" />
            </a>
        <?php else : ?>
            <div class="arrow-btn disabled">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/right-circle-arrow.svg' ); ?>" alt="Next" />
            </div>
        <?php endif; ?>
    </div>

    <!-- Mobile Popup -->
    <div id="paginationPopup" class="pagination-popup">
        <div class="popup-body">
            <div id="popupGrid" class="popup-grid">
                <?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
                    <?php if ( $i == $current_page ) : ?>
                        <button class="page-btn active"><?php echo esc_html( $i ); ?></button>
                    <?php else : ?>
                        <a href="<?php echo esc_url( get_pagenum_link( $i ) ); ?>" data-page="<?php echo esc_attr( $i ); ?>" class="page-btn"><?php echo esc_html( $i ); ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <button id="popupPrev" class="arrow-btn"></button>
            <button id="popupNext" class="arrow-btn"></button>
        </div>
    </div>
    <?php endif; ?>

</div>
