{**
 * SangulineModern child theme - article summary override (parent: Sanguline)
 *
 * Rebuilt on Bootstrap 5 components (card, card-body, badge, btn). The card
 * markup keeps the core/parent class names (.obj_article_summary,
 * .jrdc-article-card, .title, .authors, .galleys_links) and preserves the
 * author/galley/DOI/stats/publication logic and JS hooks.
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

<article class="obj_article_summary jrdc-article-card card">
	{if $publication->getLocalizedData('coverImage')}
		<div class="cover jrdc-article-card__cover">
			<a {if $journal}href="{url journal=$journal->getPath() page="article" op="view" path=$articlePath}"{else}href="{url page="article" op="view" path=$articlePath}"{/if} class="file">
				{assign var="coverImage" value=$publication->getLocalizedData('coverImage')}
				<img
					src="{$publication->getLocalizedCoverImageUrl($article->getData('contextId'))|escape}"
					alt="{$coverImage.altText|escape|default:''}"
					loading="lazy"
				>
			</a>
		</div>
	{/if}

	<div class="card-body jrdc-article-card__body">
		<div class="jrdc-article-card__badges">
			<span class="badge jrdc-badge jrdc-badge--category">
				{if $section.title}{$section.title|escape}{else}Artikel Penelitian{/if}
			</span>
			{assign var="jrdcOpenAccess" value=0}
			{if $currentContext && $currentContext->getSetting('publishingMode') == $smarty.const.PUBLISHING_MODE_OPEN}
				{assign var="jrdcOpenAccess" value=1}
			{elseif $publication->getData('accessStatus') == $smarty.const.ARTICLE_ACCESS_OPEN}
				{assign var="jrdcOpenAccess" value=1}
			{/if}
			{if $jrdcOpenAccess}
				<span class="badge jrdc-badge jrdc-badge--open">
					Akses Terbuka
				</span>
			{/if}
		</div>

		<{$heading} class="title jrdc-article-card__title">
			<a id="article-{$article->getId()}" {if $journal}href="{url journal=$journal->getPath() page="article" op="view" path=$articlePath}"{else}href="{url page="article" op="view" path=$articlePath}"{/if}>
				{if $currentContext}
					{$publication->getLocalizedTitle()|strip_unsafe_html}
					{assign var="localizedSubtitle" value=$publication->getLocalizedData('subtitle')|strip_unsafe_html}
					{if $localizedSubtitle}
						<span class="subtitle jrdc-article-card__subtitle">{$localizedSubtitle}</span>
					{/if}
				{else}
					{$article->getLocalizedTitle()|strip_unsafe_html}
					<span class="subtitle jrdc-article-card__subtitle">
						{$journal->getLocalizedName()|escape}
					</span>
				{/if}
			</a>
		</{$heading}>

		{assign var="submissionPages" value=$publication->getData('pages')}
		{assign var="submissionDatePublished" value=$publication->getData('datePublished')}

		<div class="meta jrdc-article-card__meta">
			{* Authors with tooltip/popover on hover *}
			{if $showAuthor}
				<div class="authors jrdc-article-card__authors">
					{assign var="authors" value=$publication->getData('authors')}
					{foreach from=$authors item=author name=authorLoop}
						{assign var="affiliation" value=$author->getLocalizedData('affiliation')}
						{assign var="country" value=$author->getCountryLocalized()}
						{if $affiliation || $country}
							<span class="author_item has_tooltip jrdc-author">
								<span class="author_name">{$author->getFullName()|escape}</span>
								<span class="author_tooltip jrdc-author__tooltip" role="tooltip">
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
							<span class="author_item jrdc-author">
								<span class="author_name">{$author->getFullName()|escape}</span>
							</span>
						{/if}
						{if !$smarty.foreach.authorLoop.last}<span class="author_separator">, </span>{/if}
					{/foreach}
				</div>
			{/if}
		</div>

		{* Abstract Toggle and Galleys in one row *}
		<div class="article_actions jrdc-article-card__actions">
			{assign var="articleAbstract" value=$publication->getLocalizedData('abstract')}
			{if $articleAbstract}
				<div class="abstract_toggle_wrapper">
					<button type="button" class="btn btn-sm btn-outline-secondary abstract_toggle" aria-expanded="false" aria-controls="abstract-{$article->getId()}" data-toggle-target="abstract-{$article->getId()}">
						<span class="fa fa-file-text-o" aria-hidden="true"></span>
						<span class="toggle_label">{translate key="plugins.themes.sanguline.article.showAbstract"}</span>
					</button>
				</div>
			{/if}

			{if !$hideGalleys}
				<ul class="galleys_links jrdc-article-card__galleys list-unstyled">
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

			<div class="article_details_link_wrapper">
				<a {if $journal}href="{url journal=$journal->getPath() page="article" op="view" path=$articlePath}"{else}href="{url page="article" op="view" path=$articlePath}"{/if} class="btn btn-sm btn-outline-primary">
					Detail Naskah
				</a>
			</div>
		</div>

		{* Abstract content (outside flex for full width) *}
		{if $articleAbstract}
			<div class="abstract_content jrdc-article-card__abstract" id="abstract-{$article->getId()}" hidden>
				{$articleAbstract|strip_unsafe_html}
			</div>
		{/if}

		<div class="jrdc-article-card__details">
			{* Page numbers for this article *}
			{if $submissionPages}
				<div class="pages jrdc-meta-item">
					<span class="label">{translate key="plugins.themes.sanguline.article.pages"}:</span>
					<span class="value">{$submissionPages|escape}</span>
				</div>
			{/if}

			{if $showDatePublished && $submissionDatePublished}
				<div class="published jrdc-meta-item">
					<span class="label">{translate key="submissions.published"}:</span>
					<span class="value">{$submissionDatePublished|date_format:$dateFormatShort}</span>
				</div>
			{/if}

			{* DOI *}
			{assign var="doiUrl" value=""}
			{if $currentJournal}
				{foreach from=$pubIdPlugins item=pubIdPlugin}
					{if $pubIdPlugin->getPubIdType() == 'doi'}
						{assign var="pubId" value=$article->getStoredPubId('doi')}
						{if $pubId}
							{assign var="doiUrl" value=$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
						{/if}
						{break}
					{/if}
				{/foreach}
			{/if}
			{if $doiUrl}
				<div class="doi jrdc-meta-item">
					<span class="label">DOI:</span>
					<a href="{$doiUrl}" target="_blank" rel="noopener noreferrer" class="value">{$doiUrl}</a>
					<button type="button" class="jrdc-doi-copy" data-doi="{$doiUrl}" aria-label="Salin DOI">Salin DOI</button>
				</div>
			{/if}
		</div>

		{* View and Download Statistics *}
		{assign var="abstractViews" value=$article->getViews()}
		{assign var="totalDownloads" value=0}
		{foreach from=$article->getGalleys() item=statsGalley}
			{assign var="totalDownloads" value=$totalDownloads+$statsGalley->getViews()}
		{/foreach}
		<div class="article_stats jrdc-article-card__stats">
			<span class="stat_item views jrdc-stat">
				<span class="fa fa-eye" aria-hidden="true"></span>
				<span class="stat_label">{translate key="plugins.themes.sanguline.article.views"}:</span>
				<span class="stat_value">{$abstractViews|default:0|number_format}</span>
			</span>
			<span class="stat_item downloads jrdc-stat">
				<span class="fa fa-download" aria-hidden="true"></span>
				<span class="stat_label">{translate key="plugins.themes.sanguline.article.downloads"}:</span>
				<span class="stat_value">{$totalDownloads|default:0|number_format}</span>
			</span>
		</div>

		{call_hook name="Templates::Issue::Issue::Article"}
	</div>
</article>
