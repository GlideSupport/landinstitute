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
document.addEventListener( 'click', function( event ) {
	const lightboxElement = event.target.closest( '[data-lightbox]' );
	if ( lightboxElement ) {
		lity( event );
	}
} );
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

			// Check if click is inside this dropdown
			if (dropdown.contains(event.target)) {
				if (event.target === toggle || toggle.contains(event.target)) {
					clickedDropdown = dropdown;
				}
			} else {
				// Close other dropdowns
				toggle?.setAttribute("aria-expanded", "false");
				dropdown.classList.remove("open");
			}
		});

		// Handle toggle for clicked dropdown
		if (clickedDropdown) {
			const toggle = clickedDropdown.querySelector(".dropdown-toggle");
			const menu = clickedDropdown.querySelector(".dropdown-menu");

			if (toggle && menu) {
				const isExpanded = toggle.getAttribute("aria-expanded") === "true";
				toggle.setAttribute("aria-expanded", String(!isExpanded));
				clickedDropdown.classList.toggle("open", !isExpanded);

				if (!isExpanded) {
					menu.querySelectorAll("li").forEach((item, index) => {
						item.style.animationDelay = `${index * 0.1}s`;
					});
				}
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
	const menuItem = document.querySelector(`.header-nav ul.menu li.${menuClass}`);

	if (dropdown && menuItem) {
		menuItem.appendChild(dropdown);

		// Show on hover
		menuItem.addEventListener("mouseenter", () => {
			dropdown.style.display = "block";
			dropdown.style.opacity = "1";
			dropdown.style.overflow = "visible";
			dropdown.style.visibility = "visible";
			document.body.classList.add('megamenu-hover-active');
		});

		// Hide when leaving dropdown or menu item
		const hideDropdown = () => {
			dropdown.style.display = "none";
			dropdown.style.opacity = "0";
			dropdown.style.overflow = "hidden";
			dropdown.style.visibility = "hidden";
			document.body.classList.remove('megamenu-hover-active');
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


document.addEventListener('DOMContentLoaded', function () {

	// Search button click search popup js start
		const searchBtn = document.querySelector('.search-btn');
		const searchPopup = document.querySelector('.search-drop');
	  
		if (searchBtn && searchPopup) {
		  searchBtn.addEventListener('click', function (e) {
			e.preventDefault(); // prevent default anchor link behavior
			searchPopup.classList.toggle('active-search');
		  });
		}

	// Search button click search popup js End

	//hover add class in menu js start
	/**
	 * Adds hover behavior on items: 
	 * When hovering one item, add class to all others; 
	 * remove class on mouse leave.
	 * 
	 * @param {string} selector - CSS selector for items
	 * @param {string} hoverClass - class to toggle on other items
	 */
	function addHoverEffect(selector, hoverClass) {
	  const items = document.querySelectorAll(selector);
  
	  items.forEach(item => {
		item.addEventListener('mouseenter', () => {
		  items.forEach(otherItem => {
			if (otherItem !== item) {
			  otherItem.classList.add(hoverClass);
			}
		  });
		});
  
		item.addEventListener('mouseleave', () => {
		  items.forEach(otherItem => {
			otherItem.classList.remove(hoverClass);
		  });
		});
	  });
	}
  
	addHoverEffect('.header-nav .menu > li', 'hover-active');
	addHoverEffect('.mega-two .icon-content-col', 'active-hover');
	addHoverEffect('.mega-bottom-menu ul#menu-issue > li', 'hover-active');
	addHoverEffect('.social-icons a', 'active-hover');
	
	//hover add class in menu js end

  });
  