document.addEventListener("DOMContentLoaded", function () {
	const donorGrid = document.querySelector(".filter-logos-row");
	let currentDonorType = "all";
	let currentDonationLevel = "all";
	let currentPage = 1;

	function fetchDonors() {
		const postsPerPage = donorGrid.dataset.donorCount || 9;
		// Loader
		// const existingLoader = donorGrid.querySelector(".ajax-loader");
        // if (!existingLoader) {
        // 	const loader = document.createElement("div");
        // 	loader.className = "ajax-loader";
        // 	loader.innerHTML = "<p>Loading Donors...</p>";
        // 	donorGrid.prepend(loader); 
        // }

		fetch(localVars.ajax_url, {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
			},
			body: new URLSearchParams({
				action: "filter_logo_grid_filter",
				nonce: localVars.nonce,
				donor_type: currentDonorType,
				donation_level: currentDonationLevel,
				paged: currentPage,
				posts_per_page: postsPerPage 
			}),
		})
			.then((res) => res.json())
			.then((data) => {
				if (data.success && data.data.html) {
					donorGrid.innerHTML = data.data.html;

					// Inject new pagination
					updatePagination(data.data.pagination_html);
				} else {
					donorGrid.innerHTML = "<p>No donors found for this filter.</p>";
				}
			})
			.catch((err) => {
				console.error("AJAX Error:", err);
				donorGrid.innerHTML = "<p>Error loading donors.</p>";
			});
	}

	function updatePagination(paginationHtml) {
		const paginationWrapper = document.querySelector(".fillter-bottom .pagination-container");
	
		if (paginationHtml.trim() === "") {
			if (paginationWrapper) paginationWrapper.remove();
			return;
		}
	
		const tempDiv = document.createElement("div");
		tempDiv.innerHTML = paginationHtml;
	
		const newPaginationContainer = tempDiv.querySelector(".pagination-container");
		if (newPaginationContainer) {
			if (paginationWrapper) {
				paginationWrapper.replaceWith(newPaginationContainer);
			} else {
				const fillterBottom = document.querySelector(".fillter-bottom");
				if (fillterBottom) {
					fillterBottom.appendChild(newPaginationContainer);
				} else {
					donorGrid.insertAdjacentElement("afterend", newPaginationContainer);
				}
			}
		}
	
		attachPaginationListeners(); // Re-bind
	}
	
    

	function attachPaginationListeners() {
		// Page number buttons
		document.querySelectorAll(".page-btn").forEach((btn) => {
			btn.addEventListener("click", function () {
				const newPage = parseInt(this.textContent);
				if (!isNaN(newPage) && newPage !== currentPage) {
					currentPage = newPage;
					fetchDonors();
				}
			});
		});

		// Desktop Prev/Next
		const prevBtn = document.querySelector(".arrow-btn.prev .site-btn");
		const nextBtn = document.querySelector(".arrow-btn.next .site-btn");

		if (prevBtn) {
			prevBtn.addEventListener("click", () => {
				if (currentPage > 1) {
					currentPage--;
					fetchDonors();
				}
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener("click", () => {
				currentPage++;
				fetchDonors();
			});
		}

		// Mobile Prev/Next
		const mobilePrev = document.getElementById("prevBtn");
		const mobileNext = document.getElementById("nextBtn");

		if (mobilePrev) {
			mobilePrev.addEventListener("click", () => {
				if (currentPage > 1) {
					currentPage--;
					fetchDonors();
				}
			});
		}

		if (mobileNext) {
			mobileNext.addEventListener("click", () => {
				currentPage++;
				fetchDonors();
			});
		}

		// Mobile popup pagination
		document.querySelectorAll("#popupGrid .page-btn").forEach((btn) => {
			btn.addEventListener("click", () => {
				const popupPage = parseInt(btn.textContent);
				if (!isNaN(popupPage)) {
					currentPage = popupPage;
					fetchDonors();
				}
			});
		});
	}

	// Dropdown item click handler
	document.querySelectorAll(".dropdown-menu").forEach((menu) => {
		menu.querySelectorAll("a[data-term]").forEach((link) => {
			link.addEventListener("click", (e) => {
				e.preventDefault();
				const taxonomy = menu.id; // donor-type or donation-level
				const term = link.getAttribute("data-term");

				// Remove 'active' class from siblings
				menu.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
				link.closest("li").classList.add("active");

				// Set selected term
				if (taxonomy === "donor-type") {
					currentDonorType = term;
					document.querySelector("button#donor-type").innerHTML =
						"Donor type: " + (term === "all" ? "All types" : term.replace(/-/g, " "));
				} else if (taxonomy === "donation-level") {
					currentDonationLevel = term;
					document.querySelector("button#donation-level").innerHTML =
						"Donation level: " + (term === "all" ? "All levels" : term.replace(/-/g, " "));
				}

				// Reset to page 1
				currentPage = 1;
				fetchDonors();
			});
		});
	});

	// Optional: Initial pagination listeners if needed
	attachPaginationListeners();


	
// Past Event Filter JS Code Start
const pastEventLinks = document.querySelectorAll(".past-events-ctn a[data-term]");
const teaserList = document.querySelector(".filter-content-cards-grid");
let currentTerm = "all";


function fetchPastEvents(term = "all", paged = 1) {
 currentTerm = term;
 currentPage = paged;

 if (teaserList) {
  loadingElem = document.createElement("div");
  loadingElem.className = "loading-placeholder";
  loadingElem.innerHTML = "<p>Loading...</p>";
  teaserList.appendChild(loadingElem);
 }

 fetch(localVars.ajax_url, {
  method: "POST",
  headers: {
   "Content-Type": "application/x-www-form-urlencoded",
  },
  body: new URLSearchParams({
   action: "filter_past_events",
   paged: paged,
   nonce: localVars.nonce,
  }),
 })
  .then((res) => res.json())
  .then((data) => {
   if (data.success) {
	if (teaserList) teaserList.innerHTML = data.data.html;

	// Replace pagination HTML
	const oldPagination = document.querySelector('.pagination-append-container');
	if (oldPagination) {
	 oldPagination.outerHTML = data.data.pagination_html;
	} else {
	 teaserList.insertAdjacentHTML('afterend', data.data.pagination_html);
	}

	initPaginationListeners(); // reattach pagination buttons
	attachPaginationEventListeners(); // reattach popup logic
	setTimeout(() => {
	 const newTeaserList = document.querySelector(".filter-content-cards-grid");
	 if (newTeaserList) {
	  const offset = 100; // Adjust based on your sticky header height
	  const top = newTeaserList.getBoundingClientRect().top + window.pageYOffset - offset;
	  window.scrollTo({
	   top: top,
	   behavior: "smooth",
	  });
	 }
	}, 50); // slight delay to ensure DOM update
   } else {
	teaserList.innerHTML = "<p>No past events found.</p>";
   }
  })
  .catch((error) => {
   console.error("AJAX error:", error);
   teaserList.innerHTML = "<p>Error loading events.</p>";
  });
}

// Tab click listener
if (pastEventLinks.length > 0 && teaserList) {
 pastEventLinks.forEach((link) => {
  link.addEventListener("click", function (e) {
   e.preventDefault();
   const term = this.getAttribute("data-term");

   document.querySelectorAll(".past-events-ctn li").forEach((li) => li.classList.remove("active"));
   this.closest("li").classList.add("active");

   fetchPastEvents(term, 1);
  });
 });
}

function initPaginationListeners() {
 document.querySelectorAll(".pagination-container .page-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
   const page = parseInt(this.getAttribute("data-page"));
   if (!isNaN(page) && page !== currentPage) {
	fetchPastEvents(currentTerm, page);
   }
  });
 });

 const prevBtns = document.querySelectorAll("#desktopPrev, #prevBtn, #popupPrev");
 const nextBtns = document.querySelectorAll("#desktopNext, #nextBtn, #popupNext");

 prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
   if (currentPage > 1) fetchPastEvents(currentTerm, currentPage - 1);
  });
 });

 nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
   fetchPastEvents(currentTerm, currentPage + 1);
  });
 });
}

// Mobile popup pagination toggle
function attachPaginationEventListeners() {
 const pageTrigger = document.getElementById('pageTrigger');
 const paginationPopup = document.getElementById('paginationPopup');

 if (pageTrigger && paginationPopup) {
  pageTrigger.addEventListener('click', function () {
   paginationPopup.classList.toggle('active');
  });

  document.addEventListener('click', function (e) {
   if (
	paginationPopup.classList.contains('active') &&
	!paginationPopup.contains(e.target) &&
	e.target !== pageTrigger
   ) {
	paginationPopup.classList.remove('active');
   }
  });
 }
}

initPaginationListeners();
attachPaginationEventListeners();
// Past Event Filter JS Code end




});
