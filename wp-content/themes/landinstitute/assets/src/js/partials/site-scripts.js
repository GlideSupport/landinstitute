import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

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

//blog detail and category detail page popup code start
document.addEventListener("click", function (event) {
	const lightboxElement = event.target.closest("[data-lightbox]");
	if (lightboxElement) {
		lity(event);
	}
});
//end

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

//sticky image with scroll start
document.addEventListener("DOMContentLoaded", function () {
	const header = document.querySelector(".header-section");
	const stickyWrappers = document.querySelectorAll(".sticky-img");

	function getHeaderHeight() {
		return header?.offsetHeight || 0;
	}

	function updateStickyPosition() {
		if (window.innerWidth < 992) {
			// Reset all sticky styles for mobile
			stickyWrappers.forEach((wrapper) => {
				const inner = wrapper.querySelector(".sticky-image-stick");
				Object.assign(inner.style, {
					position: "relative",
					top: "0",
					left: "0",
					width: "100%",
				});
			});
			return;
		}

		const headerHeight = getHeaderHeight();

		stickyWrappers.forEach((wrapper) => {
			const container = wrapper.closest(".sticky-lft-block");
			const rightSide = container.querySelector(".cl-right");
			const inner = wrapper.querySelector(".sticky-image-stick");
			const image = inner.querySelector("img");

			const containerTop = container.offsetTop;
			const containerHeight = container.offsetHeight;
			const imageHeight = image.offsetHeight;
			const scrollY = window.scrollY;

			const wrapperRect = wrapper.getBoundingClientRect();
			const wrapperLeft = wrapperRect.left + window.scrollX;
			const wrapperWidth = wrapperRect.width;

			const rightSideBottom =
				rightSide.offsetTop + rightSide.offsetHeight;
			const stickyTop = scrollY + headerHeight;
			const stickyBottom = stickyTop + imageHeight;

			const maxFixedTop = rightSideBottom - imageHeight;

			// Stick the image while scrolling within container bounds
			if (stickyTop > containerTop && stickyBottom < rightSideBottom) {
				inner.style.position = "fixed";
				inner.style.top = `${headerHeight}px`;
				inner.style.left = `${wrapperLeft}px`;
				inner.style.width = `${wrapperWidth}px`;
				inner.style.bottom = "auto";
			}
			// Lock image at the bottom of container
			else if (stickyBottom >= rightSideBottom) {
				const offsetBottom =
					rightSideBottom - containerTop - imageHeight;
				inner.style.position = "absolute";
				inner.style.top = `${offsetBottom}px`;
				inner.style.left = `0`;
				inner.style.width = "100%";
				inner.style.bottom = "auto";
			}
			// Reset to top
			else {
				inner.style.position = "absolute";
				inner.style.top = "0";
				inner.style.left = "0";
				inner.style.width = "100%";
				inner.style.bottom = "auto";
			}
		});
	}

	window.addEventListener("scroll", updateStickyPosition);
	window.addEventListener("resize", updateStickyPosition);
	updateStickyPosition(); // Run once on load
});
//end

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

// Tab DropDown
document.addEventListener("DOMContentLoaded", () => {
	const dropdowns = document.querySelectorAll(".tab-dropdown");

	document.addEventListener("click", (event) => {
		let clickedDropdown = null;

		dropdowns.forEach((dropdown) => {
			const toggle = dropdown.querySelector(".dropdown-toggle");

			// If clicked inside this dropdown
			if (dropdown.contains(event.target)) {
				if (event.target === toggle || toggle.contains(event.target)) {
					clickedDropdown = dropdown;
				}
			} else {
				// Close all other dropdowns
				toggle?.setAttribute("aria-expanded", "false");
				dropdown.classList.remove("open");
			}
		});

		// Toggle clicked dropdown
		if (clickedDropdown) {
			const toggle = clickedDropdown.querySelector(".dropdown-toggle");
			const menu = clickedDropdown.querySelector(".dropdown-menu");

			if (toggle && menu) {
				const isExpanded =
					toggle.getAttribute("aria-expanded") === "true";
				toggle.setAttribute("aria-expanded", String(!isExpanded));
				clickedDropdown.classList.toggle("open", !isExpanded);

				// Optional: add staggered animation delay to menu items
				if (!isExpanded) {
					menu.querySelectorAll("li").forEach((item, index) => {
						item.style.animationDelay = `${index * 0.1}s`;
					});
				}
			}
		}
	});

	// Close dropdown when a menu <li> is clicked
	document.querySelectorAll(".dropdown-menu li").forEach((item) => {
		item.addEventListener("click", () => {
			const dropdown = item.closest(".tab-dropdown");
			if (dropdown) {
				dropdown.classList.remove("open");
				const toggle = dropdown.querySelector(".dropdown-toggle");
				if (toggle) {
					toggle.setAttribute("aria-expanded", "false");
				}
			}
		});
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

// Counter js start
document.addEventListener("DOMContentLoaded", function () {
	const counters = document.querySelectorAll(".counter-number .count");
	const speed = 3000; // Duration for all counters to finish counting (in milliseconds)

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

			counter.innerText = currentCount.toLocaleString();

			if (progress < 1) {
				requestAnimationFrame(updateCount);
			} else {
				counter.innerText = target.toLocaleString(); // Ensure the final value is the target
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
//counter js end

// Header Mega menu append js start
const HeadermenuAppend = [
	{ dropdownId: "#mega-dropdown-our-work", menuClass: "our-work" },
	{ dropdownId: "#mega-dropdown-learn", menuClass: "learn" },
];

HeadermenuAppend.forEach(({ dropdownId, menuClass }) => {
	const dropdown = document.querySelector(dropdownId);
	const menuItem = document.querySelector(
		`.header-nav ul.menu li.${menuClass}`,
	);

	if (dropdown && menuItem) {
		menuItem.appendChild(dropdown);

		// Show on hover
		menuItem.addEventListener("mouseenter", () => {
			dropdown.style.display = "block";
			dropdown.style.opacity = "1";
			dropdown.style.overflow = "visible";
			dropdown.style.visibility = "visible";
			document.body.classList.add("megamenu-hover-active");
		});

		// Hide when leaving dropdown or menu item
		const hideDropdown = () => {
			dropdown.style.display = "none";
			dropdown.style.opacity = "0";
			dropdown.style.overflow = "hidden";
			dropdown.style.visibility = "hidden";
			document.body.classList.remove("megamenu-hover-active");
		};

		menuItem.addEventListener("mouseleave", hideDropdown);

		// Also hide when mouse leaves the inner container
		const inner = dropdown.querySelector(".mega-dropdown-inner");
		if (inner) {
			inner.addEventListener("mouseleave", hideDropdown);
		}
	}
});
// Header Mega menu append js End

function applyCardSpacing() {
	const rowFlex = document.querySelector(
		".two-column-text.text-featured-block .row-flex",
	);
	const cards = rowFlex?.querySelectorAll(".text-card-col");

	if (!rowFlex || !cards.length) {
		return;
	}

	// Clear all margin-related classes first
	cards.forEach((card) => {
		card.classList.remove("no-margin-top", "no-margin-bottom");
	});

	// Only apply logic above 991px (2-column layout)
	if (window.innerWidth > 991) {
		const columnCount = 2;
		const totalRows = Math.ceil(cards.length / columnCount);

		cards.forEach((card, index) => {
			const currentRow = Math.floor(index / columnCount);

			// Add margin-top reset to every card in each row
			card.classList.add("no-margin-top");

			// Remove margin-bottom from all but the last row
			if (currentRow < totalRows - 1) {
				card.classList.add("no-margin-bottom");
			}
		});
	}
}

// Run on page load and on window resize
document.addEventListener("DOMContentLoaded", applyCardSpacing);
window.addEventListener("resize", applyCardSpacing);

document.addEventListener("DOMContentLoaded", function () {
	// Search button click search popup js start
	const searchBtn = document.querySelector(".search-btn");
	const searchPopup = document.querySelector(".search-drop");

	if (searchBtn && searchPopup) {
		searchBtn.addEventListener("click", function (e) {
			e.preventDefault(); // prevent default anchor link behavior
			searchPopup.classList.toggle("active-search");
		});
	}

	// Search button click search popup js End

	//hover add class in menu js start
	/**
	 * Adds hover behavior on items:
	 * When hovering one item, add class to all others;
	 * remove class on mouse leave.
	 *
	 * @param {string} selector   - CSS selector for items
	 * @param {string} hoverClass - class to toggle on other items
	 */
	function addHoverEffect(selector, hoverClass) {
		const items = document.querySelectorAll(selector);

		items.forEach((item) => {
			item.addEventListener("mouseenter", () => {
				items.forEach((otherItem) => {
					if (otherItem !== item) {
						otherItem.classList.add(hoverClass);
					}
				});
			});

			item.addEventListener("mouseleave", () => {
				items.forEach((otherItem) => {
					otherItem.classList.remove(hoverClass);
				});
			});
		});
	}

	addHoverEffect(".header-nav .menu > li", "hover-active");
	addHoverEffect(".mega-two .icon-content-col", "active-hover");
	addHoverEffect(".mega-bottom-menu ul#menu-issue > li", "hover-active");
	addHoverEffect(".social-icons a", "active-hover");
	addHoverEffect(".legal-nav nav .menu > li", "active-hover");

	//hover add class in menu js end

	// Tab Content js start
	const tabContainers = document.querySelectorAll(".tabbed-block-content");
	if (!tabContainers.length) {
		return;
	} // Exit early if no tab blocks on the page
	tabContainers.forEach((container) => {
		const tabs = container.querySelectorAll("ul.tabs li");
		const contents = container.querySelectorAll(".tab-content");

		// Skip if either tabs or contents are missing in this container
		if (!tabs.length || !contents.length) {
			return;
		}

		tabs.forEach((tab) => {
			tab.addEventListener("click", function () {
				const tabId = this.getAttribute("data-tab");

				tabs.forEach((t) => t.classList.remove("current"));
				contents.forEach((content) => {
					content.classList.remove("current", "fade-in");
					content.style.opacity = 0;
				});

				this.classList.add("current");

				const activeContent = container.querySelector("#" + tabId);
				if (activeContent) {
					activeContent.classList.add("current");

					// Trigger reflow
					void activeContent.offsetWidth;

					activeContent.classList.add("fade-in");
					activeContent.style.opacity = 1;
				}
			});
		});
	});
	// Tab Content js end
});
function initDropdownMenus() {
	const tabDropdowns = document.querySelectorAll(".tab-dropdown");

	if (!tabDropdowns.length) {
		return;
	}

	tabDropdowns.forEach((tabDropdown) => {
		if (!tabDropdown) {
			return;
		}

		const toggleButton = tabDropdown.querySelector(".dropdown-toggle");
		const dropdownMenu = tabDropdown.querySelector(".dropdown-menu");

		if (!toggleButton || !dropdownMenu) {
			return;
		}

		function positionDropdown() {
			const rect = toggleButton.getBoundingClientRect();
			const scrollTop =
				window.pageYOffset || document.documentElement.scrollTop;
			const scrollLeft =
				window.pageXOffset || document.documentElement.scrollLeft;

			dropdownMenu.style.position = "absolute";
			dropdownMenu.style.top = `${rect.top + rect.height + scrollTop}px`;
			dropdownMenu.style.left = `${rect.left + scrollLeft}px`;
			dropdownMenu.style.width = `${rect.width}px`; // match width to toggle button
		}

		function closeDropdown() {
			toggleButton.setAttribute("aria-expanded", "false");
			dropdownMenu.style.display = "none";
			tabDropdown.classList.remove("open");
			dropdownMenu.classList.remove("open");
		}

		// Toggle dropdown on button click
		toggleButton.addEventListener("click", (event) => {
			event.stopPropagation();

			const isExpanded =
				toggleButton.getAttribute("aria-expanded") === "true";
			toggleButton.setAttribute("aria-expanded", !isExpanded);

			if (!isExpanded) {
				dropdownMenu.style.display = "block";
				tabDropdown.classList.add("open");
				dropdownMenu.classList.add("open");
				positionDropdown();

				const listItems = dropdownMenu.querySelectorAll("li");
				if (listItems.length) {
					listItems.forEach((item, index) => {
						if (item) {
							item.style.animationDelay = `${index * 0.1}s`;
						}
					});
				}
			} else {
				closeDropdown();
			}
		});

		// Close dropdown when clicking outside
		document.addEventListener("click", (event) => {
			if (!tabDropdown.contains(event.target)) {
				closeDropdown();
			}
		});

		// Reposition on window resize
		window.addEventListener("resize", () => {
			if (toggleButton.getAttribute("aria-expanded") === "true") {
				positionDropdown();
			}
		});
	});
}

// Run on DOM ready
document.addEventListener("DOMContentLoaded", initDropdownMenus);

// For ACF block preview / dynamic load
if (typeof window.acf !== "undefined") {
	window.acf.addAction("render_block_preview", initDropdownMenus);
}

//dropdown menu js start
document.addEventListener("DOMContentLoaded", () => {
	// Wait a bit for all DOM elements to load
	setTimeout(() => {
		initDropdowns();
	}, 100);
});

function initDropdowns() {
	const tabDropdowns = document.querySelectorAll(".tab-dropdown");

	tabDropdowns.forEach((tabDropdown) => {
		const toggleButton = tabDropdown.querySelector(".dropdown-toggle");
		if (!toggleButton) {
			return;
		}

		const menuId = toggleButton.getAttribute("aria-controls");

		// Try to find the dropdown menu - it might be outside the tabDropdown
		const dropdownMenu = document.querySelector(
			`ul#${menuId}.dropdown-menu`,
		);

		// If not found, skip this dropdown for now - it might load later
		if (!dropdownMenu) {
			console.warn(`Dropdown menu with ID ${menuId} not found yet`);
			return;
		}

		function positionDropdown() {
			const rect = toggleButton.getBoundingClientRect();
			const scrollTop =
				window.pageYOffset || document.documentElement.scrollTop;
			const scrollLeft =
				window.pageXOffset || document.documentElement.scrollLeft;

			dropdownMenu.style.position = "absolute";
			dropdownMenu.style.top = `${rect.top + rect.height + scrollTop}px`;
			dropdownMenu.style.left = `${rect.left + scrollLeft}px`;
			dropdownMenu.style.width = `${rect.width}px`;
			dropdownMenu.style.zIndex = "1000";
		}

		function closeDropdown() {
			toggleButton.setAttribute("aria-expanded", "false");
			dropdownMenu.style.display = "none";
			tabDropdown.classList.remove("open");
			dropdownMenu.classList.remove("open");
		}

		function closeAllDropdowns() {
			document.querySelectorAll(".dropdown-menu").forEach((menu) => {
				menu.style.display = "none";
				menu.classList.remove("open");
			});
			document.querySelectorAll(".tab-dropdown").forEach((drop) => {
				drop.classList.remove("open");
			});
			document.querySelectorAll(".dropdown-toggle").forEach((btn) => {
				btn.setAttribute("aria-expanded", "false");
			});
		}

		function updateButtonText(selectedText) {
			const buttonTextNode = toggleButton.childNodes[0];
			if (buttonTextNode && buttonTextNode.nodeType === Node.TEXT_NODE) {
				// Get the original button text to extract the prefix
				const originalText = buttonTextNode.textContent;

				// Find the colon to split prefix from current value
				const colonIndex = originalText.indexOf(":");

				if (colonIndex !== -1) {
					// Extract the prefix (everything before and including the colon + space)
					const prefix =
						originalText.substring(0, colonIndex + 1) + " ";
					buttonTextNode.textContent = prefix + selectedText;
				} else {
					// Fallback: if no colon found, just replace the entire text
					buttonTextNode.textContent = selectedText;
				}
			}
		}

		// Toggle dropdown on button click
		toggleButton.addEventListener("click", (event) => {
			event.preventDefault();
			event.stopPropagation();

			const isExpanded =
				toggleButton.getAttribute("aria-expanded") === "true";

			// Close all dropdowns first
			closeAllDropdowns();

			// If this dropdown wasn't expanded, open it
			if (!isExpanded) {
				toggleButton.setAttribute("aria-expanded", "true");
				dropdownMenu.style.display = "block";
				dropdownMenu.classList.add("open");
				tabDropdown.classList.add("open");
				positionDropdown();

				// Add staggered animation delay
				dropdownMenu.querySelectorAll("li").forEach((li, index) => {
					li.style.animationDelay = `${index * 0.1}s`;
				});
			}
		});

		// Handle dropdown item selection - This is the key fix!
		dropdownMenu.addEventListener("click", (event) => {
			// Check if clicked element is a link or inside a link
			const clickedLink = event.target.closest("a");
			if (!clickedLink) {
				return;
			}

			const href = clickedLink.getAttribute("href");
			const selectedTerm = clickedLink.getAttribute("data-term");
			const selectedText = clickedLink.textContent.trim();

			// Check if this is a filter dropdown (has data-term) or a navigation menu
			const isFilterDropdown =
				selectedTerm !== null && selectedTerm !== undefined;
			const isJavascriptVoid =
				href === "javascript:void(0)" || href === "#" || href === "";

			// If it's a real URL and not a filter, update button text then navigate
			if (
				!isJavascriptVoid &&
				!isFilterDropdown &&
				href &&
				href.length > 0
			) {
				// Prevent immediate navigation to show the update first
				event.preventDefault();
				event.stopPropagation();

				// Update button text to show selection
				updateButtonText(selectedText);

				// Close the dropdown
				closeDropdown();

				// Navigate after a short delay to show the text update
				setTimeout(() => {
					window.location.href = href;
				}, 300); // 300ms delay to show the text change

				return;
			}

			// If it's a filter dropdown or javascript:void(0), handle as filter
			if (isFilterDropdown || isJavascriptVoid) {
				event.preventDefault();
				event.stopPropagation();

				// Only update UI if it's a filter dropdown
				if (isFilterDropdown) {
					// Remove active class from all items in this dropdown
					dropdownMenu
						.querySelectorAll("li")
						.forEach((li) => li.classList.remove("active"));

					// Add active class to selected item
					const selectedLi = clickedLink.closest("li");
					if (selectedLi) {
						selectedLi.classList.add("active");
					}

					// Update button text
					updateButtonText(selectedText);
				}

				// Close the dropdown FIRST
				closeDropdown();

				// Only trigger filtering if it's actually a filter dropdown
				if (isFilterDropdown) {
					// Then trigger your AJAX filtering
					console.log(`Selected ${toggleButton.id}:`, selectedTerm);

					// Add your AJAX filtering logic here
					if (typeof filterContent === "function") {
						filterContent(toggleButton.id, selectedTerm);
					}

					// Or trigger a custom event for your AJAX handler
					const filterEvent = new CustomEvent(
						"dropdownFilterChanged",
						{
							detail: {
								filterType: toggleButton.id,
								selectedTerm,
								selectedText,
							},
						},
					);
					document.dispatchEvent(filterEvent);
				}
			}
		});

		// Close dropdown when clicking outside
		document.addEventListener("click", (event) => {
			if (
				!tabDropdown.contains(event.target) &&
				!dropdownMenu.contains(event.target)
			) {
				closeDropdown();
			}
		});

		// Reposition on window resize
		window.addEventListener("resize", () => {
			if (toggleButton.getAttribute("aria-expanded") === "true") {
				positionDropdown();
			}
		});
	});
}

// Re-initialize dropdowns if new ones are added dynamically
function reinitDropdowns() {
	initDropdowns();
}

// Listen for the custom filter event (for your AJAX implementation)
document.addEventListener("dropdownFilterChanged", (event) => {
	const { filterType, selectedTerm, selectedText } = event.detail;
	console.log(
		`Filter changed - Type: ${filterType}, Term: ${selectedTerm}, Text: ${selectedText}`,
	);

	// Add your AJAX call here
	// Example:
	// performAjaxFilter(filterType, selectedTerm);
});

//dropdown menu js end

//Scrolling Text block js start
document.addEventListener("DOMContentLoaded", function () {
	// Find all sticky elements and their related components
	const stickyElements = document.querySelectorAll(".sticky-top-touch");

	if (!stickyElements.length) {
		return;
	}

	stickyElements.forEach(function (subNav) {
		const headerSection = document.querySelector(".header-section");
		const parentSection =
			subNav.closest(".sticky-parent")?.parentElement?.parentElement;
		const stickyParent = subNav.closest(".sticky-parent");

		if (!headerSection || !parentSection || !stickyParent) {
			return;
		}

		let headerHeight = headerSection.offsetHeight;

		function updateStickyWidth() {
			const stickyParentWidth = stickyParent.offsetWidth;
			subNav.style.width = stickyParentWidth + "px";
		}

		function onScroll() {
			if (window.innerWidth <= 991) {
				// Reset styles on smaller screens
				subNav.classList.remove("scrolled");
				subNav.style.position = "";
				subNav.style.top = "";
				subNav.style.bottom = "";
				subNav.style.width = "";
				return;
			}

			const scrollY = window.scrollY || window.pageYOffset;

			const parentTop = parentSection.offsetTop;
			const parentHeight = parentSection.offsetHeight;
			const parentBottom = parentTop + parentHeight;

			const stickyHeight = subNav.offsetHeight;

			if (
				scrollY + headerHeight >= parentTop &&
				scrollY + headerHeight < parentBottom - stickyHeight
			) {
				subNav.classList.add("scrolled");
				subNav.style.position = "fixed";
				subNav.style.top = headerHeight + "px";
				updateStickyWidth();
				subNav.style.bottom = "";
			} else if (scrollY + headerHeight >= parentBottom - stickyHeight) {
				subNav.classList.remove("scrolled");
				subNav.style.position = "absolute";
				subNav.style.top = "";
				subNav.style.bottom = "0";
				updateStickyWidth();
			} else {
				subNav.classList.remove("scrolled");
				subNav.style.position = "";
				subNav.style.top = "";
				subNav.style.bottom = "";
				subNav.style.width = "";
			}
		}

		window.addEventListener("scroll", onScroll);

		// Only add one resize listener that handles all instances
		if (!window.stickyResizeHandlerAdded) {
			window.addEventListener("resize", function () {
				headerHeight = headerSection.offsetHeight;

				stickyElements.forEach(function (nav) {
					if (
						window.innerWidth > 991 &&
						(nav.style.position === "fixed" ||
							nav.style.position === "absolute")
					) {
						const navStickyParent = nav.closest(".sticky-parent");
						if (navStickyParent) {
							nav.style.width =
								navStickyParent.offsetWidth + "px";
						}
					} else {
						nav.style.width = "";
						nav.style.position = "";
						nav.style.top = "";
						nav.style.bottom = "";
						nav.classList.remove("scrolled");
					}

					// Trigger the scroll handler for each element
					const scrollHandler = nav.onScrollHandler;
					if (scrollHandler) {
						scrollHandler();
					}
				});
			});

			window.stickyResizeHandlerAdded = true;
		}

		// Store the onScroll function reference on the element
		subNav.onScrollHandler = onScroll;

		onScroll();
	});
});

//Scrolling Text block js end

document.addEventListener("DOMContentLoaded", () => {
	const galleryGrid = document.querySelector(".gallery-grid");
	const galleryBlock = document.querySelector(".gallery-block");
	const customCursor = document.querySelector(".custom-cursor");

	if (!galleryGrid || !galleryBlock || !customCursor) {
		return;
	}

	calculateBounds(galleryBlock);
});

function calculateBounds(galleryBlock) {
	if (!galleryBlock) {
		return;
	}
	const isMobile = window.innerWidth <= 767;

	let maxX, maxY;

	if (isMobile) {
		maxX = galleryBlock.clientWidth / 0.6;
		maxY = galleryBlock.clientHeight / 1.5;
	} else {
		maxX = galleryBlock.clientWidth / 2;
		maxY = galleryBlock.clientHeight / 1.5;
	}

	console.log("Bounds:", maxX, maxY);
}
//Footer Menu accordion js start
document.querySelectorAll(".footer-nav-title").forEach((title) => {
	title.addEventListener("click", () => {
		if (window.innerWidth <= 991) {
			const parent = title.closest(".footer-nav");

			// Close all others
			document.querySelectorAll(".footer-nav").forEach((nav) => {
				if (nav !== parent) {
					nav.classList.remove("active");
				}
			});

			// Toggle the clicked one
			parent.classList.toggle("active");
		}
	});
});

window.addEventListener("resize", () => {
	if (window.innerWidth > 991) {
		document.querySelectorAll(".footer-nav").forEach((nav) => {
			nav.classList.remove("active");
		});
	}
});
//Footer Menu accordion end start

//Image Gallery js start
document.addEventListener("DOMContentLoaded", () => {
	const galleryGrid = document.querySelector(".gallery-grid");
	const galleryBlock = document.querySelector(".gallery-block");
	const customCursor = document.querySelector(".custom-cursor");

	// Check if required elements exist before proceeding
	if (!galleryGrid || !galleryBlock || !customCursor) {
		return;
	}

	let isDragging = false;
	let startX = 0,
		startY = 0;
	let targetX = 0,
		targetY = 0;
	let hasDragged = false;
	let tween = null;

	let maxX = 0;
	let maxY = 0;

	function calculateBounds() {
		// Additional safety check inside the function
		if (!galleryBlock) {
			return;
		}

		const isMobile = window.innerWidth <= 767;

		if (isMobile) {
			maxX = galleryBlock.clientWidth / 0.6;
			maxY = galleryBlock.clientHeight / 1.5;
		} else {
			maxX = galleryBlock.clientWidth / 2;
			maxY = galleryBlock.clientHeight / 1.5;
		}
	}

	calculateBounds();

	window.addEventListener("resize", () => {
		calculateBounds();
		targetX = Math.max(-maxX, Math.min(targetX, maxX));
		targetY = Math.max(-maxY, Math.min(targetY, maxY));
		updateTransform();
	});

	document.querySelectorAll(".gallery-grid img").forEach((img) => {
		img.setAttribute("draggable", "false");
		img.style.userSelect = "none";
		img.style.pointerEvents = "none";
	});

	function updateTransform() {
		if (tween) {
			tween.kill();
		}
		tween = gsap.to(galleryGrid, {
			x: targetX,
			y: targetY,
			duration: 0.1,
			ease: "power1.out",
		});
	}

	function getEventPosition(e) {
		if (e.type.startsWith("touch")) {
			const touch = e.touches[0] || e.changedTouches[0];
			return { x: touch.clientX, y: touch.clientY };
		}
		return { x: e.clientX, y: e.clientY };
	}

	function startDrag(e) {
		isDragging = true;
		hasDragged = false;
		const pos = getEventPosition(e);
		startX = pos.x;
		startY = pos.y;
		galleryBlock.style.cursor = "grabbing";
		document.body.style.userSelect = "none";
		customCursor.classList.add("dragging");
	}

	function moveDrag(e) {
		if (!isDragging) {
			return;
		}

		const pos = getEventPosition(e);
		const dx = pos.x - startX;
		const dy = pos.y - startY;

		if (Math.abs(dx) > 2 || Math.abs(dy) > 2) {
			hasDragged = true;
		}

		targetX += dx;
		targetY += dy;

		targetX = Math.max(-maxX, Math.min(targetX, maxX));
		targetY = Math.max(-maxY, Math.min(targetY, maxY));

		updateTransform();

		startX = pos.x;
		startY = pos.y;

		// Move custom cursor on drag
		updateCursorPosition(e);
	}

	function endDrag() {
		if (!isDragging) {
			return;
		}
		isDragging = false;
		galleryBlock.style.cursor = "grab";
		document.body.style.userSelect = "";
		customCursor.classList.remove("dragging");
	}

	// Mouse events
	galleryBlock.addEventListener("mousedown", startDrag);
	window.addEventListener("mousemove", moveDrag);
	window.addEventListener("mouseup", endDrag);
	window.addEventListener("mouseleave", endDrag);

	// Touch events
	galleryBlock.addEventListener("touchstart", startDrag, { passive: false });
	window.addEventListener("touchmove", moveDrag, { passive: false });
	window.addEventListener("touchend", endDrag);
	window.addEventListener("touchcancel", endDrag);

	// Reset on click/tap if not dragged
	galleryBlock.addEventListener("click", () => {
		if (hasDragged) {
			hasDragged = false;
			return;
		}
		targetX = 0;
		targetY = 0;
		updateTransform();
	});

	// Initial cursor style
	galleryBlock.style.cursor = "grab";

	// ----------------------------
	// CUSTOM CURSOR HANDLING
	// ----------------------------

	// Follow mouse or touch
	function updateCursorPosition(e) {
		const pos = getEventPosition(e);
		customCursor.style.left = `${pos.x}px`;
		customCursor.style.top = `${pos.y}px`;
	}

	// Show cursor
	function showCursor() {
		customCursor.style.opacity = "1";
	}

	// Hide cursor
	function hideCursor() {
		customCursor.style.opacity = "0";
		customCursor.classList.remove("dragging");
	}

	// Mouse movement for cursor
	galleryBlock.addEventListener("mousemove", updateCursorPosition);
	galleryBlock.addEventListener("mouseenter", showCursor);
	galleryBlock.addEventListener("mouseleave", hideCursor);

	// Touch movement for cursor
	galleryBlock.addEventListener(
		"touchstart",
		(e) => {
			updateCursorPosition(e);
			showCursor();
		},
		{ passive: false },
	);

	galleryBlock.addEventListener("touchmove", updateCursorPosition, {
		passive: false,
	});
	galleryBlock.addEventListener("touchend", hideCursor);
	galleryBlock.addEventListener("touchcancel", hideCursor);

	//staff tab js
	const tabs = document.querySelectorAll("ul.tabs li");
	const contents = document.querySelectorAll(".tab-content");

	tabs.forEach(function (tab) {
		tab.addEventListener("click", function () {
			const tab_id = this.getAttribute("data-tab");

			tabs.forEach((t) => t.classList.remove("current"));

			contents.forEach((content) => {
				content.classList.remove("current", "fade-in");
				content.style.opacity = 0;
			});

			this.classList.add("current");

			const activeContent = document.getElementById(tab_id);
			if (activeContent) {
				activeContent.classList.add("current");

				// Trigger reflow to enable transition
				void activeContent.offsetWidth;

				activeContent.classList.add("fade-in");
				activeContent.style.opacity = 1;
			}
		});
	});
	//staff js end
});

// news list js
// document.addEventListener("DOMContentLoaded", () => {
// 	const tabDropdowns = document.querySelectorAll(".tab-dropdown-filter");

// 	function closeAllDropdowns() {
// 		tabDropdowns.forEach((dropdown) => {
// 			const toggle = dropdown.querySelector(".dropdown-toggle");
// 			const menu = dropdown.querySelector(".dropdown-menu");
// 			if (toggle && menu) {
// 				toggle.setAttribute("aria-expanded", "false");
// 				menu.style.display = "none";
// 				menu.classList.remove("open");
// 				dropdown.classList.remove("open");
// 			}
// 		});
// 	}

// 	function positionDropdown(toggle, menu) {
// 		const rect = toggle.getBoundingClientRect();
// 		const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
// 		const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

// 		menu.style.position = "absolute";
// 		menu.style.top = `${rect.height}px`;
// 		menu.style.left = `${scrollLeft}px`;
// 		menu.style.width = `${rect.width}px`;
// 	}

// 	function getSelectedTerm(taxonomy) {
// 		const active = document.querySelector(`#news-${taxonomy} li.active a`);
// 		return active?.getAttribute("data-term") || "all";
// 	}

// 	function fetchFilteredPosts(newsType, newsTopic) {
// 		const data = new URLSearchParams();
// 		data.append("action", "filter_news_posts");
// 		data.append("news_type", newsType);
// 		data.append("news_topic", newsTopic);

// 		const container = document.querySelector(".filter-content-cards-grid");
// 		if (container) container.innerHTML = "<p>Loading...</p>";

// 		fetch(localVars.ajax_url, {
// 			method: "POST",
// 			headers: { "Content-Type": "application/x-www-form-urlencoded" },
// 			body: data.toString()
// 		})
// 			.then((res) => res.text())
// 			.then((html) => {
// 				if (container) container.innerHTML = html;
// 			})
// 			.catch((err) => {
// 				console.error("AJAX Error", err);
// 			});
// 	}

// 	tabDropdowns.forEach((dropdown) => {
// 		const toggle = dropdown.querySelector(".dropdown-toggle");
// 		const menu = dropdown.querySelector(".dropdown-menu");

// 		if (!toggle || !menu) return;

// 		// Open dropdown
// 		toggle.addEventListener("click", (e) => {
// 			e.stopPropagation();

// 			const isOpen = dropdown.classList.contains("open");
// 			closeAllDropdowns();

// 			if (!isOpen) {
// 				toggle.setAttribute("aria-expanded", "true");
// 				menu.style.display = "block";
// 				menu.classList.add("open");
// 				dropdown.classList.add("open");
// 				positionDropdown(toggle, menu);
// 			}
// 		});

// 		// Click on item
// 		menu.querySelectorAll("a").forEach((link) => {
// 			link.addEventListener("click", (e) => {
// 				e.preventDefault();
// 				const term = link.getAttribute("data-term");
// 				const taxonomy = link.getAttribute("data-taxonomy");
// 				if (!taxonomy || !term) return;

// 				// Update label
// 				const prefix = toggle.textContent.split(":")[0].trim();
// 				toggle.childNodes[0].nodeValue = `${prefix}: ${link.textContent.trim()} `;

// 				// Update active
// 				menu.querySelectorAll("li").forEach((li) => li.classList.remove("active"));
// 				link.closest("li").classList.add("active");

// 				closeAllDropdowns();

// 				// Get current selections and fire AJAX
// 				const selectedType = getSelectedTerm("type");
// 				const selectedTopic = getSelectedTerm("topic");
// 				fetchFilteredPosts(selectedType, selectedTopic);
// 			});
// 		});
// 	});

// 	// Close when clicking outside
// 	document.addEventListener("click", () => {
// 		closeAllDropdowns();
// 	});

// 	window.addEventListener("resize", () => {
// 		const openDropdown = document.querySelector(".tab-dropdown-filter.open");
// 		if (openDropdown) {
// 			const toggle = openDropdown.querySelector(".dropdown-toggle");
// 			const menu = openDropdown.querySelector(".dropdown-menu");
// 			if (toggle && menu) positionDropdown(toggle, menu);
// 		}
// 	});
// });

function setMapHeight() {
	const header = document.querySelector(".header-section");
	const footerSubNav = document.querySelector(".footer-sub-nav");
	const map = document.querySelector(".international-Initiative-map-filter");

	if (header && footerSubNav && map) {
		const headerHeight = header.offsetHeight;
		const footerSubNavHeight = footerSubNav.offsetHeight;
		const viewportHeight = window.innerHeight;

		const mapHeight = viewportHeight - headerHeight - footerSubNavHeight;
		map.style.height = mapHeight + "px";
	}
}

setMapHeight();
window.addEventListener("resize", setMapHeight);
