{**
 * templates/frontend/pages/issueArchive.tpl
 *
 * Child theme override: Issue archive with Bootstrap 5.3.3 grid.
 *
 * @uses $issues Array Collection of issues to display
 * @uses $prevPage int The previous page number
 * @uses $nextPage int The next page number
 * @uses $showingStart int The number of the first item on this page
 * @uses $showingEnd int The number of the last item on this page
 * @uses $total int Count of all published monographs
 *}
{capture assign="pageTitle"}
	{if $prevPage}
		{translate key="archive.archivesPageNumber" pageNumber=$prevPage+1}
	{else}
		{translate key="archive.archives"}
	{/if}
{/capture}
{include file="frontend/components/header.tpl" pageTitleTranslated=$pageTitle}

<div class="page page_issue_archive">
	{include file="frontend/components/breadcrumbs.tpl" currentTitle=$pageTitle}
	<h1 class="mb-4">
		{$pageTitle|escape}
	</h1>

	{* No issues have been published *}
	{if empty($issues)}
		<div class="alert alert-info">
			{translate key="current.noCurrentIssueDesc"}
		</div>

	{* List issues in Bootstrap responsive grid *}
	{else}
		<div class="issues_archive row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
			{foreach from=$issues item="issue"}
				<div class="col">
					{include file="frontend/objects/issue_summary.tpl"}
				</div>
			{/foreach}
		</div>

		{* Pagination *}
		{if $prevPage > 1}
			{capture assign=prevUrl}{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive" path=$prevPage}{/capture}
		{elseif $prevPage === 1}
			{capture assign=prevUrl}{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}{/capture}
		{/if}
		{if $nextPage}
			{capture assign=nextUrl}{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive" path=$nextPage}{/capture}
		{/if}
		{include
			file="frontend/components/pagination.tpl"
			prevUrl=$prevUrl
			nextUrl=$nextUrl
			showingStart=$showingStart
			showingEnd=$showingEnd
			total=$total
		}
	{/if}
</div>

{include file="frontend/components/footer.tpl"}
