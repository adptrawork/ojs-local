{**
 * SangulineModern child theme - header override (parent: Sanguline)
 * Bootstrap 5 navbar + responsive offcanvas. Preserves OJS hooks, menus,
 * search, and accessibility.
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
		<header class="pkp_structure_head jrdc-header sticky-top" id="headerNavigationContainer" role="banner">
			{* Skip to content nav links *}
			{include file="frontend/components/skipLinks.tpl"}

			<nav class="navbar navbar-expand-xl jrdc-navbar" aria-label="{translate|escape key="common.navigation.site"}">
				<div class="container-fluid jrdc-container jrdc-header__inner">

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
								<a href="{$homeUrl}" class="navbar-brand is_img jrdc-brand__link">
									<img src="{$publicFilesDir}/{$displayPageHeaderLogo.uploadName|escape:"url"}" width="{$displayPageHeaderLogo.width|escape}" height="{$displayPageHeaderLogo.height|escape}" {if $displayPageHeaderLogo.altText != ''}alt="{$displayPageHeaderLogo.altText|escape}"{else}alt="{$displayPageHeaderTitle|escape|default:$siteTitle|escape}"{/if} />
								</a>
							{else}
								<a href="{$homeUrl}" class="navbar-brand jrdc-brand__link">
									<span class="jrdc-brand__logo-box" aria-hidden="true">
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
									</span>
									<span class="jrdc-brand__text">
										<span class="jrdc-brand__name">Jurnal Ratu Dirgantara</span>
										<span class="jrdc-brand__sub">Cendekiawan</span>
									</span>
								</a>
							{/if}
						</div>
					</div>

					{capture assign="primaryMenu"}
						{load_menu name="primary" id="navigationPrimary" path="frontend/components/navigationMenuBootstrap.tpl" ulClass="navbar-nav pkp_navigation_primary"}
					{/capture}

					{* One responsive offcanvas: slide-in panel below xl, static navbar at xl+. *}
					<div class="offcanvas offcanvas-end jrdc-nav" tabindex="-1" id="jrdcSiteNav" aria-labelledby="jrdcNavLabel">
						<a id="siteNav"></a>
						<div class="offcanvas-header">
							<h2 class="offcanvas-title h5" id="jrdcNavLabel">{translate key="common.navigation.site"}</h2>
							<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="{translate|escape key="common.close"}"></button>
						</div>
						<div class="offcanvas-body jrdc-nav__body">

							{* Mobile-only: search form inside the panel *}
							{if $currentContext}
								<form action="{url page="search" op="search"}" method="get" class="d-xl-none jrdc-mobile-search mb-3" role="search">
									<label class="visually-hidden" for="jrdc-search-query-mobile">{translate key="common.search"}</label>
									<div class="input-group">
										<input id="jrdc-search-query-mobile" type="search" name="query" placeholder="Cari artikel..." class="form-control" autocomplete="off" />
										<button type="submit" class="btn btn-primary" aria-label="{translate|escape key="common.search"}">
											<svg class="jrdc-search__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"></path></svg>
										</button>
									</div>
								</form>
							{/if}

							<ul class="navbar-nav jrdc-nav__home me-xl-2">
								<li class="nav-item">
									<a href="{$homeUrl}" class="nav-link{if !$requestedPage || $requestedPage === 'index'} active{/if}">
										{translate key="navigation.home"}
									</a>
								</li>
							</ul>
							{$primaryMenu}

							{* Mobile-only: user/admin menu inside the panel *}
							<div class="d-xl-none jrdc-nav__mobile-user mt-3 pt-3 border-top">
								{load_menu name="user" id="navigationUserMobile" path="frontend/components/navigationMenuBootstrap.tpl" ulClass="navbar-nav pkp_navigation_user"}
							</div>
						</div>
					</div>

					{* Right: search + user menu + controls *}
					<div class="jrdc-header__actions d-flex align-items-center gap-2 ms-auto">

						{if $currentContext}
							<form action="{url page="search" op="search"}" method="get" class="d-none d-xl-block jrdc-header__search" role="search">
								<label class="visually-hidden" for="jrdc-search-query">{translate key="common.search"}</label>
								<div class="input-group">
									<input id="jrdc-search-query" type="search" name="query" placeholder="Cari artikel..." class="form-control" autocomplete="off" />
									<button type="submit" class="btn btn-primary" aria-label="{translate|escape key="common.search"}">
										<svg class="jrdc-search__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"></path></svg>
									</button>
								</div>
							</form>
						{/if}

						<div class="d-none d-xl-block jrdc-nav__user">
							{load_menu name="user" id="navigationUser" path="frontend/components/navigationMenuBootstrap.tpl" ulClass="navbar-nav pkp_navigation_user"}
						</div>

						<button class="navbar-toggler jrdc-nav-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#jrdcSiteNav" aria-controls="jrdcSiteNav" aria-label="Buka navigasi">
							<span class="navbar-toggler-icon"></span>
						</button>

						<button type="button" class="btn btn-outline-secondary jrdc-theme-toggle" data-jrdc-theme-toggle aria-pressed="false" title="Ganti mode gelap" aria-label="Ganti mode gelap">
							<svg class="jrdc-theme-toggle__icon jrdc-theme-toggle__icon--moon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
							</svg>
							<svg class="jrdc-theme-toggle__icon jrdc-theme-toggle__icon--sun" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
								<circle cx="12" cy="12" r="4"></circle>
								<path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"></path>
							</svg>
						</button>
					</div>
				</div>
			</nav>
		</header><!-- .pkp_structure_head -->

		{* Wrapper for page content and sidebars *}
		{if $isFullWidth}
			{assign var=hasSidebar value=0}
		{/if}
		{if !$suppressContentWrapper}
		<div class="container-fluid jrdc-content">
			<div class="row g-4">
				<div class="col-12 col-xl-8 pkp_structure_main jrdc-main" role="main">
					<a id="pkp_content_main"></a>
		{/if}
