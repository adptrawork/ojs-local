{**
 * templates/frontend/objects/article_summary.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief View of an Article summary for Sangukara theme.
 *        Enhanced to show author affiliations, statistics, and DOI.
 *
 * @uses $article Article The article
 * @uses $authorUserGroups Traversible The set of author user groups
 * @uses $hasAccess bool Can this user access galleys for this context?
 * @uses $showDatePublished bool Show the date this article was published?
 * @uses $hideGalleys bool Hide the article galleys for this article?
 * @uses $primaryGenreIds array List of file genre ids for primary file types
 * @uses $heading string HTML heading element, default: h2
 *}
{assign var=publication value=$article->getCurrentPublication()}
{assign var=articlePath value=$article->getBestId()}
{if !$heading}
	{assign var="heading" value="h2"}
{/if}

{if (!$section.hideAuthor && $article->getHideAuthor() == $smarty.const.AUTHOR_TOC_DEFAULT) || $article->getHideAuthor() == $smarty.const.AUTHOR_TOC_SHOW}
	{assign var="showAuthor" value=true}
{/if}

<div class="obj_article_summary">
	{if $publication->getLocalizedData('coverImage')}
		<div class="cover">
			<a {if $journal}href="{url journal=$journal->getPath() page="article" op="view" path=$articlePath}"{else}href="{url page="article" op="view" path=$articlePath}"{/if} class="file">
				{assign var="coverImage" value=$publication->getLocalizedData('coverImage')}
				<img
					src="{$publication->getLocalizedCoverImageUrl($article->getData('contextId'))|escape}"
					alt="{$coverImage.altText|escape|default:''}"
				>
			</a>
		</div>
	{/if}

	<{$heading} class="title">
		<a id="article-{$article->getId()}" {if $journal}href="{url journal=$journal->getPath() page="article" op="view" path=$articlePath}"{else}href="{url page="article" op="view" path=$articlePath}"{/if}>
			{if $currentContext}
				{$publication->getLocalizedTitle()|strip_unsafe_html}
				{assign var=localizedSubtitle value=$publication->getLocalizedData('subtitle')|strip_unsafe_html}
				{if $localizedSubtitle}
					<span class="subtitle">{$localizedSubtitle}</span>
				{/if}
			{else}
				{$article->getLocalizedTitle()|strip_unsafe_html}
				<span class="subtitle">
					{$journal->getLocalizedName()|escape}
				</span>
			{/if}
		</a>
	</{$heading}>

	{assign var=submissionPages value=$publication->getData('pages')}
	{assign var=submissionDatePublished value=$publication->getData('datePublished')}
	
	<div class="meta">
		{* Authors with tooltip/popover on hover *}
		{if $showAuthor}
			<div class="authors">
				{assign var="authors" value=$publication->getData('authors')}
				{foreach from=$authors item=author name=authorLoop}
					{assign var="affiliation" value=$author->getLocalizedData('affiliation')}
					{assign var="country" value=$author->getCountryLocalized()}
					{if $affiliation || $country}
						<span class="author_item has_tooltip">
							<span class="author_name">{$author->getFullName()|escape}</span>
							<span class="author_tooltip">
								{if $affiliation}
									<span class="tooltip_row">
										<span class="fa fa-building" aria-hidden="true"></span>
										{$affiliation|escape}
									</span>
								{/if}
								{if $country}
									<span class="tooltip_row">
										<span class="fa fa-globe" aria-hidden="true"></span>
										{$country|escape}
									</span>
								{/if}
							</span>
						</span>
					{else}
						<span class="author_item">
							<span class="author_name">{$author->getFullName()|escape}</span>
						</span>
					{/if}
					{if !$smarty.foreach.authorLoop.last}<span class="author_separator">, </span>{/if}
				{/foreach}
			</div>
		{/if}

		{* Abstract Toggle and Galleys in one row *}
		<div class="article_actions">
			{assign var="articleAbstract" value=$publication->getLocalizedData('abstract')}
			{if $articleAbstract}
				<div class="abstract_toggle_wrapper">
					<button type="button" class="abstract_toggle" aria-expanded="false" aria-controls="abstract-{$article->getId()}" data-toggle-target="abstract-{$article->getId()}">
						<span class="fa fa-file-text-o" aria-hidden="true"></span>
						<span class="toggle_label">{translate key="plugins.themes.sanguline.article.showAbstract"}</span>
						<span class="fa fa-chevron-down toggle_icon" aria-hidden="true"></span>
					</button>
				</div>
			{/if}

			{if !$hideGalleys}
				<ul class="galleys_links">
					{foreach from=$article->getGalleys() item=galley}
						{if $primaryGenreIds}
							{assign var="file" value=$galley->getFile()}
							{if !$galley->getRemoteUrl() && !($file && in_array($file->getGenreId(), $primaryGenreIds))}
								{continue}
							{/if}
						{/if}
						<li>
							{assign var="hasArticleAccess" value=$hasAccess}
							{if $currentContext->getSetting('publishingMode') == $smarty.const.PUBLISHING_MODE_OPEN || $publication->getData('accessStatus') == $smarty.const.ARTICLE_ACCESS_OPEN}
								{assign var="hasArticleAccess" value=1}
							{/if}
							{assign var="id" value="article-{$article->getId()}-galley-{$galley->getId()}"}
							{include file="frontend/objects/galley_link.tpl" parent=$article publication=$publication id=$id labelledBy="{$id} article-{$article->getId()}" hasAccess=$hasArticleAccess purchaseFee=$currentJournal->getData('purchaseArticleFee') purchaseCurrency=$currentJournal->getData('currency')}
						</li>
					{/foreach}
				</ul>
			{/if}
		</div>

		{* Abstract content (outside flex for full width) *}
		{if $articleAbstract}
			<div class="abstract_content" id="abstract-{$article->getId()}" hidden>
				{$articleAbstract|strip_unsafe_html}
			</div>
		{/if}

		{* Page numbers for this article *}
		{if $submissionPages}
			<div class="pages">
				<span class="label">{translate key="plugins.themes.sanguline.article.pages"}:</span>
				<span class="value">{$submissionPages|escape}</span>
			</div>
		{/if}

		{if $showDatePublished && $submissionDatePublished}
			<div class="published">
				<span class="label">{translate key="submissions.published"}:</span>
				<span class="value">{$submissionDatePublished|date_format:$dateFormatShort}</span>
			</div>
		{/if}

		{* DOI *}
		{assign var="doiUrl" value=""}
		{if $currentJournal}
			{foreach from=$pubIdPlugins item=pubIdPlugin}
				{if $pubIdPlugin->getPubIdType() == 'doi'}
					{assign var=pubId value=$article->getStoredPubId('doi')}
					{if $pubId}
						{assign var="doiUrl" value=$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
					{/if}
					{break}
				{/if}
			{/foreach}
		{/if}
		{if $doiUrl}
			<div class="doi">
				<span class="label">DOI:</span>
				<a href="{$doiUrl}" target="_blank" class="value">{$doiUrl}</a>
			</div>
		{/if}

		{* View and Download Statistics *}
		{assign var="abstractViews" value=$article->getViews()}
		{assign var="totalDownloads" value=0}
		{foreach from=$article->getGalleys() item=statsGalley}
			{assign var="totalDownloads" value=$totalDownloads+$statsGalley->getViews()}
		{/foreach}
		<div class="article_stats">
			<span class="stat_item views">
				<span class="fa fa-eye" aria-hidden="true"></span>
				<span class="stat_label">{translate key="plugins.themes.sanguline.article.views"}:</span>
				<span class="stat_value">{$abstractViews|default:0|number_format}</span>
			</span>
			<span class="stat_item downloads">
				<span class="fa fa-download" aria-hidden="true"></span>
				<span class="stat_label">{translate key="plugins.themes.sanguline.article.downloads"}:</span>
				<span class="stat_value">{$totalDownloads|default:0|number_format}</span>
			</span>
		</div>

	{call_hook name="Templates::Issue::Issue::Article"}
</div>
