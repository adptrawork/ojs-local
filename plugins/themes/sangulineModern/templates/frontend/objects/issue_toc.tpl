{**
 * Child theme override: Issue table of contents (Bootstrap 5.3.3 layout).
 *
 * @uses $issue Issue The issue
 * @uses $issueTitle string Title of the issue. May be empty
 * @uses $issueSeries string Vol/No/Year string for the issue
 * @uses $issueGalleys array Galleys for the entire issue
 * @uses $hasAccess bool Can this user access galleys for this context?
 * @uses $publishedSubmissions array Lists of articles published in this issue
 *   sorted by section.
 * @uses $primaryGenreIds array List of file genre ids for primary file types
 * @uses $heading string HTML heading element, default: h2
 *}
{if !$heading}
	{assign var="heading" value="h2"}
{/if}
{assign var="articleHeading" value="h3"}
{if $heading == "h3"}
	{assign var="articleHeading" value="h4"}
{elseif $heading == "h4"}
	{assign var="articleHeading" value="h5"}
{elseif $heading == "h5"}
	{assign var="articleHeading" value="h6"}
{/if}
<div class="obj_issue_toc">

	{* Indicate if this is only a preview *}
	{if !$issue->getPublished()}
		{include file="frontend/components/notification.tpl" type="warning" messageKey="editor.issues.preview"}
	{/if}

	{* Issue introduction area above articles *}
	<div class="heading row g-4 align-items-start">

		<div class="col-12 col-md-8">
			{* Description *}
			{if $issue->hasDescription()}
				<div class="description jrdc-prose">
					{$issue->getLocalizedDescription()|strip_unsafe_html}
				</div>
			{/if}

			{* PUb IDs (eg - DOI) *}
			{foreach from=$pubIdPlugins item=pubIdPlugin}
				{assign var=pubId value=$issue->getStoredPubId($pubIdPlugin->getPubIdType())}
				{if $pubId}
					{assign var="doiUrl" value=$pubIdPlugin->getResolvingURL($currentJournal->getId(), $pubId)|escape}
					<div class="pub_id {$pubIdPlugin->getPubIdType()|escape} mb-2">
						<span class="type badge text-bg-light border me-1">
							{$pubIdPlugin->getPubIdDisplayType()|escape}
						</span>
						<span class="id">
							{if $doiUrl}
								<a href="{$doiUrl|escape}">
									{$doiUrl}
								</a>
							{else}
								{$pubId}
							{/if}
						</span>
					</div>
				{/if}
			{/foreach}

			{* Published date *}
			{if $issue->getDatePublished()}
				<div class="published text-muted small mt-2">
					<span class="label">
						{translate key="submissions.published"}:
					</span>
					<span class="value">
						{$issue->getDatePublished()|date_format:$dateFormatShort}
					</span>
				</div>
			{/if}
		</div>

		<div class="col-12 col-md-4">
			{* Issue cover image *}
			{assign var=issueCover value=$issue->getLocalizedCoverImageUrl()}
			{if $issueCover}
				<a class="cover d-inline-block" href="{url op="view" page="issue" path=$issue->getBestIssueId()}">
					{capture assign="defaultAltText"}
						{translate key="issue.viewIssueIdentification" identification=$issue->getIssueIdentification()|escape}
					{/capture}
					<img class="img-fluid rounded" src="{$issueCover|escape}" alt="{$issue->getLocalizedCoverImageAltText()|escape|default:$defaultAltText}">
				</a>
			{/if}
		</div>
	</div>

	{* Full-issue galleys *}
	{if $issueGalleys}
		<div class="galleys mb-4">
			<{$heading} id="issueTocGalleyLabel" class="h5 mb-2">
				{translate key="issue.fullIssue"}
			</{$heading}>
			<ul class="galleys_links list-unstyled d-flex flex-wrap gap-2 mb-0">
				{foreach from=$issueGalleys item=galley}
					<li>
						{include file="frontend/objects/galley_link.tpl" parent=$issue labelledBy="issueTocGalleyLabel" purchaseFee=$currentJournal->getData('purchaseIssueFee') purchaseCurrency=$currentJournal->getData('currency')}
					</li>
				{/foreach}
			</ul>
		</div>
	{/if}

	{* Articles *}
	<div class="sections">
	{foreach name=sections from=$publishedSubmissions item=section}
		<div class="section card mb-4">
		{if $section.articles}
			{if $section.title}
				<{$heading} class="card-header h6 mb-0">
					{$section.title|escape}
				</{$heading}>
			{/if}
			<ul class="cmp_article_list articles list-group list-group-flush">
				{foreach from=$section.articles item=article}
					<li class="list-group-item">
						{include file="frontend/objects/article_summary.tpl" heading=$articleHeading}
					</li>
				{/foreach}
			</ul>
		{/if}
		</div>
	{/foreach}
	</div><!-- .sections -->
</div>
