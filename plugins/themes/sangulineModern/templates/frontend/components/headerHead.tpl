{**
 * templates/frontend/components/headerHead.tpl
 *
 * SangulineModern override: same head contract as OJS 3.3 core, plus an
 * inline anti-flash script so the saved dark mode applies before first paint.
 *}
<head>
	<meta charset="{$defaultCharset|escape}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
	<meta name="theme-color" content="#0b1220" media="(prefers-color-scheme: dark)">
	<title>
		{$pageTitleTranslated|strip_tags}
		{* Add the journal name to the end of page titles *}
		{if $requestedPage|escape|default:"index" != 'index' && $currentContext && $currentContext->getLocalizedName()}
			| {$currentContext->getLocalizedName()}
		{/if}
	</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<script>
	(function () {
		try {
			if (localStorage.getItem('jrdc-theme') === 'dark') {
				document.documentElement.classList.add('dark');
				document.documentElement.setAttribute('data-bs-theme', 'dark');
			}
		} catch (e) { /* localStorage unavailable */ }
	})();
	</script>

	{load_header context="frontend"}
	{load_stylesheet context="frontend"}
</head>
