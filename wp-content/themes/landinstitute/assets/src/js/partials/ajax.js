document.addEventListener("DOMContentLoaded", function () {
	const donorGrid = document.querySelector(".filter-logos-row");
	let currentDonorType = "all";
	let currentDonationLevel = "all";
	//let currentPage = 1;

	function getCurrentPageFromURL() {
		const match = window.location.pathname.match(/\/page\/(\d+)(\/)?$/);
		return match ? parseInt(match[1]) : 1;
	}
	
	let currentPage = getCurrentPageFromURL();


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
		// Page number buttons scoped to .logo-grid-filters
		document.querySelectorAll(".logo-grid-filters .page-btn").forEach((btn) => {
			btn.addEventListener("click", function () {
				const newPage = parseInt(this.textContent);
				if (!isNaN(newPage) && newPage !== currentPage) {
					currentPage = newPage;
					fetchDonors();
				}
			});
		});
	
		// Desktop Prev/Next buttons inside .logo-grid-filters
		const prevBtn = document.querySelector(".logo-grid-filters .arrow-btn.prev .site-btn");
		const nextBtn = document.querySelector(".logo-grid-filters .arrow-btn.next .site-btn");
	
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
		const mobilePrev = document.querySelector(".logo-grid-filters #prevBtn");
		const mobileNext = document.querySelector(".logo-grid-filters #nextBtn");
	
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
	
		// Mobile popup pagination inside popupGrid
		document.querySelectorAll(".logo-grid-filters #popupGrid .page-btn").forEach((btn) => {
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
	document.querySelectorAll(".logo-filter-main .dropdown-menu").forEach((menu) => {
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
// Past Event Pagination JS Start

const teaserList = document.querySelector(".filter-content-cards-grid");

function fetchPastEvents(paged = 1, updateURL = true) {
	currentPage = paged;

	if (teaserList) {
		const loadingElem = document.createElement("div");
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

				const oldPagination = document.querySelector('.pagination-append-container');
				if (oldPagination) {
					oldPagination.outerHTML = data.data.pagination_html;
				} else {
					teaserList.insertAdjacentHTML('afterend', data.data.pagination_html);
				}

				initPaginationListeners(); // reattach buttons
				attachPaginationEventListeners(); // reattach popup toggle

				// Update browser URL without reload
				if (updateURL) {
					const { pathname, search } = window.location;
				
					// Remove trailing slash and match ending /page/{n}
					const cleanedPath = pathname.replace(/\/page\/\d+\/?$/, '');
				
					// Ensure trailing slash
					let newPath = cleanedPath.replace(/\/$/, '') + '/';
				
					// Add pagination segment if needed
					if (paged > 1) {
						newPath += `page/${paged}/`;
					}
				
					// Combine with query string
					const newURL = newPath + search;
				
					// Push new URL into browser history
					history.pushState({ paged: paged }, '', newURL);
				}
				
				
				
				// Scroll to top of the list
				setTimeout(() => {
					const newTeaserList = document.querySelector(".filter-content-cards-grid");
					if (newTeaserList) {
						const offset = 100; // adjust for sticky headers
						const top = newTeaserList.getBoundingClientRect().top + window.pageYOffset - offset;
						window.scrollTo({ top: top, behavior: "smooth" });
					}
				}, 50);
			} else {
				teaserList.innerHTML = "<p>No past events found.</p>";
			}
		})
		.catch((error) => {
			console.error("AJAX error:", error);
			teaserList.innerHTML = "<p>Error loading events.</p>";
		});
}

function initPaginationListeners() {
	document.querySelectorAll(".pastevent .pagination-container .page-btn").forEach((btn) => {
		btn.addEventListener("click", function (e) {
			console.log("click"+currentPage);

			e.preventDefault(); // ✅ prevent default link behavior
			const page = parseInt(this.getAttribute("data-page"));
			if (!isNaN(page) && page !== currentPage) {
				fetchPastEvents( page);
			}
		});
	});

	const prevBtns = document.querySelectorAll(".pastevent #desktopPrev, .pastevent #prevBtn, .pastevent #popupPrev");
	const nextBtns = document.querySelectorAll(".pastevent #desktopNext, .pastevent #nextBtn, .pastevent #popupNext");

	// prevBtns.forEach((btn) => {
	// 	btn.addEventListener("click", (e) => {
	// 		e.preventDefault(); // ✅ prevent default for Prev buttons
	// 		if (currentPage > 1) fetchPastEvents( currentPage - 1);
	// 	});
	// });

	

	// nextBtns.forEach((btn) => {
	// 	btn.addEventListener("click", (e) => {
	// 		e.preventDefault(); // ✅ prevent default for Next buttons
	// 		fetchPastEvents( currentPage + 1);
	// 	});
	// });
}

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

// Detect back/forward browser navigation
window.addEventListener('popstate', function (e) {
	const paged = (e.state && e.state.paged) ? e.state.paged : 1;
	fetchPastEvents(paged, false); // false = don't update URL again
});

// On initial load, if /page/2 exists in URL, trigger fetch
document.addEventListener("DOMContentLoaded", function () {
	const match = window.location.pathname.match(/\/page\/(\d+)/);
	if (match) {
		const page = parseInt(match[1]);
		if (!isNaN(page) && page > 1) {
			fetchPastEvents(page, false); // load via AJAX on first hit
		}
	}
});

// Initialize listeners on first load
initPaginationListeners();
attachPaginationEventListeners();

// Past Event Pagination JS End



//new code
var currentnewsType =""; 
var currentnewstopic =""; 


document.querySelectorAll(".news-list-filter .dropdown-menu").forEach((menu) => {
	menu.querySelectorAll("a[data-term]").forEach((link) => {
		link.addEventListener("click", (e) => {
			e.preventDefault();
			const taxonomy = menu.id; // donor-type or donation-level
			const term = link.getAttribute("data-term");

			// Remove 'active' class from siblings
			menu.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
			link.closest("li").classList.add("active");

			// Set selected term
			if (taxonomy === "news-type") {
				currentnewsType = term;
				document.querySelector("button#types-view").innerHTML =
					"News type: " + (term === "all" ? "All types" : term.replace(/-/g, " "));
			} else if (taxonomy === "news-topic") {
				currentnewstopic = term;
				document.querySelector("button#topic-view").innerHTML =
					"Donation level: " + (term === "all" ? "All levels" : term.replace(/-/g, " "));
			}

			// Reset to page 1
			currentPage = 1;
			fetchnews();
		});
	});
});


	const news_append_list = document.querySelector(".newsmain .filter-content-cards-grid");
	function fetchnews(paged = 1, updateURL = true) {
		currentPage = paged;

		if (news_append_list) {
			const loadingElem = document.createElement("div");
			loadingElem.className = "loading-placeholder";
			loadingElem.innerHTML = "<p>Loading...</p>";
			news_append_list.appendChild(loadingElem);
		}

		if (updateURL) {
			const url = new URL(window.location);
			if(currentnewsType){
				url.searchParams.set("type", currentnewsType || "");

			}
			if(currentnewstopic){
				url.searchParams.set("topic", currentnewstopic || "");

			}
		//	url.searchParams.set("page", paged);
			window.history.pushState({}, "", url);
		}


		fetch(localVars.ajax_url, {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
			},
			body: new URLSearchParams({
				action: "filter_news",
				paged: paged,
				news_type: currentnewsType,
				news_topic:currentnewstopic,
				nonce: localVars.nonce,
			}),
		})
			.then((res) => res.json())
			.then((data) => {
				if (data.success) {
					// ✅ Corrected this line
					if (news_append_list) news_append_list.innerHTML = data.data.news_html;

					const oldPagination = document.querySelector('.news-pagination-append-container');
					if (oldPagination) {
						oldPagination.outerHTML = data.data.pagination_html;
					} else {
						news_append_list.insertAdjacentHTML('afterend', data.data.pagination_html);
					}

					initnewsPaginationListeners();
					attachPaginationEventListeners?.(); // Safe optional chaining

					if (updateURL) {
						const { pathname, search } = window.location;
						const cleanedPath = pathname.replace(/\/page\/\d+\/?$/, '');
						let newPath = cleanedPath.replace(/\/$/, '') + '/';
						if (paged > 1) {
							newPath += `page/${paged}/`;
						}
						const newURL = newPath + search;
						history.pushState({ paged: paged }, '', newURL);
					}


					setTimeout(() => {
						const newTeaserList = document.querySelector(".filter-content-cards-grid");
						if (newTeaserList) {
							const offset = 100;
							const top = newTeaserList.getBoundingClientRect().top + window.pageYOffset - offset;
							window.scrollTo({ top: top, behavior: "smooth" });
						}
					}, 50);
				} else {
					news_append_list.innerHTML = "<p>No news posts found.</p>";
				}
			})
			.catch((error) => {
				console.error("AJAX error:", error);
				news_append_list.innerHTML = "<p>Error loading news.</p>";
			});
	}



	
	//new code
	var learntype =""; 
	var learntopic =""; 
	var learncrops =""; 



	document.querySelectorAll(".learn-list-filter .dropdown-menu").forEach((menu) => {
		menu.querySelectorAll("a[data-term]").forEach((link) => {
			link.addEventListener("click", (e) => {
				e.preventDefault();
				const taxonomy = menu.id; // donor-type or donation-level
				const term = link.getAttribute("data-term");

				// Remove 'active' class from siblings
				menu.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
				link.closest("li").classList.add("active");

				// Set selected term
				if (taxonomy === "learn-type") {
					learntype = term;
					document.querySelector("button#types-view").innerHTML =
						"News type: " + (term === "all" ? "All types" : term.replace(/-/g, " "));
				} else if (taxonomy === "learn-topic") {
					learntopic = term;
					document.querySelector("button#topic-view").innerHTML =
						"Donation level: " + (term === "all" ? "All levels" : term.replace(/-/g, " "));
				}else if (taxonomy === "learn-crops") {
					learncrops = term;
					document.querySelector("button#topic-view").innerHTML =
						"Donation level: " + (term === "all" ? "All levels" : term.replace(/-/g, " "));
				}

				// Reset to page 1
				currentPage = 1;
				fetchlearn();
			});
		});
	});


	const learn_append_list = document.querySelector(".mainlearn .filter-cards-grid");
	function fetchlearn(paged = 1, updateURL = true) {
		currentPage = paged;

		if (learn_append_list) {
			const loadingElem = document.createElement("div");
			loadingElem.className = "loading-placeholder";
			loadingElem.innerHTML = "<p>Loading...</p>";
			learn_append_list.appendChild(loadingElem);
		}

		if (updateURL) {
			const url = new URL(window.location);
			if(learntype){
				url.searchParams.set("learn-type", learntype || "");

			}
			if(learntopic){
				url.searchParams.set("learn-topic", learntopic || "");

			}
			if(learncrops){
				url.searchParams.set("learn-crop", learncrops || "");

			}
		//	url.searchParams.set("page", paged);
			window.history.pushState({}, "", url);
		}


		fetch(localVars.ajax_url, {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
			},
			body: new URLSearchParams({
				action: "filter_learn",
				paged: paged,
				post_type: learntype,
				learn_topic:learntopic,
				learn_crops:learncrops,
				nonce: localVars.nonce,
			}),
		})
			.then((res) => res.json())
			.then((data) => {
				if (data.success) {
					// ✅ Corrected this line
					if (learn_append_list) learn_append_list.innerHTML = data.data.news_html;

					const oldPagination = document.querySelector('.learn-pagination-append-container');
					if (oldPagination) {
						oldPagination.outerHTML = data.data.pagination_html;
					} else {
						learn_append_list.insertAdjacentHTML('afterend', data.data.pagination_html);
					}

					initLearnPaginationListeners();
					attachPaginationEventListeners?.(); // Safe optional chaining
					

					if (updateURL) {
						const { pathname, search } = window.location;
						const cleanedPath = pathname.replace(/\/page\/\d+\/?$/, '');
						let newPath = cleanedPath.replace(/\/$/, '') + '/';
						if (paged > 1) {
							newPath += `page/${paged}/`;
						}
						const newURL = newPath + search;
						history.pushState({ paged: paged }, '', newURL);
					}


					setTimeout(() => {
						const newTeaserList = document.querySelector(".filter-content-cards-grid");
						if (newTeaserList) {
							const offset = 100;
							const top = newTeaserList.getBoundingClientRect().top + window.pageYOffset - offset;
							window.scrollTo({ top: top, behavior: "smooth" });
						}
					}, 50);
				} else {
					learn_append_list.innerHTML = "<p>No news posts found.</p>";
				}
			})
			.catch((error) => {
				console.error("AJAX error:", error);
				learn_append_list.innerHTML = "<p>Error loading news.</p>";
			});
	}



	function initnewsPaginationListeners() {
		document.querySelectorAll(".newsmain .pagination-container .page-btn").forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.preventDefault();
				const page = parseInt(this.getAttribute("data-page"));
				if (!isNaN(page) && page !== currentPage) {
					fetchnews(page);
				}
			});
		});

		document.querySelectorAll(".newsmain .pagination-container .site-btn").forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.preventDefault();
				const page = parseInt(this.getAttribute("data-page"));
				if (!isNaN(page)) {
					fetchnews(page);
				}
			});
		});
	}


	function initLearnPaginationListeners() {
		document.querySelectorAll(".mainlearn .pagination-container .page-btn").forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.preventDefault();
				const page = parseInt(this.getAttribute("data-page"));
				if (!isNaN(page) && page !== currentPage) {
					fetchlearn(page);
				}
			});
		});

		document.querySelectorAll(".mainlearn .pagination-container .site-btn").forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.preventDefault();
				const page = parseInt(this.getAttribute("data-page"));
				if (!isNaN(page)) {
					fetchlearn(page);
				}
			});
		});
	}


initnewsPaginationListeners();
initLearnPaginationListeners();

});
document.addEventListener('click', function (e) {
	const disabledLink = e.target.closest('.arrow-btn.disable');
	if (disabledLink) {
		e.preventDefault();
	}
});