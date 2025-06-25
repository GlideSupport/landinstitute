// document.addEventListener("DOMContentLoaded", () => {
// 	const container = document.querySelector(".filter-content-cards-grid");

// 	function getSelectedTerm(taxonomy) {
// 		const active = document.querySelector(`#news-${taxonomy} li.active a`);
// 		return active?.getAttribute("data-term") || "all";
// 	}

// 	function fetchFilteredPosts() {
// 		const selectedType = getSelectedTerm("type");
// 		const selectedTopic = getSelectedTerm("topic");

// 		const data = new URLSearchParams();
// 		data.append("action", "filter_news_posts");
// 		data.append("news_type", selectedType);
// 		data.append("news_topic", selectedTopic);

// 		if (container) container.innerHTML = "<p>Loading...</p>";

// 		fetch(localVars.ajaxurl, {
// 			method: "POST",
// 			headers: { "Content-Type": "application/x-www-form-urlencoded" },
// 			body: data.toString(),
// 		})
// 			.then((res) => res.text())
// 			.then((html) => {
// 				if (container) container.innerHTML = html;
// 			})
// 			.catch((err) => console.error("AJAX Error:", err));
// 	}

// 	// Listen to dropdown changes
// 	document.querySelectorAll(".dropdown-menu a").forEach((link) => {
// 		link.addEventListener("click", (e) => {
// 			e.preventDefault();

// 			const taxonomy = link.getAttribute("data-taxonomy");
// 			const term = link.getAttribute("data-term");

// 			if (!taxonomy || !term) return;

// 			// Mark active
// 			link.closest("ul").querySelectorAll("li").forEach((li) => li.classList.remove("active"));
// 			link.closest("li").classList.add("active");

// 			fetchFilteredPosts();
// 		});
// 	});
// });