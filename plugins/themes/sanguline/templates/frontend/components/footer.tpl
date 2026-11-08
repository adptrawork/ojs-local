{**
 * templates/frontend/components/footer.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief Common site frontend footer for Sangukara theme.
 *
 * @uses $isFullWidth bool Should this page be displayed without sidebars? This
 *       represents a page-level override, and doesn't indicate whether or not
 *       sidebars have been configured for thesite.
 *}

	</div><!-- pkp_structure_main -->

	{* Sidebars *}
	{if empty($isFullWidth)}
		{capture assign="sidebarCode"}{call_hook name="Templates::Common::Sidebar"}{/capture}
		{if $sidebarCode}
			<div class="pkp_structure_sidebar left" role="complementary">
				{* Sidebar Navigation Menu - appears at top of sidebar *}
				{capture assign="sidebarMenu"}{load_menu name="sidebar" id="navigationSidebar" ulClass="pkp_nav_list"}{/capture}
				{if $sidebarMenu|trim != ""}
					<div class="pkp_block block_sidebar_nav">
						<h3 class="pkp_block_title">{translate key="plugins.themes.sanguline.sidebar.additionalMenu"}</h3>
						{$sidebarMenu}
					</div>
				{/if}
				{$sidebarCode}
			</div><!-- pkp_sidebar.left -->
		{/if}
	{/if}
</div><!-- pkp_structure_content -->

<div class="pkp_structure_footer_wrapper" role="contentinfo">
	<a id="pkp_content_footer"></a>

	<div class="pkp_structure_footer">

		{if $pageFooter}
			<div class="pkp_footer_content">
				{$pageFooter}
			</div>
		{/if}

		{* Sanguline Theme Copyright - Protected *}
		<div class="sanguline_theme_credit" data-sanguline="protected" style="text-align:center;padding:1rem;font-size:0.85rem;opacity:0.9;">
			<span class="theme_credit_text">Sanguline Theme by</span>
			<a href="https://sanguilmu.com/" target="_blank" rel="noopener" class="theme_credit_link" style="color:inherit;text-decoration:underline;">Sangu Ilmu</a>
		</div>
	</div>
</div><!-- pkp_structure_footer_wrapper -->

</div><!-- pkp_structure_page -->

{load_script context="frontend"}

{call_hook name="Templates::Common::Footer::PageFooter"}
</body>
</html>
