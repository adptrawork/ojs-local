{**
* plugins/generic/browseBySection/templates/frontend/pages/section.tpl
*
* Copyright (c) 2017-2025 Simon Fraser University
* Copyright (c) 2017-2025 John Willinsky
* Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
* Adapted for the IndividualizeTheme by Sebastian Schmidt @ SLUB Dresden
*
* @brief Display the reader-facing section page.
*
* @uses $section Section
* @uses $sectionPath string The URL path for this section
* @uses $sectionDescription string
* @uses $articleGroups array List of Submission objects
* @uses $issues array List of Issue objects the $articles are published in
* @uses $prevPage int The previous page number
* @uses $nextPage int The next page number
* @uses $showingStart int The number of the first item on this page
* @uses $showingEnd int The number of the last item on this page
* @uses $total int Count of all published submissions in this category
*}

{extends file="frontend/layout.tpl"}

{block name="content"}
<div class="page">
    <main id="skip-to-main" class="page-wrapper">
        <h1 class="sr-only">{$section->getLocalizedTitle()|escape}</h1>
        <div class="page-heading">
            <h1 class="page-title">
                {$section->getLocalizedTitle()|escape}
            </h1>
        </div>
        <div class="page-content html-text">
            <p>{$sectionDescription|strip_unsafe_html}</p>
        </div>
        {if $articleGroups|@count}
        {foreach from=$articleGroups item=group}
        {if $group.key}
        <div class="cmp_article_header" id="browse_by_section_group_{$group.key|escape}">
            {$group.key|escape}
        </div>
        {/if}
        <ul class="issue-toc-articles">
            {foreach from=$group.articles item=article}
            {include
            file="frontend/components/article-summary.tpl"
            article=$article
            context=$currentContext
            cover=false
            galleys=true
            heading="h2"
            }
            {/foreach}
        </ul>
        {/foreach}

        {* Pagination *}
        {if $prevPage > 1}
        {capture assign="prevUrl"}{url|escape router=$smarty.const.ROUTE_PAGE page="section" op="view" path=$sectionPath|to_array:$prevPage}{/capture}
        {elseif $prevPage === 1}
        {capture assign="prevUrl"}{url|escape router=$smarty.const.ROUTE_PAGE page="section" op="view" path=$sectionPath}{/capture}
        {/if}
        {if $nextPage}
        {capture assign="nextUrl"}{url|escape router=$smarty.const.ROUTE_PAGE page="section" op="view" path=$sectionPath|to_array:$nextPage}{/capture}
        {/if}
        {include
        file="frontend/components/pagination.tpl"
        prevUrl=$prevUrl
        nextUrl=$nextUrl
        showingStart=$showingStart
        showingEnd=$showingEnd
        total=$total
        }

        {else}
        <p class="section_empty">
            {translate key="plugins.generic.browseBySection.emptySection"}
        </p>
        {/if}
    </main>
</div>


{/block}
