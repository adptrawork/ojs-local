{**
 * templates/frontend/objects/announcements_list.tpl
 *
 * Sanguline Theme - Homepage Announcement Slider
 * Overrides default homepage announcements with elegant slider
 *
 * @uses $numAnnouncements int The number of announcements to display
 * @uses $announcements Announcement[] The list of announcements
 *}

{if $numAnnouncements && $announcements|@count}
<section class="cmp_announcements highlight_first sanguline_announcement_slider">
	<a id="homepageAnnouncements"></a>
	
	<div class="slider_header">
		<h2 class="slider_title">
			<span class="fa fa-bullhorn" aria-hidden="true"></span>
			{translate key="announcement.announcements"}
		</h2>
		{if $announcements|@count > 1}
		<div class="slider_controls">
			<button type="button" class="btn btn-outline-secondary slider_prev" aria-label="{translate key="common.previous"}" data-jrdc-slide-prev>
				<span class="fa fa-chevron-left" aria-hidden="true"></span>
			</button>
			<button type="button" class="btn btn-outline-secondary slider_next" aria-label="{translate key="common.next"}" data-jrdc-slide-next>
				<span class="fa fa-chevron-right" aria-hidden="true"></span>
			</button>
		</div>
		{/if}
	</div>
	
	<div class="slider_container">
		<div class="slider_track">
			{assign var="slideIndex" value=0}
			{foreach name=announcements from=$announcements item=announcement}
				{if $smarty.foreach.announcements.iteration > $numAnnouncements}
					{break}
				{/if}
				<div class="slider_slide{if $slideIndex == 0} active{/if}" data-slide="{$slideIndex}">
					<article class="card announcement_card">
						{assign var="datePosted" value=$announcement->getDatePosted()}
						<div class="announcement_date">
							<span class="date_day">{$datePosted|strtotime|date_format:"d"}</span>
							<span class="date_month">{$datePosted|strtotime|date_format:"M"}</span>
							<span class="date_year">{$datePosted|strtotime|date_format:"Y"}</span>
						</div>
						<div class="announcement_content">
							<h3 class="announcement_title">
								<a href="{url router=$smarty.const.ROUTE_PAGE page="announcement" op="view" path=$announcement->getId()}">
									{$announcement->getLocalizedTitle()|escape}
								</a>
							</h3>
							<div class="announcement_summary">
								{$announcement->getLocalizedDescriptionShort()|strip_unsafe_html}
							</div>
							<a href="{url router=$smarty.const.ROUTE_PAGE page="announcement" op="view" path=$announcement->getId()}" class="announcement_read_more">
								{translate key="common.readMore"}
								<span class="fa fa-arrow-right" aria-hidden="true"></span>
							</a>
						</div>
					</article>
				</div>
				{assign var="slideIndex" value=$slideIndex+1}
			{/foreach}
		</div>
	</div>
	
	{if $announcements|@count > 1 && $numAnnouncements > 1}
	<div class="slider_dots">
		{assign var="dotIndex" value=0}
		{foreach name=dots from=$announcements item=announcement}
			{if $smarty.foreach.dots.iteration > $numAnnouncements}
				{break}
			{/if}
			<button type="button" class="slider_dot{if $dotIndex == 0} active{/if}" data-slide="{$dotIndex}" aria-label="Slide {$smarty.foreach.dots.iteration}"></button>
			{assign var="dotIndex" value=$dotIndex+1}
		{/foreach}
	</div>
	{/if}
</section>
{/if}
