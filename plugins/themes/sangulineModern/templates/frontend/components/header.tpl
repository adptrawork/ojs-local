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
					{else}
						<a href="{$homeUrl}" class="jrdc-brand__link">
							<div class="jrdc-brand__logo-box">
								<svg class="jrdc-brand__logo-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
									<defs>
										<linearGradient id="navHeaderBlue" x1="0%" y1="0%" x2="100%" y2="100%">
											<stop offset="0%" stop-color="#0F284E"></stop>
											<stop offset="100%" stop-color="#0A192F"></stop>
										</linearGradient>
										<linearGradient id="navHeaderGold" x1="0%" y1="0%" x2="100%" y2="100%">
											<stop offset="0%" stop-color="#F6D365"></stop>
											<stop offset="100%" stop-color="#D4AF37"></stop>
										</linearGradient>
									</defs>
									<rect x="4" y="4" width="56" height="56" rx="12" fill="url(#navHeaderBlue)" stroke="url(#navHeaderGold)" stroke-width="2"></rect>
									<path d="M18 42C23 39.5 28.5 39.8 32 42.5C35.5 39.8 41 39.5 46 42V26C41 23.5 35.5 23.8 32 26.5C28.5 23.8 23 23.5 18 26V42Z" fill="none" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" opacity="0.9"></path>
									<line x1="32" y1="26.5" x2="32" y2="42.5" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round" opacity="0.9"></line>
									<path d="M20 35L27 29L33 32L43 20" fill="none" stroke="url(#navHeaderGold)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
									<path d="M38 20H43V25" fill="none" stroke="url(#navHeaderGold)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
									<circle cx="32" cy="17" r="1.8" fill="url(#navHeaderGold)"></circle>
								</svg>
							</div>
							<div class="jrdc-brand__text">
								<span class="jrdc-brand__name">Jurnal Ratu Dirgantara</span>
								<span class="jrdc-brand__sub">Cendekiawan</span>
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

				{* Center: Search (flexible, shrinks on small screens) *}
				{if $currentContext}
					<div class="pkp_navigation_search_wrapper jrdc-header__search jrdc-nav__search">
						<form action="{url page="search" op="search"}" method="get" class="pkp_search_form jrdc-search" role="search">
							<label class="pkp_screen_reader" for="jrdc-search-query">{translate key="common.search"}</label>
							<input id="jrdc-search-query" type="search" name="query" placeholder="Cari artikel..." class="pkp_search_input jrdc-search__input" aria-label="{translate key="common.search"}" autocomplete="off" />
							<button type="submit" class="pkp_search_button jrdc-search__button" aria-label="{translate|escape key="common.search"}">
								<svg class="jrdc-search__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"></path></svg>
							</button>
						</form>
					</div>
				{/if}

				{capture assign="primaryMenu"}
					{load_menu name="primary" id="navigationPrimary" ulClass="pkp_navigation_primary"}
				{/capture}

				{* Middle Navigation Menu *}
				<nav id="jrdcSiteNav" class="pkp_site_nav_menu jrdc-nav" aria-label="{translate|escape key="common.navigation.site"}">
					<a id="siteNav"></a>

					{* Mobile-only: search form inside dropdown panel *}
					{if $currentContext}
						<div class="jrdc-mobile-search" aria-hidden="false">
							<form action="{url page="search" op="search"}" method="get" class="pkp_search_form jrdc-search" role="search">
								<label class="pkp_screen_reader" for="jrdc-search-query-mobile">{translate key="common.search"}</label>
								<input id="jrdc-search-query-mobile" type="search" name="query" placeholder="Cari artikel..." class="pkp_search_input jrdc-search__input" aria-label="{translate key="common.search"}" autocomplete="off" />
								<button type="submit" class="pkp_search_button jrdc-search__button" aria-label="{translate|escape key="common.search"}">
									<svg class="jrdc-search__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"></path></svg>
								</button>
							</form>
						</div>
					{/if}

					<div class="jrdc-nav__wrapper">
						<div class="pkp_navigation_home jrdc-nav__home">
							<a href="{$homeUrl}" class="pkp_nav_home jrdc-nav__home-link{if !$requestedPage || $requestedPage === 'index'} active{/if}">
								{if $currentLocale == 'id_ID'}Beranda{else}{translate key="plugins.themes.sanguline.navigation.home"|default:"Home"}{/if}
							</a>
						</div>
						{$primaryMenu}
					</div>

					{* Mobile-only: user/admin menu inside dropdown panel *}
					<div class="jrdc-mobile-user" aria-label="{translate|escape key="common.navigation.user"}">
						{load_menu name="user" id="navigationUserMobile" ulClass="pkp_navigation_user" liClass="profile"}
					</div>
				</nav>

				{* Right: User menu + controls (hamburger + dark toggle) *}
				<div class="jrdc-header__actions">
					<div class="pkp_navigation_user_wrapper jrdc-nav__user" id="navigationUserWrapper">
						{load_menu name="user" id="navigationUser" ulClass="pkp_navigation_user" liClass="profile"}
					</div>

					<div class="jrdc-header__controls">
						<button class="pkp_site_nav_toggle jrdc-nav-toggle" type="button" aria-expanded="false" aria-controls="jrdcSiteNav" aria-label="{translate|escape key="common.navigation"}">
							<span class="jrdc-nav-toggle__icon" aria-hidden="true">
								<span></span>
								<span></span>
								<span></span>
							</span>
							<span class="jrdc-nav-toggle__label">Menu</span>
						</button>

						<button type="button" class="jrdc-theme-toggle" onclick="document.documentElement.classList.toggle('dark')" title="Ganti Mode" aria-label="Ganti Mode">
							<svg class="jrdc-theme-toggle__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
							</svg>
						</button>
					</div>
				</div>
			</div><!-- .pkp_head_wrapper -->
		</header><!-- .pkp_structure_head -->

		{* Wrapper for page content and sidebars *}
		{if $isFullWidth}
			{assign var=hasSidebar value=0}
		{/if}
		{if !$suppressContentWrapper}
		<div class="pkp_structure_content{if $hasSidebar} has_sidebar{/if} jrdc-content">
			<div class="pkp_structure_main jrdc-main" role="main">
				<a id="pkp_content_main"></a>
		{/if}
