// Load more events via AJAX on button click

const loadMoreBtn = document.getElementById('load-more-events');

if (loadMoreBtn) {
  loadMoreBtn.addEventListener('click', function (e) {
    e.preventDefault(); // Prevent default button behavior

    const btn = this;
    const page = parseInt(btn.getAttribute('data-page')) + 1;

    fetch(localVars.ajax_url + '?action=load_more_events&page=' + page)
      .then(res => res.text())
      .then(html => {
        document.getElementById('event-list-main-div').insertAdjacentHTML('beforeend', html);
        btn.setAttribute('data-page', page);
      });
  });
}

let backup = 0;

jQuery(document).ready(function () {
  jQuery('.event-calendar-row').each(function () {
    // Remove previously applied row and column classes
    const columnClasses = [
      'ct-first-row', 'ct-second-row', 'ct-third-row', 'ct-forth-row', 'ct-fifth-row',
      'ct-first-col', 'ct-second-col', 'ct-third-col', 'ct-forth-col', 'ct-fifth-col',
      'ct-sixth-col', 'ct-seventh-col'
    ];
    jQuery(this).find('.calendar-column').removeClass(columnClasses.join(' '));

    const col_length = jQuery(this).find('.calendar-column').length;
    const month = jQuery(this).find('.calendar-month .heading-5').text();
    const day = new Date(`01 ${month}`).getDay(); // Get day of the week for 1st of the month

    // Prepend hidden placeholders for days before the 1st of the month
    if (day > 0) {
      for (let i = 0; i < day; i++) {
        jQuery(this).find('.calendar-days-row').prepend('<div class="calendar-column ct-hidden-items"><div class="calendar-date"> </div></div>');
      }
    }

    // Assign row and column classes to calendar columns
    jQuery(this).find('.calendar-column').each(function (ii) {
      let row_class = '';
      let col_class = '';
      let cols = 7;

      // Assign row class based on index
      if (ii < 7) row_class = 'ct-first-row';
      else if (ii < 14) row_class = 'ct-second-row';
      else if (ii < 21) row_class = 'ct-third-row';
      else if (ii < 28) row_class = 'ct-forth-row';
      else row_class = 'ct-firth-row';

      // Determine column number and class using predefined arrays
      const columnMap = {
        'ct-first-col': [1, 8, 15, 22, 29],
        'ct-second-col': [2, 9, 16, 23, 30],
        'ct-third-col': [3, 10, 17, 24, 31],
        'ct-forth-col': [4, 11, 18, 25, 32],
        'ct-fifth-col': [5, 12, 19, 26, 33],
        'ct-sixth-col': [6, 13, 20, 27, 34],
        'ct-seventh-col': [7, 14, 21, 28, 35],
      };

      let col_number = 0;

      for (const [className, indices] of Object.entries(columnMap)) {
        if (jQuery.inArray(ii + 1, indices) !== -1) {
          col_class = className;
          col_number = parseInt(className.match(/\d/)) || 0;
          break;
        }
      }

      // Apply row/column class and data attributes to event
      jQuery(this).find('.calendar-event')
        .attr('data-position', col_number)
        .attr('data-cols', cols)
        .addClass(`${col_class}-item`);

      jQuery(this).addClass(row_class).addClass(col_class);
    });
  });
});

// Toggle tooltip visibility when clicking on a calendar column
jQuery(document).on('click', '.calendar-column', function () {
  jQuery(this).find('.tooltip').toggle();
});

// Close tooltip on close button click
jQuery(document).on('click', '.close-event-btn', function () {
  jQuery(this).parent('.tooltip').hide();
});
