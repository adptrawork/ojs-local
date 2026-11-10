{**
 * Bootstrap 5 navbar menu.
 *
 * Same OJS navigation tree as core navigationMenu.tpl, rendered with
 * Bootstrap navbar/dropdown classes. Used only by the header; the sidebar
 * keeps the core template.
 *
 * @uses $navigationMenu array
 * @uses $id string
 * @uses $ulClass string
 *}
{if $navigationMenu}
	<ul id="{$id|escape}" class="{$ulClass|escape} pkp_nav_list">
		{foreach key=field item=navigationMenuItemAssignment from=$navigationMenu->menuTree}
			{if !$navigationMenuItemAssignment->navigationMenuItem->getIsDisplayed()}
				{continue}
			{/if}
			{assign var="hasChildren" value=$navigationMenuItemAssignment->navigationMenuItem->getIsChildVisible()}
			<li class="nav-item{if $hasChildren} dropdown{/if}">
				{if $hasChildren}
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						{$navigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}
					</a>
					<ul class="dropdown-menu">
						{foreach key=childField item=childNavigationMenuItemAssignment from=$navigationMenuItemAssignment->children}
							{if $childNavigationMenuItemAssignment->navigationMenuItem->getIsDisplayed()}
								<li>
									<a class="dropdown-item" href="{$childNavigationMenuItemAssignment->navigationMenuItem->getUrl()}">
										{$childNavigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}
									</a>
								</li>
							{/if}
						{/foreach}
					</ul>
				{else}
					<a class="nav-link" href="{$navigationMenuItemAssignment->navigationMenuItem->getUrl()}">
						{$navigationMenuItemAssignment->navigationMenuItem->getLocalizedTitle()}
					</a>
				{/if}
			</li>
		{/foreach}
	</ul>
{/if}
