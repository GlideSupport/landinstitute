<?php

/**
 * Template Name: Event Template
 * Template Post Type: page
 *
 * This template is for displaying News page.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

// Include header.
get_header();
list( $bst_var_post_id, $bst_fields, $bst_option_fields ) = BaseTheme::defaults();

$news_temp_kicker_text = $bst_fields['news_temp_kicker_text'] ?? null;
$news_temp_headline_text = $bst_fields['news_temp_headline_text'] ?? null;
$news_headline_check  = BaseTheme::headline_check($news_temp_headline_text);
?>

<div id="page-section" class="page-section">
	<?php
		global $wp_query;
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			// Include specific template for the content.
			get_template_part( 'partials/content', 'page' );
		}
	} 
	?>



<style>
 .event-image {
	border-bottom: none;
	position: relative;
	// width: 280px;
	width: 100%;
	overflow: hidden;
	border-radius: 6px;

	&:hover {

		a,
		a:visited {
			transform: scale(1.05);
		}
	}

	.ticket-tag.sold {
		position: absolute;
		top: 16px;
		left: 16px;

		@include font(gthm, bold);
	}

	.ticket-tag.limited {
		position: absolute;
		top: 16px;
		left: 16px;

		@include font(gthm, bold);
	}

	a,
	a:visited {
		background-image: url(../assets/img/uploads/event-list-img-1.webp);
		transition: all 0.3s ease-in-out;
		// height: 364px;
		padding-top: 131%;
		display: block;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
		border-radius: 6px;

	}
}

.event-column-detail {
	position: relative;
	margin-top: 15px;

	min-height: 215px;

	a {
		text-decoration: none;
		border: 0;
	}

	h3 {

		a {
			margin-top: 4px;

			color: map-get($map: $colors, $key: white);
		}
	}

	h3 {

		font-size: 23px;
		margin-bottom: 20px;

	}

	.event-tag {
		color: map-get($map: $colors, $key: white60);
		font-size: 13px;
		line-height: 1.5;
		text-transform: uppercase;

		@include font(gthm, bold);
		padding-bottom: 0;
		margin-bottom: 4px;
		display: block;
	}

	.event-date {
		margin-top: 20px;
		color: map-get($map: $colors, $key: white);
		font-size: 16px;
		text-transform: uppercase;

		@include font(gthm, bold);
	}
}

.ct-sixth-col .tooltip {
	left: auto;
	right: calc(100% + 12px);
}

.event-column {


	&:nth-child(n+5) {
		margin-top: 96px;
	}


	a,
	a:visited {
		border: 0;
	}


}

.event-button {


	position: absolute;
	left: 0;
	bottom: 0;

	a,
	a:visited {
		color: map-get($map: $colors, $key: white);
		font-size: 15px;
		margin-right: 0;



	}

}

a.upgrade-btn,
a.upgrade-btn:visited {
	background-color: transparent;
	text-align: left;
	margin: 0;
	padding: 0;
	padding-right: 20px;

	color: map-get($map: $colors, $key: white70);
	position: absolute;
	bottom: -34px;

	&:hover {
		color: map-get($map: $colors, $key: white);
	}
}

.upgrade-arrow {
	width: 15px;
	height: 15px;
	background-image: url(../img/upgrade-arrow.svg);
	background-repeat: no-repeat;
	background-position: right center;
	background-size: 13px;
}

.tooltip-tags {

	.ticket-tag {
		display: none;
	}

	a.upgrade-btn,
	a.upgrade-btn:visited {
		font-size: 13px;
		color: map-get($map: $colors, $key: tblack80);
		position: initial;
		text-transform: uppercase;
		border-bottom: 0;

	}

	.upgrade-arrow {
		background-image: url(../img/upgrade-arrow-tblack.svg);
	}
}

.event-nav {
	align-items: center;
	margin-bottom: 72px;
}

.events-nav-left {
	display: flex;


	&.hide {
		display: none;
	}

	a.button,
	a.button:visited {
		border: 0;
		font-size: 15px;
		background-color: map-get($map: $colors, $key: white15);
		padding: 13px 24px;
		color: map-get($map: $colors, $key: white60);
		border-radius: 6px;
		margin-right: 8px;
		display: flex;
		align-items: center;
		text-transform: uppercase;

		&.active {
			background-color: map-get($map: $colors, $key: white);
			color: map-get($map: $colors, $key: tblack);
		}

		span {
			filter: none;
			width: 8px;
			height: 8px;
			display: inline-block;
			border-radius: 100%;
			margin-right: 6px;
			margin-top: -4px;

			&.red {
				background-color: map-get($map: $colors, $key: red);
			}

			&.green {
				background-color: map-get($map: $colors, $key: green);
			}

			&.lblue {
				background-color: map-get($map: $colors, $key: lblue);
			}

			&.purple {
				background-color: map-get($map: $colors, $key: purple);
			}
		}

		&:hover {
			background-color: map-get($map: $colors, $key: white);
			color: map-get($map: $colors, $key: black);
			transition: all 0.1s ease-in-out;
		}
	}
}

.event-single {
	max-width: 440px;
}

.event-teaser-slider {
	max-height: 504px;

	.owl-carousel .owl-item {
		display: left !important;
	}

	.ets-content {
		position: absolute;
		width: 100%;
		padding: 0 30px;
		box-sizing: border-box;
		left: 0;
		bottom: 36px;
	}
}

.events-nav-right {
	display: flex;
	line-height: 1;
	align-items: flex-start;

	span.btn-icon {
		display: none;
		line-height: 0.65;
	}

	span.btn-text {
		cursor: pointer;
	}
}

.icon-btn,
a.icon-btn,
a.icon-btn:visited {
	padding: 12px 24px 14px;
	border: 1px solid map-get($map: $colors, $key: white20) !important;
	color: map-get($map: $colors, $key: white);
	transition: all ease-in-out 0.3s;
	border-radius: 0;
	cursor: pointer;

	&.active {
		border-color: map-get($map: $colors, $key:silver) !important;

		.btn-text {
			color: map-get($map: $colors, $key:white) !important;
		}
	}

	&:first-child {
		border-radius: 6px 0 0 6px !important;
		margin-right: -1px;
	}

	&:last-child {
		border-radius: 0 6px 6px 0 !important;
		margin-left: -1px;
	}

	&:hover {

		.btn-text {
			color: map-get($map: $colors, $key: white);
		}
	}

	&.active {
		border: 1px solid map-get($map: $colors, $key: white) !important;

		.btn-text {
			color: map-get($map: $colors, $key: white);
		}
	}

	.btn-text {
		transition: all 0.1s ease-in-out;
		font-size: 15px;
		padding: 0;
		margin-right: 0;
		box-sizing: border-box;
		text-transform: uppercase;
		color: map-get($map: $colors, $key: white40);
		text-transform: uppercase;

		@include font(gthm,bold);
	}

	span.btn-icon {
		display: none;
	}
}

.event-main-heading {

	h1 {
		margin-bottom: 48px;
	}
}


.events-container {

	.ticket-tag {
		margin-bottom: 20px;
	}

	&.event-variation2 {

		.event-column {
			margin-bottom: 30px !important;

			&:nth-child(n+5) {
				margin-top: 0;
			}
		}

		.event-secondary-heading {
			background: linear-gradient(126.36deg, rgba(137, 138, 141, 0.2) -15.3%, rgba(137, 138, 141, 0) 153.94%);
			box-shadow: inset 0 0 0 1px rgb(255 255 255 / 6%);
			position: relative;
			margin-top: 96px;
			border-radius: 8px;

			&::after {
				background-image: url(../img/black-cut-36.svg);
				background-repeat: no-repeat;
				width: 36px;
				height: 36px;
				right: 0;
				bottom: 0;
				content: "";
				position: absolute;
				display: block;
			}

			&:first-child {
				margin-top: 72px;
			}

			.heading-3 {
				margin-bottom: 36px;
			}

			span {
				padding: 30px 0;
				margin: 0 36px;
				border-top: 1px solid map-get($map: $colors, $key: red);

				display: inline-block;
			}

		}

		.event-image {
			width: 180px;
			margin-right: 20px;
			border-bottom: none;
			transition: transform 0.3s ease-in-out;
			overflow: hidden;

			a,
			a:visited {
				background-image: url(../assets/img/uploads/event-list-img-1.webp);
				width: 180px;
				height: 234px;
				padding: 0;
				display: block;
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
				transition: all 0.3s ease-in-out;
				transform: scale(1);

				&:hover {
					transform: scale(1.05);
				}
			}
		}

		.event-column-detail {
			width: calc(100% - 200px);
			align-items: center;
		}

		.event-button {
			position: initial;
		}
	}
}


.event-main-heading {

	h3 {
		margin-bottom: 48px;
		letter-spacing: -2.3px;
	}
}

.calendar {
	margin-bottom: 72px;
}

.calendar-ctn {

	h2 {
		font-size: 24px;
	}

	table {
		margin-bottom: 0;
		border: none !important;
		text-align: left !important;

		thead {
			border-bottom: 16px solid transparent;
		}

		td,
		th {
			padding: 0 !important;
			vertical-align: top;
			border: none;
		}

		tr {
			border-bottom: 0;

			&.fc-scrollgrid-section-header {
				border-bottom: 16px solid transparent;
			}
		}

		td {
			border: none !important;

			&:last-child {
				border-right: none !important;
			}
		}

	}

	.fc .fc-daygrid-day-frame {
		background-image: url(../img/day-bg-shape.svg);
		background-repeat: no-repeat;
		background-size: cover;
		background-position: top left;
	}

	.fc .fc-daygrid-day-bottom {
		padding: 0 !important;
	}

	.fc .fc-non-business,
	.fc .fc-daygrid-day.fc-day-today {
		background-color: transparent;
	}


	.fc-scrollgrid-sync-table {

		tr {
			// border-bottom: 8px solid transparent;

			&:nth-last-child(2) {
				border-bottom: none;
			}

			&:last-child {
				display: none !important;
			}
		}

		td {
			border-right: 8px solid transparent !important;
			border-bottom: 8px solid transparent !important;

			&:last-child {
				border-right: none;
			}
		}
	}

	.fc .fc-daygrid-day-top {
		flex-direction: revert;
		padding: 11px 14px;
	}


}


td.fc-other-month .fc-day-number {
	display: none;
}

.calendar-date {
	margin-bottom: 8px;
	transition: all 0.3s ease-in-out;
}

.fc-scrollgrid-sync-inner {
	font-size: 15px;
	line-height: 0.5;
	text-align: left;

	a,
	a:visited {
		text-transform: uppercase;
		color: map-get($map: $colors, $key: white40);
		border: none;
		line-height: 1.2;
		padding: 0;
	}
}

.red {
	background-color: map-get($map: $colors, $key: red);
}

.lblue {
	background-color: map-get($map: $colors, $key: lblue);
}

.green {
	background-color: map-get($map: $colors, $key: green);
}

.purple {
	background-color: map-get($map: $colors, $key: purple);
}


.tooltip {
	background-color: map-get($map: $colors, $key: white) !important;
	z-index: 999;
	width: 328px;
	padding: 20px 19px 0 12px;
	box-sizing: border-box;
	margin-left: -12px;
	position: absolute;
	top: 0;
	left: calc(100% + 25px);
	border-radius: 4px 4px 0 0;


	.tooltip-items {
		display: flex;
		justify-content: space-between;


		a,
		a:visited {
			border-bottom: 0 !important;
		}

		.tooltip-content {
			width: calc(100% - 100px);
			line-height: 0.65;

			a.button {
				padding: 10px 16px;
				font-size: 13px;
			}
		}
	}

}

.tooltip-bottom {
	height: 26px;
	position: absolute;
	width: 100%;
	bottom: -21px;
	left: 0;
	background-image: url(../../assets/img/tooltip-bottom-shape.svg);
	background-size: 100% 100%;
	background-repeat: no-repeat;
	border-radius: 0 0 0 4px;

}

.tooltip-image {
	width: 80px;
	height: 106px;
	margin-right: 20px;
	line-height: 0.65;
	border-radius: 5px;

	img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		border-radius: 5px;
	}
}

.tooltip-heading {

	&,
	a,
	a:visited {
		color: map-get($map: $colors, $key: tblack);
		line-height: 1;
		font-size: 18px;
		margin: 6px 0;

		@include font(gthm, black);
	}
}

.tooltip-tags {
	text-transform: uppercase;
}

.tooltip-date {

	&,
	a,
	a:visited {
		color: map-get($map: $colors, $key: tblack);
		font-size: 13px;
		line-height: 1.2;
		margin-bottom: 16px;

		@include font(gthm, bold);
	}
}

.event-list-ctn {

	.event-column-detail {
		margin-top: 0;
	}

	.upgrade-button {
		position: absolute;
		width: 100%;
		bottom: 30px;
	}
}

.fc-event {
	display: grid !important;

	span {
		white-space: normal !important;
		display: initial !important;
	}
}

span.close-event-btn {
	position: absolute;
	right: 3px;
	top: 4px;
	line-height: 0.6;
	padding: 8px;
	background-color: rgba(208, 212, 213, 0.5);
	border-radius: 4px;
	width: 24px;
	height: 24px;
	box-sizing: border-box;
	cursor: pointer;

	img {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		margin: auto;
	}
}

/* New  */
.calendar-date {
	margin-bottom: 8px;
}

.calendar-day-name-row {
	margin-bottom: 16px;
}

.calendar-day-name {
	float: left;
	margin-right: 1.2%;
	width: 13%;

	@include font(gthm, bold);

	font-size: 15px;
	text-transform: uppercase;
	color: map-get($map: $colors, $key: white40);

	&:nth-child(7n + 7) {
		margin-right: 0;
	}

	span.mobile-show {
		display: none;
	}
}


.calendar-month {
	margin-bottom: 36px;

	h3 {
		margin-bottom: 0;
	}
}

.event-calendar-row {
	margin-bottom: 72px;
}

.calendar-days-row {
	display: flex;
	align-items: flex-start;
	justify-content: flex-start;
	flex-wrap: wrap;
	// overflow: hidden;

}

.tooltip .tooltip-inner {
	margin-top: 10px;
}

.calendar-event.ct-first-day {
	z-index: 3;
}

.calendar-column {
	margin-right: 1.03%;
	width: 13.4%;
	font-size: 18px;
  color:#000;
	/* color: map-get($map: $colors, $key: white40); */
	/* background-color: map-get($map: $colors, $key: white05); */
	box-sizing: border-box;
	padding: 11px 14px 4px;
	min-height: 107px;
	min-height: 122px;
	margin-bottom: 12px;
	transition: all 0.3s ease-in-out;

	position: relative;
	border-radius: 5px;

	&::after {
		content: "";
		width: 20px;
		height: 20px;
		position: absolute;
		right: 0;
		bottom: 0;
		background-image: url(../../assets/img/black-cut-20.svg);
		background-repeat: no-repeat;
		background-position: center center;
		background-size: cover;
	}

	&:nth-child(7n + 7) {
		margin-right: 0;
	}

	&.active {
		color: map-get($map: $colors, $key: white);
	}

	.more-btn {
		font-size: 13px;
	}

	&.col-has-event {
		cursor: pointer;


		&:hover {
			background-color: white !important;

			.calendar-date {
				color: map-get($map: $colors, $key: black);
			}
		}
	}
}

.ct-last-day-in-month {
	width: calc(100% + 12px) !important;

	&.ct-has-event-in-next-month {
		width: calc(100% + 20px) !important;
	}
}

.ct-first-day-in-month {
	margin-left: -15px !important;
	width: calc(100% + 60px) !important;

	&.ct-seventh-col-item {
		margin-left: inherit !important;
		width: calc(100% + 12px) !important;
	}
}

.ct-seventh-col {

	.tooltip {
		left: auto;
		right: calc(100% + 15px);
	}


}

.ct-seventh-col {

	.calendar-event {
		width: calc(100% + 20px);
		@media screen and (max-width:767px) {
			width: calc(100% + 10px);
		}
	}

}

.ct-hidden-items {
	opacity: 0;
}

.calendar-event.ct-last-day {
	width: calc(100% + 12px);
}

.calendar-event {
	min-height: 19px;
	color: map-get($map: $colors, $key: white);
	width: calc(100% + 45px);
	font-size: 12px;
	line-height: 1.2;
	box-sizing: border-box;
	padding:3px 4px 1px;
	border-radius: 3px;
	margin: 0 -6px 4px;
	position: relative;
	cursor: pointer;
	white-space: nowrap;
	z-index: 2;
	overflow: hidden;

	&:last-child {
		margin-bottom: 0;
	}
	marquee {
		line-height: 11px;
	}
	a,
	a:visited {
		display: flex;
		align-items: center;
		border-bottom: 0;

		&::before,
		&::after {
			display: none;
		}
	}
}


.event-hover-popup {
	width: 175px;
	box-sizing: border-box;
	background-color: map-get($map: $colors, $key: white);

	padding: 8px;
	position: absolute;
	opacity: 0;
	top: -8px;
	left: -8px;
	visibility: hidden;
	transition: all 0.3s ease-in-out;

	.calendar-event-title {
		color: map-get($map: $colors, $key: black);
	}

	.event-buttons {
		margin-top: 12px;

		a {
			display: block;
			color: map-get($map: $colors, $key: black);
			margin-right: 0;

			&.get-tickets {
				background-color: transparent;
				border: 1px solid map-get($map: $colors, $key: black);
				padding: 7px 20px 6px 52px;

				span {
					top: 3px;
				}

				&:hover {
					border: 1px solid map-get($map: $colors, $key: verde);
					color: map-get($map: $colors, $key: black);

					img {
						filter: initial;
					}
				}
			}

			&.read-more {
				text-transform: uppercase;
				text-align: center;
				margin-top: 6px;
				border: 1px solid map-get($map: $colors, $key: black);


				padding: 7px 20px 6px 20px;

				&:hover {
					border: 1px solid map-get($map: $colors, $key: verde);
					color: map-get($map: $colors, $key: black);
				}
			}
		}
	}
}

.event-teaser-slider img {
	max-height: 500px;
}

.g {
	width: 100%;
}
// .g {
// 	border-radius: 6px;
// }

// .g-single {
// 	line-height: 0.65;
// 	border-radius: 6px;

// 	a,
// 	a:visited {
// 		border-bottom: 0 !important;
// 		padding: 0 !important;
// 		border-radius: 6px;
// 		line-height: 0.65;
// 		display: block;
// 		z-index: 5;

// 		&:hover {
// 			transform: scale(1);

// 			img {
// 				// transform: scale(1.05);
// 			}
// 		}
// 	}

// 	img {
// 		border-radius: 6px;
// 		transform: scale(1);
// 		transition: all 0.3s;
// 	}
// }

.event-image-bg {
	max-height: 500px;
}


.white-bg-var .reset-bg {
	padding-top: 63.295%;
}

.news-teaser-variation-3 .reset-bg {
	padding-top: 65.788%;
}

.var-two-cols {

	.featured-news {

		.bg-event-img {
			padding-top: 62.136%;
		}
	}
}

.var-two-cols {

	.heading-4 {
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	.feature-content {

		p {
			display: -webkit-box;
			-webkit-line-clamp: 3;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}
	}
}

.bg-event-img {
	padding-top: 65.92%;
	box-sizing: border-box;
}

.news-image {
	width: 132px;
}

.news-teaser-variation-2 {

	.news-teaser-right .reset-bg {
		height: 84px;
	}

	.news-teaser-left {

		.reset-bg {
			height: 100%;
		}
	}
}

.event-grid-ctn .event-button {
	line-height: 0.65;
}

.events-grid-ad {

	.event-button {

		a,
		a:visited {

			&.gofollow {

				@include font(gthm, bold, family weight);
				box-sizing: border-box;
				position: relative;
				display: inline-block;
				overflow: hidden;
				padding: 13px 23px;
				text-decoration: none;
				background-color: map-get($map: $base_colors, $key: theme_btn_bgcolor);
				color: map-get($map: $base_colors, $key: theme_btn_color);
				border: none;
				transition: all 0.3s ease-out;
				margin-right: 9px;
				text-align: center;
				border-radius: 6px;
				letter-spacing: -0.02em;
				text-transform: uppercase;
				line-height: 1.2;
				z-index: 2;
				font-size: 15px;

				&:hover {
					background-color: map-get($map: $base_colors, $key: theme_btn_bgcolor_hover);
					color: map-get($map: $base_colors, $key: theme_btn_color_hover);
				}
			}

		}
	}
}

.calendar-column.col-has-event:hover span.more-btn {
	color: map-get($map: $colors, $key: tblack);
}

</style>
<section id="hero-section" class="hero-section hero-section-default hero-alongside-standard">
	<!-- hero start -->
	<div class="bg-pattern">
		<img src="<?php echo get_template_directory_uri()?>/assets/src/images/TLI-Pattern-Repair-SkyBlue-stickys.jpg" width="" height="" alt="" />
	</div>
	<div class="hero-default has-border-bottom">
		<div class="wrapper">
			<div class="hero-alongside-block">
				<div class="col-left bg-lime-green">
					<div class="hero-content">
						<?php if($news_temp_kicker_text): ?>
							<div class="ui-eyebrow-20-18-regular">
								<?php echo html_entity_decode($news_temp_kicker_text); ?>
							</div>
							<div class="gl-s20"></div>
						<?php endif; ?>
							<?php if($news_headline_check): ?>
							<?php echo BaseTheme::headline($news_temp_headline_text, 'heading-1 mb-0 block-title'); ?>
							<div class="gl-s96"></div>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-right">
					<div class="bg-pattern">
						<img src="<?php echo get_template_directory_uri()?>/assets/src/images/TLI-Pattern-Repair-SkyBlue-stickys.jpg" width="" height="" alt="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style>

.calendar-main {
  grid-template-columns: repeat(7, 1fr); /* 7 days in a week */
  gap: 1px;
}
.calendar {
  display: grid;
  grid-template-columns: repeat(7, 1fr); /* 7 days in a week */
  gap: 1px;
}

.calendar-day {
  min-height: 100px;
  border: 1px solid #ccc;
  position: relative;
}
.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
}

.calendar-day {
    min-height: 100px;
    border: 1px solid #ccc;
    position: relative;
}

.event-group {
    display: block;
    background-color: #fce5a0;
    padding: 4px 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border-radius: 4px;
    font-size: 13px;
    margin-top: 4px;
}

.event {
    color: #333;
    text-decoration: none;
    font-weight: bold;
}

.custom-tooltip {
  position: absolute;
  background: #333;
  color: #fff;
  padding: 6px 10px;
  border-radius: 4px;
  font-size: 12px;
  z-index: 1000;
  white-space: nowrap;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
.calendar-day {
  position: relative; /* needed for absolute event bars */
}
.event-bar {
  pointer-events: auto;
  cursor: pointer;
}
</style>
<?php
$eventsview = isset($_GET['eventsview']) ? $_GET['eventsview'] : 'list'; // default to 'list'
?>


<section class="container-1280 bg-base-cream">
				<div class="wrapper">
					<div class="event-teaser-list-block has-border-bottom">
						<div class="event-teaser-list-row">
							<div class="category-filter">
								<ul class="tabs">
									<a href="<?php echo site_url(); ?>/events/?eventsview=list" class="tab-link <?php echo ($eventsview === 'list') ? 'current' : ''; ?>" data-tab="tab-1">List View</a>
									<a href="<?php echo site_url(); ?>/events/?eventsview=calendar"  class="tab-link <?php echo ($eventsview === 'calendar') ? '' : ''; ?>" data-tab="tab-2">Calendar View</a>
								</ul>
							</div>
            <?php 

             $calenderstyle="display:none";
              $customstyle="";
                 // Avoid undefined index warning
              if (isset($_GET['eventsview']) && $_GET['eventsview'] === 'calendar') {
                  $customstyle="display:none";
                   $calenderstyle="display:block";
              }
              ?>
						 <div id="event-list-view" style="<?php echo $customstyle; ?>">
              <div id="event-list-main-div" class="event-list-main-div">
						  <?php

              $eventargs = array(
                  'post_type'      => 'event',
                  'post_status'    => 'publish',
                  'posts_per_page' => 10,
                  'orderby'        => 'meta_value',
                  'meta_key'       => 'li_cpt_event_start_date',
                  'order'          => 'ASC'
              );

              // Avoid undefined index warning
               if (isset($_GET['eventsview']) && $_GET['eventsview'] === 'calendar') {
          $eventargs['posts_per_page'] = -1;

          $eventargs['meta_query'] = [
              'relation' => 'AND',
              [
                  'key'     => 'li_cpt_event_start_date',
                  'value'   => date('Ymd'),
                  'compare' => '>=',
                  'type'    => 'NUMERIC'
              ],
              [
                  'key'     => 'li_cpt_event_end_date',
                  'value'   => date('Ymd'),
                  'compare' => '>=',
                  'type'    => 'NUMERIC'
              ]
          ];
      }

              $event_query = new WP_Query($eventargs);

              							


							if ($event_query->have_posts()):
                  while ($event_query->have_posts()): $event_query->the_post();
                      $start_date = get_field('li_cpt_event_start_date');
                      $end_date   = get_field('li_cpt_event_end_date');

					   $image  = "https://landinstdev.wpenginepowered.com/wp-content/uploads/demo.webp";
					   if(get_the_post_thumbnail_url(get_the_ID(), 'medium')){
						$image      = get_the_post_thumbnail_url(get_the_ID(), 'medium');
					   }
                      

					 

                      $excerpt    = get_the_excerpt();
                      $url        = get_permalink();

                      // Pass variables to template part
                      set_query_var('start_date', $start_date);
                      set_query_var('end_date', $end_date);
                      set_query_var('image', $image);
                      set_query_var('excerpt', $excerpt);
                      set_query_var('url', $url);

                      get_template_part('partials/content','event-list');
                  endwhile;
              else:
                  echo '<p>No events found.</p>';
              endif;
              wp_reset_postdata();
              ?>
              </div>
                    <a id="load-more-events" class="site-btn btn-sunflower-yellow sm-btn " data-page="1">Load More</a>

						</div>

						<div id="event-calendar-view" class="event-teaser-list-col" style="<?php echo $calenderstyle; ?>">

						<!-- Calender View Start -->
			<div class="events-ctn event-calendar-ctn calendar-ctn">
				<?php
                      if (isset($_GET['eventsview']) && $_GET['eventsview'] === 'calendar') {

				$key              = 0;
				$events_data_raw  = array();
				$dates_raw        = array();
				$dates            = array();
				$events_unordered = array();
				$events           = array();
				if ( $event_query->have_posts() ) {
					while ( $event_query->have_posts() ) {
						$event_query->the_post();
						$pID                       = get_the_ID();
						$post_fields               = get_fields( $pID );
						$cota_cpt_event_title      =  get_the_title( $pID);
						$cota_cpt_event_start_date = get_field('li_cpt_event_start_date');
						$cota_cpt_event_end_date   =  get_field('li_cpt_event_end_date');
						$final_date                = date_formatting( $cota_cpt_event_start_date, $cota_cpt_event_end_date );
						if ( $cota_cpt_event_start_date == '' || $cota_cpt_event_end_date == '' ) {
							continue;
						}
						$events_data_raw[ $key ]['post_title'] = $cota_cpt_event_title;
						$events_data_raw[ $key ]['pID']        = $pID;
						$events_data_raw[ $key ]['start_date'] = $cota_cpt_event_start_date;
						$events_data_raw[ $key ]['end_date']   = $cota_cpt_event_end_date;

						$key++;
					}
					}else{
				echo '<p>No events found.</p>';

			}
				foreach ( $events_data_raw as $key => $raw_data ) {
					$period     = array();
					$time       = strtotime( $raw_data['end_date'] );
					$final      = date( 'Y-m-d', strtotime( '+1 day', $time ) );
					$period_raw = new DatePeriod(
						new DateTime( $raw_data['start_date'] ),
						new DateInterval( 'P1D' ),
						new DateTime( $final )
					);
					$buffer     = array();
					foreach ( $period_raw as $k => $value ) {
						$month         = date( 'F Y', strtotime( $value->format( 'Y-m-d' ) ) );
						$current_month = date( 'F Y' );
						if ( strtotime( $month ) < strtotime( $current_month ) ) {
							continue;
						}
						$current_date = date( 'Y-m-d' );
						if ( strtotime( $value->format( 'Y-m-d' ) ) < strtotime( $current_date ) ) {
							continue;
						}

						$period[ $k ]['date']    = $value->format( 'Y-m-d' );
						$period[ $k ]['post_id'] = $raw_data['pID'];
						if ( in_array( $raw_data['pID'], $buffer ) ) {
							$period[ $k ]['multiple'] = true;
						} else {
							$period[ $k ]['multiple'] = false;
						}
						$period[ $k ]['current-length'] = event_current_length( $buffer, $raw_data['pID'] );
						$period[ $k ]['length']         = event_length( $events_data_raw, $raw_data['pID'] );
						$buffer[]                       = $raw_data['pID'];
					}
					$dates_raw[ $key ] = $period;
					// echo '<pre>'; var_dump($periods); echo '</pre>';
				}
				$dates_raw = array_flatten( $dates_raw );
				$dates_raw = sort_array( $dates_raw, 'length' );
				foreach ( $dates_raw  as $key => $date ) {
					$month                              = date( 'F Y', strtotime( $date['date'] ) );
					$dates[ $month ][ $date['date'] ][] = $date;
				}
				foreach ( $dates as $key => $value ) {
					$date_list = date_list( $key );
					$date_keys = array_keys( $value );
					foreach ( $date_list as $date ) {
						if ( ! in_array( $date, $date_keys ) ) {
							$events_unordered[ $key ][ $date ] = null;
						} else {
							$events_unordered[ $key ][ $date ] = $value[ $date ];
						}
					}
				}
				$months = month_sort( array_keys( $events_unordered ) );
				foreach ( $months as $month ) {
					$events[ $month ] = $events_unordered[ $month ];
				}
				?>
				<?php
				$number = 1;
				$old    = array(); foreach ( $events as $month => $days ) {
					?>
				<div class="event-calendar-row ct-<?php echo number_to_words( $number ); ?>-month">
					<div class="calendar-month">
						<h3 class="heading-5"><?php echo $month; ?></h3>
					</div>
					<div class="calendar-day-name-row">
						<div class="calendar-day-name">
							<span class="mobile-hide"><?php _e( 'su', 'cota_td' ); ?></span> <span
								class="mobile-show"><?php _e( 's', 'cota_td' ); ?></span>
						</div>
						<div class="calendar-day-name">
							<span class="mobile-hide"><?php _e( 'Mo', 'cota_td' ); ?></span> <span
								class="mobile-show"><?php _e( 'm', 'cota_td' ); ?></span>
						</div>
						<div class="calendar-day-name">
							<span class="mobile-hide"><?php _e( 'tu', 'cota_td' ); ?></span> <span
								class="mobile-show"><?php _e( 't', 'cota_td' ); ?></span>
						</div>
						<div class="calendar-day-name">
							<span class="mobile-hide"><?php _e( 'we', 'cota_td' ); ?></span> <span
								class="mobile-show"><?php _e( 'w', 'cota_td' ); ?></span>
						</div>
						<div class="calendar-day-name">
							<span class="mobile-hide"><?php _e( 'th', 'cota_td' ); ?></span> <span
								class="mobile-show"><?php _e( 't', 'cota_td' ); ?></span>
						</div>
						<div class="calendar-day-name">
							<span class="mobile-hide"><?php _e( 'fr', 'cota_td' ); ?></span> <span
								class="mobile-show"><?php _e( 'f', 'cota_td' ); ?></span>
						</div>
						<div class="calendar-day-name">
							<span class="mobile-hide"><?php _e( 'sa', 'cota_td' ); ?></span> <span
								class="mobile-show"><?php _e( 's', 'cota_td' ); ?></span>
						</div>
						<div class="clear"></div>
					</div>
					<div class="calendar-days-row">
						<?php
							$sure_arr  = array( 0, 3, 3, 6, 3, 6, 1, 4, 0, 3, 6, 1 );
							$month_arr = explode( ' ', $month );
							$old_days  = array();
							$i         = 1;
						foreach ( $days as $date => $events ) {
							$old_day_class = '';
							$row_class     = '';
							$day           = date( 'd', strtotime( $date ) );

							if ( $i < 8 ) {
								$row_class = 'ct-first-row';
							} elseif ( $i >= 8 && $i < 15 ) {
								$row_class = 'ct-second-row';
							} elseif ( $i >= 15 && $i < 22 ) {
								$row_class = 'ct-third-row';
							} elseif ( $i >= 22 && $i < 29 ) {
								$row_class = 'ct-forth-row';
							} elseif ( $i >= 29 && $i < 32 ) {
								$row_class = 'ct-firth-row';
							}
							$col_arr   = array(
								array( 1, 8, 15, 22, 29 ),
								array( 2, 9, 16, 23, 30 ),
								array( 3, 10, 17, 24, 31 ),
								array( 4, 11, 18, 25 ),
								array( 5, 12, 19, 26 ),
								array( 6, 13, 20, 27 ),
								array( 7, 14, 21, 28 ),
							);
							$col_class = '';

							if ( in_array( $i, $col_arr[0] ) ) {
								$col_class = 'ct-first-col';
							} elseif ( in_array( $i, $col_arr[1] ) ) {
								$col_class = 'ct-second-col';
							} elseif ( in_array( $i, $col_arr[2] ) ) {
								$col_class = 'ct-third-col';
							} elseif ( in_array( $i, $col_arr[3] ) ) {
								$col_class = 'ct-forth-col';
							} elseif ( in_array( $i, $col_arr[4] ) ) {
								$col_class = 'ct-fifth-col';
							} elseif ( in_array( $i, $col_arr[5] ) ) {
								$col_class = 'ct-sixth-col';
							} elseif ( in_array( $i, $col_arr[6] ) ) {
								$col_class = 'ct-seventh-col';
							}
							$last_day  = '';
							$first_day = '';
							if ( $i == count( $days ) ) {
								$last_day = 'ct-last-day-in-month';
							}
							if ( $i == 1 ) {
								$first_day = 'ct-first-day-in-month';
							}
							?>
						<div class="calendar-column <?php echo $row_class; ?> <?php echo $col_class; ?>  <?php
						if ( $events ) {
							echo 'col-has-event'; }
						?>
							">
							<div class="calendar-date"><?php echo $day; ?></div>
                <?php
                if ( $events ) {
                  foreach ( $events as $key => $event ) {
                    if ( $key > 1 ) {
                      continue;
                    }
                    $item_class = '';
                    if ( $key == 0 ) {
                      $item_class = 'ct-first-in-view';
                    } elseif ( $key == 1 ) {
                      $item_class = 'ct-second-in-view';
                    }
                    $args = array(
                      'event'      => $event,
                      'date'       => $date,
                      'item_class' => $item_class,
                      'last_day'   => $last_day,
                      'first_day'  => $first_day,
                    );
                    get_template_part( 'partials/content', 'event-item', $args );
                  }
                  ?>
								<?php
								if ( $events ) {
									if ( count( $events ) > 2 ) {
										?>
							<span class="more-btn calendar-event">+<?php echo count( $events ) - 2; ?> more</span>
							<div class="more-events" style="display:none;">
										<?php
										foreach ( $events as $key => $event ) {
											if ( $key < 2 ) {
												continue;
											}
											$args = array(
												'event'    => $event,
												'date'     => $date,
												'item_class' => 'ct-not-in-view',
												'last_day' => $last_day,
												'first_day' => $first_day,
											);
											get_template_part( 'partials/content', 'event-item', $args );
										}
										?>
							</div>
										<?php
									}
								}
								?>

							<div class="tooltip" style="display:none;">
								<?php
								foreach ( $events as $key => $event ) {
									$args = array(
										'event' => $event,
										'date'  => $date,
									);
									get_template_part( 'partials/content', 'event-tooltip', $args );
								}
								?>

								<div class="tooltip-bottom"></div>

							</div>
							<?php } ?>
						</div>
						<?php $i++; } ?>

					</div>
					<svg class="svg">
						<clipPath id="calendar-day-path" clipPathUnits="objectBoundingBox">
							<path
								d="M0.025,0 C0.011,0,0,0.017,0,0.037 V0.963 C0,0.983,0.011,1,0.025,1 H0.848 C0.862,1,0.875,0.992,0.885,0.977 L0.985,0.83 C0.995,0.816,1,0.796,1,0.776 V0.037 C1,0.017,0.989,0,0.975,0 H0.025">
							</path>
						</clipPath>
					</svg>
				</div>
					<?php
								$number++;
								$old = array(); }
              }
				?>
			</div>
			<!-- Calender View End -->
		</div>

						</div>
						</div>
					</div>
				</div>
	</section>
<?php
get_footer(); ?>