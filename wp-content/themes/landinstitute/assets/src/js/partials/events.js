// Load more events via AJAX on button click
const loadMoreBtn = document.getElementById('load-more-events');

if (loadMoreBtn) {
  loadMoreBtn.addEventListener('click', function (e) {
    e.preventDefault();

    const btn = this;
    let page = parseInt(btn.getAttribute('data-page'));
    const eventList = document.getElementById('event-list-main-div');

    const originalText = btn.innerHTML;
    btn.innerHTML = 'Loading...';
    btn.disabled = true;
    eventList.classList.add('loading');

    fetch(localVars.ajax_url + '?action=load_more_events&page=' + page)
      .then(res => res.json())
      .then(data => {
        if (data.success && data.html) {
          eventList.insertAdjacentHTML('beforeend', data.html);

          if (data.has_more) {
            btn.setAttribute('data-page', data.next_page);
            btn.innerHTML = originalText;
            btn.disabled = false;
          } else {
            //btn.innerHTML = 'No more events';
            btn.classList.add('disabled');
            btn.disabled = true;
          }
        } else {
          //btn.innerHTML = 'No more events';
          btn.classList.add('disabled');
          btn.disabled = true;
        }
      })
      .catch(() => {
        btn.innerHTML = 'Try again';
        btn.disabled = false;
      })
      .finally(() => {
        eventList.classList.remove('loading');
      });
  });
}


let backup = 0;

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.event-calendar-row').forEach(function (row) {
    // Remove previously applied row and column classes
    const columnClasses = [
      'ct-first-row', 'ct-second-row', 'ct-third-row', 'ct-forth-row', 'ct-fifth-row',
      'ct-first-col', 'ct-second-col', 'ct-third-col', 'ct-forth-col', 'ct-fifth-col',
      'ct-sixth-col', 'ct-seventh-col'
    ];
    row.querySelectorAll('.calendar-column').forEach(function (col) {
      columnClasses.forEach(cls => col.classList.remove(cls));
    });

    const columns = row.querySelectorAll('.calendar-column');
    const monthEl = row.querySelector('.calendar-month .heading-5');
    const month = monthEl ? monthEl.textContent : '';
    const day = new Date(`01 ${month}`).getDay(); // day of the week for 1st

    // Prepend hidden placeholders for days before the 1st of the month
    if (day > 0) {
      const daysRow = row.querySelector('.calendar-days-row');
      for (let i = 0; i < day; i++) {
        const div = document.createElement('div');
        div.className = 'calendar-column ct-hidden-items';
        div.innerHTML = '<div class="calendar-date"> </div>';
        if (daysRow) {
          daysRow.insertBefore(div, daysRow.firstChild);
        }
      }
    }

    // Assign row and column classes
    row.querySelectorAll('.calendar-column').forEach(function (col, ii) {
      let rowClass = '';
      if (ii < 7) rowClass = 'ct-first-row';
      else if (ii < 14) rowClass = 'ct-second-row';
      else if (ii < 21) rowClass = 'ct-third-row';
      else if (ii < 28) rowClass = 'ct-forth-row';
      else rowClass = 'ct-fifth-row';

      const columnMap = {
        'ct-first-col': [1, 8, 15, 22, 29],
        'ct-second-col': [2, 9, 16, 23, 30],
        'ct-third-col': [3, 10, 17, 24, 31],
        'ct-forth-col': [4, 11, 18, 25, 32],
        'ct-fifth-col': [5, 12, 19, 26, 33],
        'ct-sixth-col': [6, 13, 20, 27, 34],
        'ct-seventh-col': [7, 14, 21, 28, 35],
      };

      let colClass = '';
      let colNumber = 0;

      for (const [className, indices] of Object.entries(columnMap)) {
        if (indices.includes(ii + 1)) {
          colClass = className;
          colNumber = parseInt(className.match(/\d/)) || 0;
          break;
        }
      }

      // Add data and class to event inside the column
      const event = col.querySelector('.calendar-event');
      if (event) {
        event.setAttribute('data-position', colNumber);
        event.setAttribute('data-cols', 7);
       // event.classList.add(`${colClass}-item`);
       if (colClass) event.classList.add(`${colClass}-item`);

      }

      //col.classList.add(rowClass, colClass);
      if (rowClass) col.classList.add(rowClass);
      if (colClass) col.classList.add(colClass);

    });
  });
});


// Toggle tooltip visibility on calendar column click
document.addEventListener('click', function (e) {
  // Check if the close button (or its child) was clicked
  const closeBtn = e.target.closest('.close-event-btn');
  if (closeBtn) {
    const tooltip = closeBtn.closest('.tooltip');
    if (tooltip) {
      tooltip.classList.remove('show');

      // Wait for animation to finish before cleanup
      setTimeout(() => {
        document.documentElement.classList.remove('popup-overflow');
      }, 400); // Match CSS transition duration
    }
    return;
  }

  // Handle tooltip open
  const calendarColumn = e.target.closest('.calendar-column');
  if (calendarColumn) {
    // Hide all tooltips
    document.querySelectorAll('.tooltip.show').forEach(function (tooltip) {
      tooltip.classList.remove('show');
    });

    // Show current tooltip
    const tooltip = calendarColumn.querySelector('.tooltip');
    if (tooltip) {
      tooltip.classList.add('show');
      document.documentElement.classList.add('popup-overflow');
    }
  }
});


// scrol event
document.addEventListener('DOMContentLoaded', function () {
  // Check if the URL path contains /page/X/
  var match = window.location.pathname.match(/\/page\/(\d+)\//);
  var currentPage = match ? parseInt(match[1]) : 1;

  // If current page > 1, scroll to the element with class .pastevent
  if (currentPage > 1) {
      var pastevent = document.querySelector('.pastevent');
      if (pastevent) {
          window.scrollTo({
              top: pastevent.offsetTop,
              behavior: 'smooth'
          });
      }
  }
});
