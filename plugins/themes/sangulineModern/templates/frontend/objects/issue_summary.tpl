{**
 * templates/frontend/objects/issue_summary.tpl
 *
 * Child theme override: Issue card with Bootstrap 5.3.3.
 *
 * @uses $issue Issue The issue
 *}
{if $issue->getShowTitle()}
	{assign var=issueTitle value=$issue->getLocalizedTitle()}
{/if}
{assign var=issueSeries value=$issue->getIssueSeries()}
{assign var=issueCover value=$issue->getLocalizedCoverImageUrl()}

<div class="card h-100 obj_issue_summary shadow-sm">
	{if $issueCover}
		<a class="cover d-block" href="{url page="issue" op="view" path=$issue->getBestIssueId()}">
			<img class="card-img-top" src="{$issueCover|escape}" alt="{$issue->getLocalizedCoverImageAltText()|escape|default:''}">
		</a>
	{/if}

	<div class="card-body d-flex flex-column">
		<h2 class="card-title h5 mb-2">
			<a class="title text-decoration-none" href="{url page="issue" op="view" path=$issue->getBestIssueId()}">
				{if $issueTitle}
					{$issueTitle|escape}
				{else}
					{$issueSeries|escape}
				{/if}
			</a>
		</h2>

		{if $issueTitle && $issueSeries}
			<div class="series text-muted small mb-2">
				{$issueSeries|escape}
			</div>
		{/if}

		{if $issue->getDatePublished()}
			<div class="text-muted small mb-3">
				<span class="label">{translate key="submissions.published"}:</span>
				<span class="value">{$issue->getDatePublished()|date_format:$dateFormatShort}</span>
			</div>
		{/if}

		{if $issue->getLocalizedDescription()}
			<div class="description text-muted small mb-3 flex-grow-1">
				{$issue->getLocalizedDescription()|strip_tags|truncate:180}
			</div>
		{/if}

		<div class="mt-auto pt-2 border-top">
			<a class="btn btn-sm btn-outline-primary w-100" href="{url page="issue" op="view" path=$issue->getBestIssueId()}">
				Lihat Edisi Lengkap &rarr;
			</a>
		</div>
	</div>
</div><!-- .obj_issue_summary -->
