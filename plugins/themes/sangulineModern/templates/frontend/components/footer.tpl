{**
 * SangulineModern child theme - footer override (parent: Sanguline)
 * Preserves OJS sidebar hook, footer hook, scripts, and layout structure.
 *}

	</div><!-- pkp_structure_main -->

	{* Sidebars *}
	{if empty($isFullWidth)}
		{capture assign="sidebarCode"}{call_hook name="Templates::Common::Sidebar"}{/capture}
		{if $sidebarCode}
			<div class="pkp_structure_sidebar left jrdc-sidebar" role="complementary" aria-label="{translate|escape key="common.navigation.sidebar"}">
				{* Sidebar Navigation Menu - appears at top of sidebar *}
				{capture assign="sidebarMenu"}{load_menu name="sidebar" id="navigationSidebar" ulClass="pkp_nav_list"}{/capture}
				{if $sidebarMenu|trim != ""}
					<div class="pkp_block block_sidebar_nav jrdc-sidebar__nav">
						<h2 class="pkp_block_title jrdc-sidebar__title">{translate key="plugins.themes.sanguline.sidebar.additionalMenu"}</h2>
						{$sidebarMenu}
					</div>
				{/if}
				{$sidebarCode}
			</div><!-- pkp_sidebar.left -->
		{/if}
	{/if}
</div><!-- pkp_structure_content -->

<footer class="pkp_structure_footer_wrapper jrdc-footer" role="contentinfo">
	<a id="pkp_content_footer"></a>

	<div class="pkp_structure_footer jrdc-footer__inner">

		{if $pageFooter}
			<div class="pkp_footer_content jrdc-footer__content">
				{$pageFooter}
			</div>
		{/if}

		{* Sanguline Theme Copyright - Protected *}
		<div class="sanguline_theme_credit jrdc-footer__credit" data-sanguline="protected">
			<span class="theme_credit_text">Sanguline Theme by</span>
			<a href="https://sanguilmu.com/" target="_blank" rel="noopener noreferrer" class="theme_credit_link">Sangu Ilmu</a>
		</div>
	</div>
</footer><!-- pkp_structure_footer_wrapper -->

</div><!-- pkp_structure_page -->

{load_script context="frontend"}

{call_hook name="Templates::Common::Footer::PageFooter"}
</body>
</html>
