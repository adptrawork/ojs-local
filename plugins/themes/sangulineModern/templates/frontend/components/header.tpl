{**
 * SangulineModern child theme - header override (parent: Sanguline)
 * Preserves OJS/Smarty structure, hooks, menus, search, and accessibility.
 *}
{strip}
	{* Determine whether a logo or title string is being displayed *}
	{assign var="showingLogo" value=true}
	{if !$displayPageHeaderLogo}
		{assign var="showingLogo" value=false}
	{/if}
{/strip}
<!DOCTYPE html>
<html lang="{$currentLocale|replace:"_":"-"}" xml:lang="{$currentLocale|replace:"_":"-"}">
{if !$pageTitleTranslated}{capture assign="pageTitleTranslated"}{translate key=$pageTitle}{/capture}{/if}
{include file="frontend/components/headerHead.tpl"}
<body class="pkp_page_{$requestedPage|escape|default:"index"} pkp_op_{$requestedOp|escape|default:"index"}{if $showingLogo} has_site_logo{/if} jrdc-theme" dir="{$currentLocaleLangDir|escape|default:"ltr"}">

	<div class="pkp_structure_page jrdc-page">

		{* Header *}
		<header class="pkp_structure_head jrdc-header" id="headerNavigationContainer" role="banner">
			{* Skip to content nav links *}
			{include file="frontend/components/skipLinks.tpl"}

			<div class="pkp_head_wrapper jrdc-header__inner">

				<div class="pkp_site_name_wrapper jrdc-brand">
					<button class="pkp_site_nav_toggle jrdc-nav-toggle" type="button" aria-expanded="false" aria-controls="navigationPrimary" aria-label="{translate|escape key="common.navigation"}">
						<span class="jrdc-nav-toggle__label">Open Menu</span>
					</button>
					{if !$requestedPage || $requestedPage === 'index'}
						<h1 class="pkp_screen_reader">
							{if $currentContext}
								{$displayPageHeaderTitle|escape}
							{else}
								{$siteTitle|escape}
							{/if}
						</h1>
					{/if}
					<div class="pkp_site_name jrdc-brand__identity">
					{capture assign="homeUrl"}
						{url page="index" router=$smarty.const.ROUTE_PAGE}
					{/capture}
					{if $displayPageHeaderLogo}
						<a href="{$homeUrl}" class="is_img jrdc-brand__link">
							<img src="{$publicFilesDir}/{$displayPageHeaderLogo.uploadName|escape:"url"}" width="{$displayPageHeaderLogo.width|escape}" height="{$displayPageHeaderLogo.height|escape}" {if $displayPageHeaderLogo.altText != ''}alt="{$displayPageHeaderLogo.altText|escape}"{else}alt="{$displayPageHeaderTitle|escape|default:$siteTitle|escape}"{/if} />
						</a>
					{elseif $displayPageHeaderTitle}
						<a href="{$homeUrl}" class="jrdc-brand__link" style="display:flex; align-items:center; gap:0.75rem; text-decoration:none;">
							<div style="width:40px; height:40px; border-radius:10px; background:#0b2038; border:1.5px solid #d4af37; display:flex; align-items:center; justify-content:center; color:#d4af37; font-weight:800; font-size:0.85rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); shrink-0;">
								JRDC
							</div>
							<div style="display:flex; flex-direction:column; text-align:left;">
								<span style="font-size:0.875rem; font-weight:700; color:#0f172a; line-height:1.2;">Jurnal Ratu Dirgantara</span>
								<span style="font-size:0.7rem; font-weight:500; color:#64748b; line-height:1;">Cendekiawan</span>
							</div>
						</a>
					{else}
						<a href="{$homeUrl}" class="jrdc-brand__link" style="display:flex; align-items:center; gap:0.75rem; text-decoration:none;">
							<div style="width:40px; height:40px; border-radius:10px; background:#0b2038; border:1.5px solid #d4af37; display:flex; align-items:center; justify-content:center; color:#d4af37; font-weight:800; font-size:0.85rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); shrink-0;">
								JRDC
							</div>
							<div style="display:flex; flex-direction:column; text-align:left;">
								<span style="font-size:0.875rem; font-weight:700; color:#0f172a; line-height:1.2;">Jurnal Ratu Dirgantara</span>
								<span style="font-size:0.7rem; font-weight:500; color:#64748b; line-height:1;">Cendekiawan</span>
							</div>
						</a>
					{/if}
					</div>

					{* Sanguline - ISSN Display on header right *}
					{if $currentContext}
						<div class="pkp_header_issn jrdc-issn" aria-label="ISSN">
							{assign var="printIssn" value=$currentContext->getData('printIssn')}
							{assign var="onlineIssn" value=$currentContext->getData('onlineIssn')}
							{if $printIssn || $onlineIssn}
								<div class="issn_info jrdc-issn__list">
									{if $printIssn}
										<span class="issn_item jrdc-issn__item"><strong>p-ISSN:</strong> <span>{$printIssn|escape}</span></span>
									{/if}
									{if $onlineIssn}
										<span class="issn_item jrdc-issn__item"><strong>e-ISSN:</strong> <span>{$onlineIssn|escape}</span></span>
									{/if}
								</div>
							{/if}
						</div>
					{/if}
				</div>

				{capture assign="primaryMenu"}
					{load_menu name="primary" id="navigationPrimary" ulClass="pkp_navigation_primary"}
				{/capture}

				<nav class="pkp_site_nav_menu jrdc-nav" aria-label="{translate|escape key="common.navigation.site"}">
					<a id="siteNav"></a>
					<div class="pkp_navigation_primary_row jrdc-nav__row">
						<div class="pkp_navigation_primary_wrapper jrdc-nav__primary">
							{* Left side: Home + Primary Menu grouped together *}
							<div class="pkp_nav_left_group jrdc-nav__group">
								<div class="pkp_navigation_home jrdc-nav__home">
									<a href="{$homeUrl}" class="pkp_nav_home jrdc-nav__home-link">
										<span class="fa fa-home" aria-hidden="true"></span>
										<span class="nav_home_label">{translate key="plugins.themes.sanguline.navigation.home"}</span>
									</a>
								</div>

								{* Primary navigation menu *}
								{$primaryMenu}
							</div>

							{* Right side: Search form *}
							{if $currentContext}
								<div class="pkp_navigation_search_wrapper jrdc-nav__search">
									<form action="{url page="search" op="search"}" method="get" class="pkp_search_form jrdc-search" role="search">
										<label class="pkp_screen_reader" for="jrdc-search-query">{translate key="common.search"}</label>
										<input id="jrdc-search-query" type="search" name="query" placeholder="{translate key="common.search"}…" class="pkp_search_input jrdc-search__input" aria-label="{translate key="common.search"}" autocomplete="off" />
										<button type="submit" class="pkp_search_button jrdc-search__button" aria-label="{translate|escape key="common.search"}">
											<span class="fa fa-search" aria-hidden="true"></span>
										</button>
									</form>
								</div>
							{/if}
						</div>
					</div>
					<div class="pkp_navigation_user_wrapper jrdc-nav__user" id="navigationUserWrapper">
						{load_menu name="user" id="navigationUser" ulClass="pkp_navigation_user" liClass="profile"}
					</div>
				</nav>
			</div><!-- .pkp_head_wrapper -->
		</header><!-- .pkp_structure_head -->

		{* Wrapper for page content and sidebars *}
		{if $isFullWidth}
			{assign var=hasSidebar value=0}
		{/if}
		<div class="pkp_structure_content{if $hasSidebar} has_sidebar{/if} jrdc-content">
			<div class="pkp_structure_main jrdc-main" role="main">
				<a id="pkp_content_main"></a>
