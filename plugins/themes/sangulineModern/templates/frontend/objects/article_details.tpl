{**
 * templates/frontend/objects/article_details.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief View of an Article which displays all details about the article.
 *  Expected to be primary object on the page.
 *
 * SangulineModern override (Phase 3): rebuilt on Bootstrap 5 components
 * (card, card-body, list-group, badge, btn). All core/parent Smarty logic,
 * hooks and data are preserved; only markup and class names changed.
 *
 * Many journals will want to add custom data to this object, either through
 * plugins which attach to hooks on the page or by editing the template
 * themselves. In order to facilitate this, a flexible layout markup pattern has
 * been implemented. If followed, plugins and other content can provide markup
 * in a way that will render consistently with other items on the page. This
 * pattern is used in the .main_entry column and the .entry_details column. It
 * consists of the following:
 *
 * <!-- Wrapper class which provides proper spacing between components -->
 * <div class="item">
 *     <!-- Title/value combination -->
 *     <div class="label">Abstract</div>
 *     <div class="value">Value</div>
 * </div>
 *
 * All styling should be applied by class name, so that titles may use heading
 * elements (eg, <h3>) or any element required.
 *
 * <!-- Example: component with multiple title/value combinations -->
 * <div class="item">
 *     <div class="sub_item">
 *         <div class="label">DOI</div>
 *         <div class="value">12345678</div>
 *     </div>
 *     <div class="sub_item">
 *         <div class="label">Published Date</div>
 *         <div class="value">2015-01-01</div>
 *     </div>
 * </div>
 *
 * <!-- Example: component with no title -->
 * <div class="item">
 *     <div class="value">Whatever you'd like</div>
 * </div>
 *
 * Core components are produced manually below, but can also be added via
 * plugins using the hooks provided:
 *
 * Templates::Article::Main
 * Templates::Article::Details
 *
 * @uses $article Submission This article
 * @uses $publication Publication The publication being displayed
 * @uses $firstPublication Publication The first published version of this article
 * @uses $currentPublication Publication The most recently published version of this article
 * @uses $issue Issue The issue this article is assigned to
 * @uses $section Section The journal section this article is assigned to
 * @uses $categories Category The category this article is assigned to
 * @uses $primaryGalleys array List of article galleys that are not supplementary or dependent
 * @uses $supplementaryGalleys array List of article galleys that are supplementary
 * @uses $keywords array List of keywords assigned to this article
 * @uses $pubIdPlugins Array of pubId plugins which this article may be assigned
 * @uses $licenseTerms string License terms.
 * @uses $licenseUrl string URL to license. Only assigned if license should be
 *   included with published submissions.
 * @uses $ccLicenseBadge string An image and text with details about the license
 *}
{if !$heading}
	{assign var="heading" value="h3"}
{/if}
<article class="obj_article_details jrdc-article">

	{* Indicate if this is only a preview *}
	{if $publication->getData('status') !== $smarty.const.STATUS_PUBLISHED}
	<div class="cmp_notification notice">
		{capture assign="submissionUrl"}{url page="workflow" op="access" path=$article->getId()}{/capture}
		{translate key="submission.viewingPreview" url=$submissionUrl}
	</div>
	{* Notification that this is an old version *}
	{elseif $currentPublication->getId() !== $publication->getId()}
		<div class="cmp_notification notice">
			{capture assign="latestVersionUrl"}{url page="article" op="view" path=$article->getBestId()}{/capture}
			{translate key="submission.outdatedVersion"
				datePublished=$publication->getData('datePublished')|date_format:$dateFormatShort
				urlRecentVersion=$latestVersionUrl|escape
			}
		</div>
	{/if}

	<header class="jrdc-article__header">
		<h1 class="page_title jrdc-article__title">
			{$publication->getLocalizedTitle()|strip_unsafe_html}
		</h1>

		{if $publication->getLocalizedData('subtitle')}
			<h2 class="subtitle jrdc-article__subtitle">
				{$publication->getLocalizedData('subtitle')|strip_unsafe_html}
			</h2>
		{/if}
	</header>

	<div class="row g-4 jrdc-article__row">

		{* ===================== Main column ===================== *}
		<div class="main_entry col-12 col-lg-8 jrdc-article__main">

			{* Primary galleys: the single PDF CTA of this page. *}
			{if $primaryGalleys}
				<div class="card jrdc-article__card jrdc-article__galleys">
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">{translate key="submission.downloads"}</h2>
					</div>
					<div class="card-body">
						<ul class="value galleys_links jrdc-article__download-list list-unstyled">
							{foreach from=$primaryGalleys item=galley}
								{* Same path logic as core frontend/objects/galley_link.tpl. *}
								{assign var="galleyPath" value=$article->getBestId()|to_array:$galley->getBestGalleyId()}
								{if $publication && $publication->getId() !== $article->getData('currentPublicationId')}
									{assign var="galleyPath" value=$article->getBestId()|to_array:"version":$publication->getId():$galley->getBestGalleyId()}
								{/if}
								<li class="jrdc-article__galley">
									{include file="frontend/objects/galley_link.tpl" parent=$article publication=$publication galley=$galley purchaseFee=$currentJournal->getData('purchaseArticleFee') purchaseCurrency=$currentJournal->getData('currency')}
									<a class="btn btn-primary btn-sm jrdc-article__galley-cta" href="{url page="article" op="view" path=$galleyPath}">
										<span class="fa fa-download" aria-hidden="true"></span>
										{translate key="common.download"}
									</a>
								</li>
							{/foreach}
						</ul>
					</div>
				</div>
			{/if}

			{* Article header: authors + abstract + keywords in ONE card *}
			<div class="card jrdc-article__card jrdc-article__main-card">
				{if $publication->getData('authors')}
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">{translate key="article.authors"}</h2>
					</div>
					<ul class="list-group list-group-flush authors">
					{foreach from=$publication->getData('authors') item=author}
						<li class="list-group-item">
							<span class="name">
								{$author->getFullName()|escape}
							</span>
							{if $author->getLocalizedData('affiliation')}
								<span class="affiliation">
									<span class="fa fa-building" aria-hidden="true"></span> {$author->getLocalizedData('affiliation')|escape}
									{if $author->getData('rorId')}
										<a href="{$author->getData('rorId')|escape}">{$rorIdIcon}</a>
									{/if}
								</span>
							{/if}
						{assign var="authorCountry" value=$author->getCountryLocalized()}
						{if $authorCountry}
							<span class="country">
								<span class="fa fa-globe" aria-hidden="true"></span>
								{$authorCountry|escape}
							</span>
						{/if}
							{assign var=authorUserGroup value=null}
							{if !empty($userGroupsById[$author->getData('userGroupId')])}
								{assign var=authorUserGroup value=$userGroupsById[$author->getData('userGroupId')]}
							{/if}
							{if $authorUserGroup && $authorUserGroup->getShowTitle()}
								<span class="userGroup">
									{$authorUserGroup->getLocalizedName()|escape}
								</span>
							{/if}
							{if $author->getData('orcid')}
								<span class="orcid">
									{if $author->getData('orcidAccessToken')}
										{$orcidIcon}
									{/if}
									<a href="{$author->getData('orcid')|escape}" target="_blank">
										{$author->getData('orcid')|escape}
									</a>
								</span>
							{/if}
						</li>
					{/foreach}
					</ul>
				{/if}

				{* Abstract *}
				{if $publication->getLocalizedData('abstract')}
					<div class="card-header jrdc-article__card-header border-top">
						<h2 class="jrdc-article__card-title">{translate key="article.abstract"}</h2>
					</div>
					<div class="card-body jrdc-article__abstract-body">
						{$publication->getLocalizedData('abstract')|strip_unsafe_html}
					</div>
				{/if}

				{* Keywords *}
				{if !empty($publication->getLocalizedData('keywords'))}
					<div class="card-header jrdc-article__card-header border-top">
						<h2 class="jrdc-article__card-title">
							{translate key="article.subject"}
						</h2>
					</div>
					<div class="card-body">
						<span class="value jrdc-article__keyword-list">
							{foreach name="keywords" from=$publication->getLocalizedData('keywords') item="keyword"}
								<span class="badge jrdc-article__keyword">{$keyword|escape}</span>
							{/foreach}
						</span>
					</div>
				{/if}
			</div>

			{call_hook name="Templates::Article::Main"}

			{* Usage statistics chart*}
			{if $activeTheme && $activeTheme->getOption('displayStats') != 'none' && $activeTheme->supportsUsageStats()}
				<section class="card jrdc-article__card jrdc-article__downloads-chart">
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">
							{translate key="plugins.themes.sanguline.displayStats.downloads"}
						</h2>
					</div>
					<div class="card-body">
						<div class="value">
							<canvas class="usageStatsGraph" data-object-type="Submission" data-object-id="{$article->getId()|escape}"></canvas>
							<div class="usageStatsUnavailable" data-object-type="Submission" data-object-id="{$article->getId()|escape}">
								{translate key="plugins.themes.sanguline.displayStats.noStats"}
							</div>
						</div>
					</div>
				</section>
			{/if}

			{* Author biographies *}
			{assign var="hasBiographies" value=0}
			{foreach from=$publication->getData('authors') item=author}
				{if $author->getLocalizedData('biography')}
					{assign var="hasBiographies" value=$hasBiographies+1}
				{/if}
			{/foreach}
			{if $hasBiographies}
				<section class="card jrdc-article__card jrdc-article__bios">
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">
							{if $hasBiographies > 1}
								{translate key="submission.authorBiographies"}
							{else}
								{translate key="submission.authorBiography"}
							{/if}
						</h2>
					</div>
					<ul class="list-group list-group-flush authors">
					{foreach from=$publication->getData('authors') item=author}
						{if $author->getLocalizedData('biography')}
							<li class="list-group-item sub_item">
								<div class="label">
									{if $author->getLocalizedData('affiliation')}
										{capture assign="authorName"}{$author->getFullName()|escape}{/capture}
										{capture assign="authorAffiliation"} <span class="fa fa-building" aria-hidden="true"></span> {$author->getLocalizedData('affiliation')|escape} {/capture}
										{translate key="submission.authorWithAffiliation" name=$authorName affiliation=$authorAffiliation}
									{else}
										{$author->getFullName()|escape}
									{/if}
								</div>
								<div class="value">
									{$author->getLocalizedData('biography')|strip_unsafe_html}
								</div>
							</li>
						{/if}
					{/foreach}
					</ul>
				</section>
			{/if}

			{* References *}
			{if $parsedCitations || $publication->getData('citationsRaw')}
				<section class="card jrdc-article__card jrdc-article__references">
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">
							{translate key="submission.citations"}
						</h2>
					</div>
					<div class="card-body">
						<div class="value">
							{if $parsedCitations}
								{foreach from=$parsedCitations item="parsedCitation"}
									<p>{$parsedCitation->getCitationWithLinks()|strip_unsafe_html} {call_hook name="Templates::Article::Details::Reference" citation=$parsedCitation}</p>
								{/foreach}
							{else}
								{$publication->getData('citationsRaw')|escape|nl2br}
							{/if}
						</div>
					</div>
				</section>
			{/if}

		</div><!-- .main_entry -->

		{* ===================== Sidebar ===================== *}
		<div class="entry_details col-12 col-lg-4 jrdc-article__sidebar">

			{* Publication metadata (cover + dates + issue + DOI merged into one card) *}
			<div class="card jrdc-article__card jrdc-article__meta">
				{if $publication->getLocalizedData('coverImage') || ($issue && $issue->getLocalizedCoverImage())}
					<div class="card-body jrdc-article__cover-body border-bottom pb-3">
						<div class="sub_item text-center">
							{if $publication->getLocalizedData('coverImage')}
								{assign var="coverImage" value=$publication->getLocalizedData('coverImage')}
								<img
									src="{$publication->getLocalizedCoverImageUrl($article->getData('contextId'))|escape}"
									alt="{$coverImage.altText|escape|default:''}"
									class="img-fluid rounded"
								>
							{else}
								<a href="{url page="issue" op="view" path=$issue->getBestIssueId()}">
									<img src="{$issue->getLocalizedCoverImageUrl()|escape}" alt="{$issue->getLocalizedCoverImageAltText()|escape|default:''}" class="img-fluid rounded">
								</a>
							{/if}
						</div>
					</div>
				{/if}
				<div class="card-header jrdc-article__card-header">
					<h2 class="jrdc-article__card-title">Informasi Artikel</h2>
				</div>
				<div class="card-body">

					{if $publication->getData('datePublished')}
					<div class="item published">
						<h3 class="label">
							{translate key="submissions.published"}
						</h3>
						<div class="value">
							{* If this is the original version *}
							{if $firstPublication->getId() === $publication->getId()}
								<span>{$firstPublication->getData('datePublished')|date_format:$dateFormatShort}</span>
							{* If this is an updated version *}
							{else}
								<span>{translate key="submission.updatedOn" datePublished=$firstPublication->getData('datePublished')|date_format:$dateFormatShort dateUpdated=$publication->getData('datePublished')|date_format:$dateFormatShort}</span>
							{/if}
						</div>
					</div>
					{if count($article->getPublishedPublications()) > 1}
						<div class="item versions">
							<h3 class="label">
								{translate key="submission.versions"}
							</h3>
							<ul class="value list-unstyled">
								{foreach from=array_reverse($article->getPublishedPublications()) item=iPublication}
									{capture assign="name"}{translate key="submission.versionIdentity" datePublished=$iPublication->getData('datePublished')|date_format:$dateFormatShort version=$iPublication->getData('version')}{/capture}
									<li>
										{if $iPublication->getId() === $publication->getId()}
											{$name}
										{elseif $iPublication->getId() === $currentPublication->getId()}
											<a href="{url page="article" op="view" path=$article->getBestId()}">{$name}</a>
										{else}
											<a href="{url page="article" op="view" path=$article->getBestId()|to_array:"version":$iPublication->getId()}">{$name}</a>
										{/if}
									</li>
								{/foreach}
							</ul>
						</div>
					{/if}
					{/if}

					{* Issue article appears in *}
					{if $issue || $section || $categories}
						{if $issue}
							<div class="item issue">
								<h3 class="label">
									{translate key="issue.issue"}
								</h3>
								<div class="value">
									<a class="title" href="{url page="issue" op="view" path=$issue->getBestIssueId()}">
										{$issue->getIssueIdentification()}
									</a>
								</div>
							</div>
						{/if}

						{if $section}
							<div class="item section">
								<h3 class="label">
									{translate key="section.section"}
								</h3>
								<div class="value">
									{$section->getLocalizedTitle()|escape}
								</div>
							</div>
						{/if}

						{if $categories}
							<div class="item categories">
								<h3 class="label">
									{translate key="category.category"}
								</h3>
								<div class="value">
									<ul class="categories list-unstyled">
										{foreach from=$categories item=category}
											<li><a href="{url router=$smarty.const.ROUTE_PAGE page="catalog" op="category" path=$category->getPath()|escape}">{$category->getLocalizedTitle()|escape}</a></li>
										{/foreach}
									</ul>
								</div>
							</div>
						{/if}
					{/if}

				</div>
			</div>

			{* DOI *}
			{if $currentJournal}
				{foreach from=$pubIdPlugins item=pubIdPlugin}
					{if $pubIdPlugin->getPubIdType() != 'doi'}
						{continue}
					{/if}
					{assign var=pubId value=$article->getStoredPubId($pubIdPlugin->getPubIdType())}
					{if $pubId}
						{assign var="doiUrl" value=$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
						<div class="jrdc-article__doi mt-3 pt-3 border-top">
							<h3 class="label">{translate key="plugins.pubIds.doi.readerDisplayName"}</h3>
							<span class="value jrdc-article__doi-value">
								<a href="{$doiUrl}">
									{$doiUrl}
								</a>
							</span>
							<button type="button" class="jrdc-doi-copy" data-doi="{$doiUrl}" aria-label="Salin DOI">Salin DOI</button>
						</div>
					{/if}
				{/foreach}
			{/if}

			{* Data Availability Statement *}
			{if $publication->getLocalizedData('dataAvailability')}
				<section class="card jrdc-article__card jrdc-article__data-availability" id="data-availability-statement">
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">{translate key="submission.dataAvailability"}</h2>
					</div>
					<div class="card-body">
						{$publication->getLocalizedData('dataAvailability')|strip_unsafe_html}
					</div>
				</section>
			{/if}

			{* PubIds (requires plugins) *}
			{if $currentJournal}
				{foreach from=$pubIdPlugins item=pubIdPlugin}
					{if $pubIdPlugin->getPubIdType() == 'doi'}
						{continue}
					{/if}
					{assign var=pubId value=$article->getStoredPubId($pubIdPlugin->getPubIdType())}
					{if $pubId}
						{assign var="resolvedPubIdUrl" value=$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
						<section class="card jrdc-article__card jrdc-article__pubid">
							<div class="card-header jrdc-article__card-header">
								<h2 class="jrdc-article__card-title">
									{$pubIdPlugin->getPubIdDisplayType()|escape}
								</h2>
							</div>
							<div class="card-body">
								<div class="value">
									{if $resolvedPubIdUrl}
										<a id="pub-id::{$pubIdPlugin->getPubIdType()|escape}" href="{$resolvedPubIdUrl}">
											{$resolvedPubIdUrl}
										</a>
									{else}
										{$pubId|escape}
									{/if}
								</div>
							</div>
						</section>
					{/if}
				{/foreach}
			{/if}

			{* Licensing info *}
			{if $currentContext->getLocalizedData('licenseTerms') || $publication->getData('licenseUrl')}
				<div class="card jrdc-article__card jrdc-article__license">
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">
							{translate key="submission.license"}
						</h2>
					</div>
					<div class="card-body">
						{if $publication->getData('licenseUrl')}
							{if $ccLicenseBadge}
								{if $publication->getLocalizedData('copyrightHolder')}
									<p>{translate key="submission.copyrightStatement" copyrightHolder=$publication->getLocalizedData('copyrightHolder') copyrightYear=$publication->getData('copyrightYear')}</p>
								{/if}
								{$ccLicenseBadge}
							{else}
								<a href="{$publication->getData('licenseUrl')|escape}" class="copyright">
									{if $publication->getLocalizedData('copyrightHolder')}
										{translate key="submission.copyrightStatement" copyrightHolder=$publication->getLocalizedData('copyrightHolder') copyrightYear=$publication->getData('copyrightYear')}
									{else}
										{translate key="submission.license"}
									{/if}
								</a>
							{/if}
						{/if}
						{$currentContext->getLocalizedData('licenseTerms')}
					</div>
				</div>
			{/if}

			{* Supplementary galleys (primary galleys live in the main column) *}
			{if $supplementaryGalleys}
				<div class="card jrdc-article__card jrdc-article__supplementary">
					<div class="card-header jrdc-article__card-header">
						<h2 class="jrdc-article__card-title">
							{translate key="submission.additionalFiles"}
						</h2>
					</div>
					<div class="card-body">
						<ul class="value supplementary_galleys_links list-unstyled">
							{foreach from=$supplementaryGalleys item=galley}
								<li>
									{include file="frontend/objects/galley_link.tpl" parent=$article publication=$publication galley=$galley isSupplementary="1"}
								</li>
							{/foreach}
						</ul>
					</div>
				</div>
			{/if}

			{call_hook name="Templates::Article::Details"}

		</div><!-- .entry_details -->
	</div><!-- .row -->

</article>
