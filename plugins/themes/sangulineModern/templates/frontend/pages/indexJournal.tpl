{**
 * SangulineModern child theme - journal index override (parent: Sanguline)
 * Modern hero/section/card layout while preserving OJS variables, hooks, and includes.
 *
 * @uses $currentJournal Journal This journal
 * @uses $journalDescription string Journal description from HTML text editor
 * @uses $homepageImage object Image to be displayed on the homepage
 * @uses $additionalHomeContent string Arbitrary input from HTML text editor
 * @uses $announcements array List of announcements
 * @uses $numAnnouncementsHomepage int Number of announcements to display on the homepage
 * @uses $issue Issue Current issue
 *}
{include file="frontend/components/header.tpl" pageTitleTranslated=$currentJournal->getLocalizedName()}

<div class="page_index_journal jrdc-home">

	{call_hook name="Templates::Index::journal"}

	{* Homepage Hero Section - Image and About side by side *}
	{if ($activeTheme && !$activeTheme->getOption('useHomepageImageAsHeader') && $homepageImage) || ($activeTheme && $activeTheme->getOption('showDescriptionInJournalIndex'))}
		<section class="homepage_hero jrdc-hero" aria-labelledby="homepageAboutTitle">
			{if $activeTheme && !$activeTheme->getOption('useHomepageImageAsHeader') && $homepageImage}
				<div class="homepage_image jrdc-hero__media">
					<img src="{$publicFilesDir}/{$homepageImage.uploadName|escape:"url"}" width="{$homepageImage.width|default:''|escape}" height="{$homepageImage.height|default:''|escape}"{if $homepageImage.altText} alt="{$homepageImage.altText|escape}"{else} alt=""{/if} loading="eager">
				</div>
			{/if}

			{* Journal Description *}
			{if $activeTheme && $activeTheme->getOption('showDescriptionInJournalIndex')}
				<div class="homepage_about jrdc-hero__content jrdc-card">
					<a id="homepageAbout"></a>
					<h2 id="homepageAboutTitle" class="jrdc-section-title">{translate key="about.aboutContext"}</h2>
					<div class="jrdc-prose">
						{$currentContext->getLocalizedData('description')}
					</div>
				</div>
			{/if}
		</section>
	{/if}

	{if $announcements && $numAnnouncementsHomepage}
		<section class="jrdc-section jrdc-announcements" aria-label="{translate|escape key="announcement.announcements"}">
			{include file="frontend/objects/announcements_list.tpl" numAnnouncements=$numAnnouncementsHomepage}
		</section>
	{/if}

	{* Latest issue *}
	{if $issue}
		<section class="current_issue jrdc-section jrdc-issue jrdc-card" aria-labelledby="homepageIssueTitle">
			<a id="homepageIssue"></a>
			<header class="jrdc-section__header">
				<h2 id="homepageIssueTitle" class="jrdc-section-title">
					{translate key="journal.currentIssue"}
				</h2>
				<div class="current_issue_title jrdc-issue__id">
					{$issue->getIssueIdentification()|strip_unsafe_html}
				</div>
			</header>
			<div class="jrdc-issue__toc">
				{include file="frontend/objects/issue_toc.tpl" heading="h3"}
			</div>
			<p class="jrdc-section__actions">
				<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}" class="read_more jrdc-button jrdc-button--secondary">
					{translate key="journal.viewAllIssues"}
				</a>
			</p>
		</section>
	{/if}

	{* Additional Homepage Content *}
	{if $additionalHomeContent}
		<section class="additional_content jrdc-section jrdc-additional jrdc-card">
			<div class="jrdc-prose">
				{$additionalHomeContent}
			</div>
		</section>
	{/if}
</div><!-- .page -->

{include file="frontend/components/footer.tpl"}
