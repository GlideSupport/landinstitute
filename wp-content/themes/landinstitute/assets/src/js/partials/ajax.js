document.addEventListener("DOMContentLoaded", function () {
	//Logo Filter code start
	const donorGrid = document.querySelector(".filter-logos-row");
	let currentDonorType = getURLParam("donor_type") || "all";
	let currentDonationLevel = getURLParam("donation_level") || "all";
	let currentPage = 1;

	const pathMatch = window.location.pathname.match(/\/page\/(\d+)\//);
	if (pathMatch && pathMatch[1]) {
		currentPage = parseInt(pathMatch[1], 10);
	}
	function getURLParam(param) {
		const urlParams = new URLSearchParams(window.location.search);
		return urlParams.get(param);
	}

	function updateURLParams() {
	const url = new URL(window.location);
	const params = url.searchParams;
	let newPath = url.pathname;

	// Clean existing /page/number/ from the pathname if present
	newPath = newPath.replace(/\/page\/\d+\/?$/, "").replace(/\/$/, "");

	// Append /page/X/ if currentPage > 1
	if (currentPage && currentPage > 1) {
		newPath += `/page/${currentPage}/`;
	} else {
		newPath += "/";
	}

	// Update donor_type
	if (currentDonorType && currentDonorType !== "all") {
		params.set("donor_type", currentDonorType);
	} else {
		params.delete("donor_type");
	}

	// Update donation_level
	if (currentDonationLevel && currentDonationLevel !== "all") {
		params.set("donation_level", currentDonationLevel);
	} else {
		params.delete("donation_level");
	}

	// Push the new URL
	const newUrl = `${newPath}?${params.toString()}`;
	history.replaceState({}, "", newUrl.endsWith("?") ? newUrl.slice(0, -1) : newUrl);
}


	function fetchDonors() {
		const postsPerPage = donorGrid.dataset.donorCount || 9;
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
					updatePagination(data.data.pagination_html);
				} else {
					donorGrid.innerHTML = "<p>No donors found for this filter.</p>";
				}
     	attachPaginationListeners();

			})
			.catch((err) => {
				console.error("AJAX Error:", err);
				donorGrid.innerHTML = "<p>Error loading donors.</p>";
			});

		updateURLParams();
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

		attachPaginationListeners();
	}

	function attachPaginationListeners() {
	document.querySelectorAll(".logo-grid-filters .page-btn").forEach((btn) => {
		btn.addEventListener("click", function (e) {
			e.preventDefault();
			const newPage = parseInt(this.dataset.page);
			if (!isNaN(newPage) && newPage !== currentPage) {
				currentPage = newPage;
				fetchDonors();
			}
		});
	});

	const prevBtn = document.querySelector(".logo-grid-filters .arrow-btn.prev .site-btn");
	const nextBtn = document.querySelector(".logo-grid-filters .arrow-btn.next .site-btn");

	if (prevBtn) {
		prevBtn.addEventListener("click", (e) => {
			e.preventDefault();
			if (currentPage > 1) {
				currentPage--;
				fetchDonors();
			}
		});
	}

	if (nextBtn) {
		nextBtn.addEventListener("click", (e) => {
			e.preventDefault();
			currentPage++;
			fetchDonors();
		});
	}

	const mobilePrev = document.querySelector(".logo-grid-filters #prevBtn");
	const mobileNext = document.querySelector(".logo-grid-filters #nextBtn");

	if (mobilePrev) {
		mobilePrev.addEventListener("click", (e) => {
			e.preventDefault();
			if (currentPage > 1) {
				currentPage--;
				fetchDonors();
			}
		});
	}

	if (mobileNext) {
		mobileNext.addEventListener("click", (e) => {
			e.preventDefault();
			currentPage++;
			fetchDonors();
		});
	}

	document.querySelectorAll(".logo-grid-filters #popupGrid .page-btn").forEach((btn) => {
		btn.addEventListener("click", (e) => {
			e.preventDefault();
			const popupPage = parseInt(btn.dataset.page);
			if (!isNaN(popupPage)) {
				currentPage = popupPage;
				fetchDonors();
			}
		});
	});
//	   attachPaginationListeners();

}


	document.querySelectorAll(".logo-filter-main .dropdown-menu").forEach((menu) => {
		menu.querySelectorAll("a[data-term]").forEach((link) => {
			link.addEventListener("click", (e) => {
				e.preventDefault();
				const taxonomy = menu.id;
				const term = link.getAttribute("data-term");

				menu.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
				link.closest("li").classList.add("active");

				if (taxonomy === "donor-type") {
					currentDonorType = term;
					document.querySelector("button#donor-type").innerHTML =
						"Donor type: " + (term === "all" ? "All types" : term.replace(/-/g, " "));
				} else if (taxonomy === "donation-level") {
					currentDonationLevel = term;
					document.querySelector("button#donation-level").innerHTML =
						"Donation level: " + (term === "all" ? "All levels" : term.replace(/-/g, " "));
				}

				currentPage = 1;
				fetchDonors();
			});
		});
	});

	attachPaginationListeners();

//logo filter code end



	
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
// window.addEventListener('popstate', function (e) {
// 	const paged = (e.state && e.state.paged) ? e.state.paged : 1;
// 	fetchPastEvents(paged, false); // false = don't update URL again
// });

// On initial load, if /page/2 exists in URL, trigger fetch
// document.addEventListener("DOMContentLoaded", function () {
// 	const match = window.location.pathname.match(/\/page\/(\d+)/);
// 	if (match) {
// 		const page = parseInt(match[1]);
// 		if (!isNaN(page) && page > 1) {
// 			fetchPastEvents(page, false); // load via AJAX on first hit
// 		}
// 	}
// });


// Initialize listeners on first load
initPaginationListeners();
attachPaginationEventListeners();

// Past Event Pagination JS End



//new code
var currentnewsType =""; 
var currentnewstopic =""; 
var currentnewsaudience =""; 
var currentnewscrop =""; 

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
					const typeBtn = document.querySelector("button#news-type");
					if (typeBtn) {
						typeBtn.innerHTML = "News type: " + (term === "all" ? "All types" : term.replace(/-/g, " "));
					}
				} else if (taxonomy === "news-topic") {
					currentnewstopic = term;
					const topicBtn = document.querySelector("button#topic-view");
					if (topicBtn) {
						topicBtn.innerHTML = "Topic: " + (term === "all" ? "All Topics" : term.replace(/-/g, " "));
					}
				} else if (taxonomy === "news-audience") {
					currentnewsaudience = term;
					const audienceBtn = document.querySelector("button#news-audience");
					if (audienceBtn) {
						audienceBtn.innerHTML = "Audience: " + (term === "all" ? "All Audiences" : term.replace(/-/g, " "));
					}
				} else if (taxonomy === "news-crop") {
					currentnewscrop = term;
					const cropBtn = document.querySelector("button#types-view");
					if (cropBtn) {
						cropBtn.innerHTML = "Crop: " + (term === "all" ? "All Crops" : term.replace(/-/g, " "));
					}
				}


			// Reset to page 1
			currentPage = 1;
			fetchnews();
		});
	});
});


	const news_append_list = document.querySelector(".newsmain .filter-content-cards-grid");
	const new_pagination = document.querySelector(".newsmain .fillter-bottom");
	const newnotfound = document.querySelector(".newsmain .not-found-append");


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
				if (currentnewsType === "all") {
					url.searchParams.delete("type");
				} else {
					url.searchParams.set("type", currentnewsType || "");
				}
			}
			if(currentnewstopic){

				if (currentnewstopic === "all") {
					url.searchParams.delete("topic");
				} else {
					url.searchParams.set("topic", currentnewstopic || "");
				}

			}
			if(currentnewsaudience){
				if (currentnewsaudience === "all") {
					url.searchParams.delete("audience");
				} else {
				url.searchParams.set("audience", currentnewsaudience || "");
				}
			}
			if(currentnewscrop){
				if (currentnewscrop === "all") {
					url.searchParams.delete("crop");
				} else {
				url.searchParams.set("crop", currentnewscrop || "");
				}
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
				news_audience: currentnewsaudience,
				news_crop:currentnewscrop,
				nonce: localVars.nonce,
			}),
		})
			.then((res) => res.json())
			.then((data) => {
				if (data.success) {
					// ✅ Corrected this line
					if (new_pagination) news_append_list.innerHTML = data.data.news_html;


					if(data.data.datafound == "yes"){
					if (news_append_list) {
						news_append_list.innerHTML = data.data.news_html;
					};
					newnotfound.innerHTML = '';
						}else{
						news_append_list.innerHTML = '';
						newnotfound.innerHTML = data.data.news_html
					}


					const oldPagination = document.querySelector('.news-pagination-append-container');
					if (oldPagination) {
						oldPagination.outerHTML = data.data.pagination_html;
					} else {

						//const oldPagination = document.querySelector('.news-pagination-append-container');
						console.log(123);

						new_pagination.insertAdjacentHTML('beforeend', data.data.pagination_html);
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
var learntype = "";
var learntopic = "";
var learncrops = "";
//var currentPage = 1;

// Helper function to get query param
function getQueryParam(param) {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get(param);
}

// Helper to format label
function formatLabel(label, fallback) {
	return label === "all" ? fallback : label.replace(/-/g, " ");
}

// Load values from URL
window.addEventListener("DOMContentLoaded", () => {
	// Get values from URL if present
	learntype = getQueryParam("learn-type") || "";
	learntopic = getQueryParam("learn-topic") || "";
	learncrops = getQueryParam("learn-crop") || "";
	//console
	// Set initial button labels and active states
	if (learntype) {
		document.querySelector("button#type-view").innerHTML = "Type: " + formatLabel(learntype, "Type");
		document.querySelector(`#learn-type a[data-term="${learntype}"]`)?.closest("li")?.classList.add("active");
	}
	if (learntopic) {
		document.querySelector("button#topic-view").innerHTML = "Topic: " + formatLabel(learntopic, "Topic");
		document.querySelector(`#learn-topic a[data-term="${learntopic}"]`)?.closest("li")?.classList.add("active");
	}
	if (learncrops) {
		document.querySelector("button#category-view").innerHTML = "Crop: " + formatLabel(learncrops, "Crop");
		document.querySelector(`#learn-crops a[data-term="${learncrops}"]`)?.closest("li")?.classList.add("active");
	}

	//fetchlearn(); // Initial fetch with values from URL
});
	document.querySelectorAll(".learn-list-filter .dropdown-menu").forEach((menu) => {
		menu.querySelectorAll("a[data-term]").forEach((link) => {
			link.addEventListener("click", (e) => {
				e.preventDefault();
				const taxonomy = menu.id; // donor-type or donation-level
				const term = link.getAttribute("data-term");

				//console.log(term+"seleceted term");
				
				// Remove 'active' class from siblings
				menu.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
				link.closest("li").classList.add("active");
				///console.log(taxonomy+"taxo");
				// Set selected term
				if (taxonomy === "learn-type") {
					learntype = term;
					const typeBtn = document.querySelector("button#type-view");
					if (typeBtn) {
						typeBtn.innerHTML = "Post type: " + (term === "all" ? "Post type" : term.replace(/-/g, " "));
					}
				} else if (taxonomy === "learn-topic") {
					learntopic = term;
					const topicBtn = document.querySelector("button#topic-view");
					if (topicBtn) {
						topicBtn.innerHTML = "Topic: " + (term === "all" ? "All Topics" : term.replace(/-/g, " "));
					}
				} else if (taxonomy === "learn-crops") {
					learncrops = term;
					const cropBtn = document.querySelector("button#category-view");
					if (cropBtn) {
						cropBtn.innerHTML = "Crop: " + (term === "all" ? "All Crops" : term.replace(/-/g, " "));
					}
				}


				// Reset to page 1
				currentPage = 1;
				fetchlearn();
			});
		});
	});

	//learn code start
	const learn_append_list = document.querySelector(".mainlearn .filter-cards-grid");
	const learn_pagination = document.querySelector(".mainlearn .fillter-bottom");
	const notfound = document.querySelector(".mainlearn .not-found-append");

	

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
		if (learntype === "all") {
				url.searchParams.delete("learn-type");
			} else if (learntype) {
				url.searchParams.set("learn-type", learntype);
			}

			if (learntopic === "all") {
				url.searchParams.delete("learn-topic");
			} else if (learntopic) {
				url.searchParams.set("learn-topic", learntopic);
			}

			if (learncrops === "all") {
				url.searchParams.delete("learn-crop");
			} else if (learncrops) {
				url.searchParams.set("learn-crop", learncrops);
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
					if(data.data.datafound == "yes"){
						if (learn_append_list) {
							learn_append_list.innerHTML = data.data.news_html;
						};
						notfound.innerHTML = '';

					}else{
						learn_append_list.innerHTML = '';
						notfound.innerHTML = data.data.news_html
					}

					const oldPagination = document.querySelector('.learn-pagination-append-container');
					if (oldPagination) {
						oldPagination.outerHTML = data.data.pagination_html;
					} else {
						learn_pagination.insertAdjacentHTML(
							'beforeend',
							`${data.data.pagination_html}`
						  );
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


// search ajax code start


document.addEventListener("DOMContentLoaded", function () {
	const urlParams = new URLSearchParams(window.location.search);
	const selectedType = urlParams.get("search-type") || "all";

	document.querySelectorAll("#search-type li").forEach((li) => {
		const aTag = li.querySelector("a[data-post]");
		if (aTag) {
			const postType = aTag.getAttribute("data-post");
			if (postType === selectedType) {
				li.classList.add("active");
				const label = postType === "all" ? "everything" : aTag.textContent.trim();
				document.querySelector("button#search-type").innerHTML = "Search: " + label;
			} else {
				li.classList.remove("active");
			}
		}
	});
});

var searcheve =""; 
document.querySelectorAll(".search-list-filter .dropdown-menu").forEach((menu) => {
	menu.querySelectorAll("a[data-post]").forEach((link) => {
		link.addEventListener("click", (e) => {
			e.preventDefault();
			const taxonomy = menu.id; // donor-type or donation-level
			const term = link.getAttribute("data-post");

			// Remove 'active' class from siblings
			menu.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
			link.closest("li").classList.add("active");

			// Set selected term
			if (taxonomy === "search-type") {
				searcheve = term;

				const label = term === "all" ? "everything" : link.textContent.trim();
				document.querySelector("button#search-type").innerHTML = "Search: " + label;
			}

			// Reset to page 1
			currentPage = 1;
			featch_search_list();
		});
	});
});

	const search_append_list = document.querySelector(".append-search-result"); // ✅ updated selector
	const search_pagination = document.querySelector(".append-search-result-pagination");
	const searchForm = document.getElementById('searchForm');
	const searchType = document.getElementById('search-type');


	let currentOrderBy = 'date';

	function getCurrentOrderBy() {
		return currentOrderBy;
	}



	function getSearchType() {
		return searchType ? searchType.value.trim() : '';
	}
 
		const searchInput = document.getElementById('search-field');

		function getSearchVal() {
			return searchInput ? searchInput.value.trim() : '';
		}

		// Set input from URL on page load
		if (searchInput) {
			const urlParams = new URLSearchParams(window.location.search);
			const searchValFromURL = urlParams.get("s") || "";
			searchInput.value = searchValFromURL;
		}

	function featch_search_list(paged = 1, updateURL = true) {
		currentPage = paged;


		if (search_append_list) {
			const loadingElem = document.createElement("div");
			loadingElem.className = "loading-placeholder";
			loadingElem.innerHTML = "<p>Loading...</p>";
			search_append_list.appendChild(loadingElem);
		}


		// Update query param in address bar
		if (updateURL) {
			const url = new URL(window.location);
			if(getSearchVal()){
			url.searchParams.set("s", getSearchVal());
			}
			if(getCurrentOrderBy()){
			url.searchParams.set("orderby", getCurrentOrderBy());
			}
			if(searcheve){
				url.searchParams.set("search-type", searcheve);
			}
			window.history.pushState({}, "", url);

			
		}

		const searchHeading = document.getElementById("search-heading");
		if (searchHeading) {
			searchHeading.textContent = `Results for "${getSearchVal()}"`;
		}


		fetch(localVars.ajax_url, {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
			},
			body: new URLSearchParams({
				action: "search_filter",
				type:searcheve,
				s: getSearchVal(),
				paged: paged,
				orderby: getCurrentOrderBy(),
			}),
		})
			.then((res) => res.json())
			.then((data) => {
				if (data.success) {
					// ✅ Insert search result HTML
					if (search_append_list) {
						search_append_list.innerHTML = data.data.news_html;
					}

					// ✅ Update or insert pagination
					const oldPagination = document.querySelector(".append-search-result-pagination");
					if (oldPagination) {
						oldPagination.outerHTML = data.data.pagination_html;
					} else if (search_pagination) {
						search_pagination.insertAdjacentHTML("beforeend", data.data.pagination_html);
					}

					initsearch_pagination();

					// ✅ Push pretty permalink
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

					// ✅ Smooth scroll to results
					setTimeout(() => {
						const newTeaserList = document.querySelector(".append-search-result");
						if (newTeaserList) {
							const offset = 100;
							const top = newTeaserList.getBoundingClientRect().top + window.pageYOffset - offset;
							window.scrollTo({ top: top, behavior: "smooth" });
						}
					}, 50);
				} else {
					search_append_list.innerHTML = "<p>No results found.</p>";
				}
			})
			.catch((error) => {
				console.error("AJAX error:", error);
				search_append_list.innerHTML = "<p>Error loading results.</p>";
			});
	}

	document.querySelectorAll('#search-orderby-tabs .tab-link').forEach(tab => {
		tab.addEventListener('click', function (e) {
			e.preventDefault();

			// Remove current from all
			document.querySelectorAll('#search-orderby-tabs .tab-link').forEach(t => t.classList.remove('current'));
			// Add current to this one
			this.classList.add('current');

			// Set the order
			currentOrderBy = this.dataset.orderby;
			console.log(currentOrderBy);
			// Run search again
			featch_search_list(1);
		});
	});



	function initsearch_pagination() {
		document.querySelectorAll(".search-main .pagination-container .page-btn").forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.preventDefault();
				const page = parseInt(this.getAttribute("data-page"));
				if (!isNaN(page) && page !== currentPage) {
					featch_search_list(page);
				}
			});
		});

		document.querySelectorAll(".search-main .pagination-container .site-btn").forEach((btn) => {
			btn.addEventListener("click", function (e) {
				e.preventDefault();
				const page = parseInt(this.getAttribute("data-page"));
				if (!isNaN(page)) {
					featch_search_list(page);
				}
			});
		});
	}

	if (searchForm) {
	searchForm.addEventListener('submit', function (e) {
		e.preventDefault(); // prevent page reload
		featch_search_list(1, true); // call with page 1 on new search
	});
}




initsearch_pagination();



});
document.addEventListener('click', function (e) {
	const disabledLink = e.target.closest('.arrow-btn.disable');
	if (disabledLink) {
		e.preventDefault();
	}
});
