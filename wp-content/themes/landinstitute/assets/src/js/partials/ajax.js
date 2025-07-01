document.addEventListener("DOMContentLoaded", function () {
	const donorGrid = document.querySelector(".filter-logos-row");
	let currentDonorType = "all";
	let currentDonationLevel = "all";
	let currentPage = 1;

	function fetchDonors() {
		const postsPerPage = donorGrid.dataset.donorCount || 9;
		// Loader
		const existingLoader = donorGrid.querySelector(".ajax-loader");
        if (!existingLoader) {
        	const loader = document.createElement("div");
        	loader.className = "ajax-loader";
        	loader.innerHTML = "<p>Loading Donors...</p>";
        	donorGrid.prepend(loader); 
        }

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
});
