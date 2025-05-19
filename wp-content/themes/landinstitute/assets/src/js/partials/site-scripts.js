/**
 * Sticky Header
 * Adds a class to header on scroll
 */
document.addEventListener("scroll", () => {
	const header = document.querySelector("header");
	if (header) {
		if (document.documentElement.scrollTop > 0) {
			header.classList.add("shrink");
			document.body.classList.add("shrink");
		} else {
			header.classList.remove("shrink");
			document.body.classList.remove("shrink");
		}
	}
});

// Function to set a cookie
function setCookie(name, value, days) {
	const date = new Date();
	date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000); // Set expiration to dynamic days
	document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/`;
}

// Function to get a cookie
function getCookie(name) {
	const nameEQ = `${name}=`;
	const cookies = document.cookie.split(";");
	for (let cookie of cookies) {
		cookie = cookie.trim();
		if (cookie.indexOf(nameEQ) === 0) {
			return cookie.substring(nameEQ.length);
		}
	}
	return null;
}

// Hide hello bar if cookie exists
document.addEventListener("DOMContentLoaded", () => {
	const helloBar = document.querySelector(".top-bar");
	if (helloBar) {
		const cookieDays = parseInt(
			helloBar.getAttribute("data-cookie-days"),
			10,
		); // Convert data-cookie-days to integer

		if (getCookie("helloBarClosed")) {
			helloBar.style.display = "none"; // Hide the hello bar if cookie exists
		} else {
			helloBar.style.display = "flex"; // Show the hello bar if cookie does not exist
		}
		// Add event listener to the close button
		const closeButton = helloBar.querySelector(".top-bar-cross");
		if (closeButton) {
			closeButton.addEventListener("click", (e) => {
				e.preventDefault();
				helloBar.style.display = "none"; // Hide the hello bar
				setCookie("helloBarClosed", "true", cookieDays); // Use dynamic value from the data attribute
			});
		}
	}
});

// Accessibility: Add aria-label to links that open in a new tab
document.querySelectorAll('a[target="_blank"]').forEach((link) => {
	// Check if the link already has an aria-label
	if (!link.hasAttribute("aria-label")) {
		// Add aria-label if it's not already present
		link.setAttribute("aria-label", "Opens in a new tab");
	}
});

// Add span tag to multi-level accordion menu for mobile menus
const listItems = document.querySelectorAll("li.menu-item-has-children");
if (listItems.length > 0) {
	listItems.forEach(function (item) {
		const anchor = item.querySelector("a:first-child");
		if (anchor) {
			const span = document.createElement("span");
			span.className = "menu-expand";
			span.setAttribute("role", "none");
			anchor.insertAdjacentElement("afterend", span);
		}
	});
}
// Focus and blur events for menu items with sub-menus
document.querySelectorAll(".menu-item-has-children > a").forEach((anchor) => {
	anchor.addEventListener("focus", () => {
		const subMenu = anchor.nextElementSibling;
		if (subMenu && subMenu.classList.contains("sub-menu")) {
			subMenu.classList.add("focused");
		}
	});
	anchor.addEventListener("blur", () => {
		const subMenu = anchor.nextElementSibling;
		if (subMenu && subMenu.classList.contains("sub-menu")) {
			subMenu.classList.remove("focused");
		}
	});
});

// Toggle menu button functionality
const menuBtn = document.querySelector(".menu-btn");
const navOverlay = document.querySelector(".nav-overlay");
if (menuBtn && navOverlay) {
	menuBtn.addEventListener("click", () => {
		menuBtn.classList.toggle("active");
		navOverlay.classList.toggle("open");
		document.documentElement.classList.toggle("no-overflow");
		document.body.classList.toggle("no-overflow");

		// Reset active states for menu items and hide sub-menus
		document
			.querySelectorAll(".header-nav ul li.active")
			.forEach((item) => {
				item.classList.remove("active");
			});
		document
			.querySelectorAll(".header-nav ul.sub-menu")
			.forEach((subMenu) => {
				subMenu.style.display = "none"; // Equivalent to slideUp
			});
	});
}

// Slide Up/Down internal sub-menu when mobile menu arrow clicked
document.addEventListener("click", (event) => {
	if (event.target.matches(".header-nav .menu-item span")) {
		const link = event.target.closest("li");
		if (link) {
			// Remove active class and slide up siblings
			link.parentElement
				.querySelectorAll(".active")
				.forEach((activeSibling) => {
					activeSibling.classList.remove("active");
					activeSibling.querySelectorAll("ul").forEach((ul) => {
						ul.style.display = "none"; // Equivalent to slideUp
					});
				});

			// Toggle active class and slide down the current sub-menu
			if (link.classList.contains("active")) {
				link.classList.remove("active");
				link.closest("ul").classList.remove("disabled-menu");
				link.querySelectorAll("ul").forEach((ul) => {
					ul.style.display = "none"; // Equivalent to slideUp
				});
			} else {
				link.classList.add("active");
				link.closest("ul").classList.add("disabled-menu");
				link.querySelectorAll("ul").forEach((ul) => {
					ul.style.display = "block"; // Equivalent to slideDown
				});
			}
		}
	}
});

// Offcanvas Menu
// document.addEventListener("DOMContentLoaded", () => {
// 	const openMenuButton = document.getElementById("openMenu");
// 	const closeMenuButton = document.getElementById("closeMenu");
// 	const offCanvasMenu = document.getElementById("offCanvasMenu");
// 	const overlay = document.getElementById("overlay");

// 	openMenuButton.addEventListener("click", () => {
// 		offCanvasMenu.classList.add("open");
// 		overlay.classList.add("show");
// 		document.documentElement.classList.add("popup-overflow-hidden");
// 	});

// 	closeMenuButton.addEventListener("click", () => {
// 		offCanvasMenu.classList.remove("open");
// 		overlay.classList.remove("show");
// 		document.documentElement.classList.remove("popup-overflow-hidden");
// 	});

// 	overlay.addEventListener("click", () => {
// 		offCanvasMenu.classList.remove("open");
// 		overlay.classList.remove("show");
// 		document.documentElement.classList.remove("popup-overflow-hidden");
// 	});
// });

// Tab DropDown
document.addEventListener("DOMContentLoaded", () => {
	const dropdowns = document.querySelectorAll(".tab-dropdown");
	document.addEventListener("click", (event) => {
		let clickedDropdown = null;
		dropdowns.forEach((dropdown) => {
			const toggle = dropdown.querySelector(".dropdown-toggle");
			if (!dropdown.contains(event.target)) {
				toggle.setAttribute("aria-expanded", false);
				dropdown.classList.remove("open");
			} else if (event.target === toggle) {
				clickedDropdown = dropdown;
			}
		});
		if (clickedDropdown) {
			const toggle = clickedDropdown.querySelector(".dropdown-toggle");
			const menu = clickedDropdown.querySelector(".dropdown-menu");
			const isExpanded = toggle.getAttribute("aria-expanded") === "true";
			toggle.setAttribute("aria-expanded", !isExpanded);
			clickedDropdown.classList.toggle("open", !isExpanded);
			if (!isExpanded) {
				menu.querySelectorAll("li").forEach((item, index) => {
					item.style.animationDelay = `${index * 0.1}s`;
				});
			}
		}
	});
});

// Sticky Social Start
document.addEventListener("DOMContentLoaded", () => {
	if (document.body.classList.contains("single-post")) {
		const stickySocial = document.querySelector(".sticky-social");

		// Function to update sticky-social top position
		const updateStickySocial = () => {
			if (stickySocial) {
				stickySocial.style.position = "sticky";
				stickySocial.style.top = "25px"; // Fixed top position
			}
		};

		// Initial update on DOMContentLoaded
		updateStickySocial();

		// Apply style to body tag
		document.body.style.overflowX = "unset";
		document.body.style.setProperty("overflow-x", "unset", "important");
	}
});

// Counter
document.addEventListener("DOMContentLoaded", function () {
	const counters = document.querySelectorAll(".counter-number .count");
	const speed = 2000; // Duration for all counters to finish counting (in milliseconds)

	const getMaxTarget = () => {
		return Math.max(
			...Array.from(counters).map(
				(counter) =>
					+counter
						.closest(".counter-number")
						.getAttribute("data-target"),
			),
		);
	};

	const maxTarget = getMaxTarget(); // Find the highest target value

	const countUp = (counter) => {
		const target = +counter
			.closest(".counter-number")
			.getAttribute("data-target");
		const startTime = performance.now();

		const updateCount = (currentTime) => {
			const elapsedTime = currentTime - startTime;
			const progress = Math.min(elapsedTime / speed, 1); // Progress from 0 to 1 over the speed duration
			const currentCount = Math.ceil(progress * target);

			counter.innerText = currentCount;

			if (progress < 1) {
				requestAnimationFrame(updateCount);
			} else {
				counter.innerText = target; // Ensure the final value is the target
			}
		};

		requestAnimationFrame(updateCount);
	};

	const options = {
		threshold: 0.1,
	};

	const observer = new IntersectionObserver((entries, observer) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				const counter = entry.target.querySelector(".count");
				countUp(counter);
				observer.unobserve(entry.target);
			}
		});
	}, options);

	counters.forEach((counter) => {
		observer.observe(counter.closest(".counter-number"));
	});
});

// popup
// document.addEventListener("click", (e) => {
// 	if (
// 		e.target.tagName === "A" &&
// 		e.target.getAttribute("href").startsWith("#")
// 	) {
// 		e.preventDefault();
// 		// const id = e.target.getAttribute("href").substring(1);
// 		// const popup = document.getElementById(id);
// 		const openPopup = document.querySelector(".custom-popup");
// 		const overflowHidden = document.querySelector("html");

// 		if (openPopup) {
// 			openPopup.classList.add("is-opened");
// 			overflowHidden.classList.add("overflow-hidden");
// 			const iframe = openPopup.querySelector("iframe");
// 			if (iframe) {
// 				openPopup.classList.add("youtube");
// 			}
// 		}
// 	}
// 	if (e.target.classList.contains("close-popup")) {
// 		const openPopup = document.querySelector(".custom-popup.is-opened");
// 		const overflowHidden = document.querySelector(".overflow-hidden");
// 		// setTimeout(() => {
// 		openPopup.classList.remove("is-opened", "youtube");
// 		overflowHidden.classList.remove("overflow-hidden");
// 		// }, 200);
// 	}
// });

// document.addEventListener("keydown", (e) => {
// 	if (e.key === "Escape" || e.code === "Escape") {
// 		const openPopup = document.querySelector(".custom-popup.is-opened");
// 		if (openPopup) {
// 			setTimeout(() => {
// 				openPopup.classList.remove("is-opened");
// 			}, 200);
// 		}
// 	}
// });

document.addEventListener("click", (e) => {
	if (
		e.target.tagName === "A" &&
		e.target.getAttribute("href").startsWith("#")
	) {
		e.preventDefault();

		// Dynamically create the popup HTML if not already present
		let openPopup = document.querySelector(".custom-popup");
		if (!openPopup) {
			const popupHTML = `
				<div class="custom-popup">
					<div class="popup-wrap">
						<div class="popup-container">
							<div class="popup-content">
								<div id="popupcard" class="popup-card-normal">
									<div class="popup-block-design">
										<h4 class="heading-4 popup-title mb-0 center-align">
											Gift the Joy of Cooking </h4>
										<div class="gl-s24"></div>
										<div class="popup-description center-align">
											<p>Give the gift of culinary exploration with &amp; a Culinary Center of Kansas City
												gift certificate.</p>
										</div>
										<div class="gl-s48"></div>
										<div class="popup-column-text">
											<div class="column-text">
												<div class="column-col">
													<div class="ui-label-m-poppins-regular body-title">
														For Every Skill Level </div>
													<div class="gl-s12"></div>
													<div class="body-content body-text-s-light">
														<p>Perfect for foodies of all levels – choose from classes like knife
															skills, baking, or global
															cuisines.</p>
													</div>
												</div>
												<div class="column-col">
													<div class="ui-label-m-poppins-regular body-title">
														Flexible &amp; Fun </div>
													<div class="gl-s12"></div>
													<div class="body-content body-text-s-light">
														<p>Recipients pick their favorite class – from quick weeknight sessions
															to immersive full-day courses.
														</p>
													</div>
												</div>
												<div class="column-col">
													<div class="ui-label-m-poppins-regular body-title">
														Available in Any Amount </div>
													<div class="gl-s12"></div>
													<div class="body-content body-text-s-light">
														<p>Gift cards in any denomination. Let them discover new flavors and
															skills they’ll savor for years.</p>
													</div>
												</div>
											</div>
										</div>
										<div class="gl-s48"></div>
										<div class="two-btn-row">
											<a class="site-btn border-primary-white" href="#" target="_self"
												data-text="Check Balance">
												<span>Check Balance</span>
											</a>

											<a class="site-btn" href="#" target="_self" data-text="Purchase a Gift Card">
												<span>Purchase a Gift Card</span>
											</a>
										</div>
									</div>
								</div>
								<div class="popup-iframe-contanier">
									<iframe width="560" height="315"
										src="https://www.youtube.com/embed/lT8jeRdCTos?si=SVYwDn4-3RCOaDxM"
										title="YouTube video player" frameborder="0"
										allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
										referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
								</div>
							</div>
							<button class="close-popup" type="button">x</button>
						</div>
					</div>
				</div>`;
			document.body.insertAdjacentHTML("beforeend", popupHTML);
			openPopup = document.querySelector(".custom-popup");
		}

		// Show the popup
		openPopup.classList.add("is-opened");
		document.querySelector("html").classList.add("overflow-hidden");
		const iframe = openPopup.querySelector("iframe");
		if (iframe) {
			openPopup.classList.add("youtube");
		}
	}

	// Handle click on close button
	if (e.target.classList.contains("close-popup")) {
		const openPopup = document.querySelector(".custom-popup.is-opened");
		const overflowHidden = document.querySelector("html");

		if (openPopup) {
			openPopup.classList.remove("is-opened", "youtube");
			overflowHidden.classList.remove("overflow-hidden");
			openPopup.remove();
		}
	}
});

// Close popup with Escape key
document.addEventListener("keydown", (e) => {
	if (e.key === "Escape" || e.code === "Escape") {
		const openPopup = document.querySelector(".custom-popup.is-opened");
		const overflowHidden = document.querySelector("html");

		if (openPopup) {
			openPopup.classList.remove("is-opened", "youtube");
			overflowHidden.classList.remove("overflow-hidden");
			openPopup.remove();
		}
	}
});

// popup
// document.addEventListener("click", (e) => {
// 	if (
// 		e.target.tagName === "A" &&
// 		e.target.getAttribute("href").startsWith("#")
// 	) {
// 		e.preventDefault();
// 		// const id = e.target.getAttribute("href").substring(1);
// 		// const popup = document.getElementById(id);
// 		const openPopup = document.querySelector(".custom-popup");
// 		const overflowHidden = document.querySelector("html");

// 		if (openPopup) {
// 			createPopup(openPopup.innerHTML);
// 			openPopup.classList.add("is-opened");
// 			overflowHidden.classList.add("overflow-hidden");
// 			const iframe = openPopup.querySelector("iframe");
// 			if (iframe) {
// 				openPopup.classList.add("youtube");
// 			}
// 		}
// 	}
// 	if (e.target.classList.contains("close-popup")) {
// 		// const openPopup = document.querySelector(".custom-popup.is-opened");
// 		// const overflowHidden = document.querySelector(".overflow-hidden");
// 		// // setTimeout(() => {
// 		// openPopup.classList.remove("is-opened", "youtube");
// 		// overflowHidden.classList.remove("overflow-hidden");
// 		// }, 200);
// 		removePopup();
// 	}
// });

// function createPopup(content) {
// 	const popup = document.createElement("div");
// 	// popup.id = "custom-popup";
// 	popup.className = "custom-popup is-opened";
// 	popup.innerHTML = `
//     <div class="popup-content">
//       <button class="close-popup">Close</button>
//       ${content}
//     </div>
//   `;
// 	document.body.appendChild(popup);
// 	document.querySelector("html").classList.add("overflow-hidden");

// 	// Check if the popup contains an iframe
// 	const iframe = popup.querySelector("iframe");
// 	if (iframe) {
// 		popup.classList.add("youtube");
// 	}
// }

// function removePopup() {
// 	const popup = document.querySelector(".custom-popup");
// 	if (popup) {
// 		popup.classList.remove("is-opened", "youtube");
// 		// setTimeout(() => {
// 		popup.remove(); // Remove the popup from the DOM
// 		document.querySelector("html").classList.remove("overflow-hidden");
// 		// }, 200); // Match the transition duration
// 	}
// }

// document.addEventListener("keydown", (e) => {
// 	if (e.key === "Escape" || e.code === "Escape") {
// 		const openPopup = document.querySelector(".custom-popup.is-opened");
// 		if (openPopup) {
// 			setTimeout(() => {
// 				openPopup.classList.remove("is-opened");
// 			}, 200);
// 		}
// 	}
// });
