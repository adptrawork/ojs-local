<?php
/* Smarty version 4.3.1, created on 2026-11-08 15:24:14
  from 'app:frontendobjectsarticle_summary.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6af0941ea962c8_97649903',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7cf1cd52b8ba8108de77f197078de34b733dd394' => 
    array (
      0 => 'app:frontendobjectsarticle_summary.tpl',
      1 => 1778098472,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
    'app:frontend/objects/galley_link.tpl' => 1,
  ),
),false)) {
function content_6af0941ea962c8_97649903 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'D:\\Projects\\ojs-3.3.0-24\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'D:\\Projects\\ojs-3.3.0-24\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.number_format.php','function'=>'smarty_modifier_number_format',),));
$_smarty_tpl->_assignInScope('publication', $_smarty_tpl->tpl_vars['article']->value->getCurrentPublication());
$_smarty_tpl->_assignInScope('articlePath', $_smarty_tpl->tpl_vars['article']->value->getBestId());
if (!$_smarty_tpl->tpl_vars['heading']->value) {?>
	<?php $_smarty_tpl->_assignInScope('heading', "h2");
}?>

<?php if ((!$_smarty_tpl->tpl_vars['section']->value['hideAuthor'] && $_smarty_tpl->tpl_vars['article']->value->getHideAuthor() == (defined('AUTHOR_TOC_DEFAULT') ? constant('AUTHOR_TOC_DEFAULT') : null)) || $_smarty_tpl->tpl_vars['article']->value->getHideAuthor() == (defined('AUTHOR_TOC_SHOW') ? constant('AUTHOR_TOC_SHOW') : null)) {?>
	<?php $_smarty_tpl->_assignInScope('showAuthor', true);
}?>

<div class="obj_article_summary">
	<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage')) {?>
		<div class="cover">
			<a <?php if ($_smarty_tpl->tpl_vars['journal']->value) {?>href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('journal'=>$_smarty_tpl->tpl_vars['journal']->value->getPath(),'page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['articlePath']->value),$_smarty_tpl ) );?>
"<?php } else { ?>href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['articlePath']->value),$_smarty_tpl ) );?>
"<?php }?> class="file">
				<?php $_smarty_tpl->_assignInScope('coverImage', $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage'));?>
				<img
					src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedCoverImageUrl($_smarty_tpl->tpl_vars['article']->value->getData('contextId')) ));?>
"
					alt="<?php echo (($tmp = call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['coverImage']->value['altText'] )) ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
				>
			</a>
		</div>
	<?php }?>

	<<?php echo $_smarty_tpl->tpl_vars['heading']->value;?>
 class="title">
		<a id="article-<?php echo $_smarty_tpl->tpl_vars['article']->value->getId();?>
" <?php if ($_smarty_tpl->tpl_vars['journal']->value) {?>href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('journal'=>$_smarty_tpl->tpl_vars['journal']->value->getPath(),'page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['articlePath']->value),$_smarty_tpl ) );?>
"<?php } else { ?>href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['articlePath']->value),$_smarty_tpl ) );?>
"<?php }?>>
			<?php if ($_smarty_tpl->tpl_vars['currentContext']->value) {?>
				<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedTitle() ));?>

				<?php $_smarty_tpl->_assignInScope('localizedSubtitle', call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('subtitle') )));?>
				<?php if ($_smarty_tpl->tpl_vars['localizedSubtitle']->value) {?>
					<span class="subtitle"><?php echo $_smarty_tpl->tpl_vars['localizedSubtitle']->value;?>
</span>
				<?php }?>
			<?php } else { ?>
				<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['article']->value->getLocalizedTitle() ));?>

				<span class="subtitle">
					<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['journal']->value->getLocalizedName() ));?>

				</span>
			<?php }?>
		</a>
	</<?php echo $_smarty_tpl->tpl_vars['heading']->value;?>
>

	<?php $_smarty_tpl->_assignInScope('submissionPages', $_smarty_tpl->tpl_vars['publication']->value->getData('pages'));?>
	<?php $_smarty_tpl->_assignInScope('submissionDatePublished', $_smarty_tpl->tpl_vars['publication']->value->getData('datePublished'));?>
	
	<div class="meta">
				<?php if ($_smarty_tpl->tpl_vars['showAuthor']->value) {?>
			<div class="authors">
				<?php $_smarty_tpl->_assignInScope('authors', $_smarty_tpl->tpl_vars['publication']->value->getData('authors'));?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['authors']->value, 'author', false, NULL, 'authorLoop', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_authorLoop']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_authorLoop']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_authorLoop']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_authorLoop']->value['total'];
?>
					<?php $_smarty_tpl->_assignInScope('affiliation', $_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation'));?>
					<?php $_smarty_tpl->_assignInScope('country', $_smarty_tpl->tpl_vars['author']->value->getCountryLocalized());?>
					<?php if ($_smarty_tpl->tpl_vars['affiliation']->value || $_smarty_tpl->tpl_vars['country']->value) {?>
						<span class="author_item has_tooltip">
							<span class="author_name"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));?>
</span>
							<span class="author_tooltip">
								<?php if ($_smarty_tpl->tpl_vars['affiliation']->value) {?>
									<span class="tooltip_row">
										<span class="fa fa-building" aria-hidden="true"></span>
										<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['affiliation']->value ));?>

									</span>
								<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['country']->value) {?>
									<span class="tooltip_row">
										<span class="fa fa-globe" aria-hidden="true"></span>
										<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['country']->value ));?>

									</span>
								<?php }?>
							</span>
						</span>
					<?php } else { ?>
						<span class="author_item">
							<span class="author_name"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));?>
</span>
						</span>
					<?php }?>
					<?php if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_authorLoop']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_authorLoop']->value['last'] : null)) {?><span class="author_separator">, </span><?php }?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</div>
		<?php }?>

				<div class="article_actions">
			<?php $_smarty_tpl->_assignInScope('articleAbstract', $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('abstract'));?>
			<?php if ($_smarty_tpl->tpl_vars['articleAbstract']->value) {?>
				<div class="abstract_toggle_wrapper">
					<button type="button" class="abstract_toggle" aria-expanded="false" aria-controls="abstract-<?php echo $_smarty_tpl->tpl_vars['article']->value->getId();?>
" data-toggle-target="abstract-<?php echo $_smarty_tpl->tpl_vars['article']->value->getId();?>
">
						<span class="fa fa-file-text-o" aria-hidden="true"></span>
						<span class="toggle_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.themes.sanguline.article.showAbstract"),$_smarty_tpl ) );?>
</span>
						<span class="fa fa-chevron-down toggle_icon" aria-hidden="true"></span>
					</button>
				</div>
			<?php }?>

			<?php if (!$_smarty_tpl->tpl_vars['hideGalleys']->value) {?>
				<ul class="galleys_links">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['article']->value->getGalleys(), 'galley');
$_smarty_tpl->tpl_vars['galley']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['galley']->value) {
$_smarty_tpl->tpl_vars['galley']->do_else = false;
?>
						<?php if ($_smarty_tpl->tpl_vars['primaryGenreIds']->value) {?>
							<?php $_smarty_tpl->_assignInScope('file', $_smarty_tpl->tpl_vars['galley']->value->getFile());?>
							<?php if (!$_smarty_tpl->tpl_vars['galley']->value->getRemoteUrl() && !($_smarty_tpl->tpl_vars['file']->value && in_array($_smarty_tpl->tpl_vars['file']->value->getGenreId(),$_smarty_tpl->tpl_vars['primaryGenreIds']->value))) {?>
								<?php continue 1;?>
							<?php }?>
						<?php }?>
						<li>
							<?php $_smarty_tpl->_assignInScope('hasArticleAccess', $_smarty_tpl->tpl_vars['hasAccess']->value);?>
							<?php if ($_smarty_tpl->tpl_vars['currentContext']->value->getSetting('publishingMode') == (defined('PUBLISHING_MODE_OPEN') ? constant('PUBLISHING_MODE_OPEN') : null) || $_smarty_tpl->tpl_vars['publication']->value->getData('accessStatus') == (defined('ARTICLE_ACCESS_OPEN') ? constant('ARTICLE_ACCESS_OPEN') : null)) {?>
								<?php $_smarty_tpl->_assignInScope('hasArticleAccess', 1);?>
							<?php }?>
							<?php $_smarty_tpl->_assignInScope('id', "article-".((string)$_smarty_tpl->tpl_vars['article']->value->getId())."-galley-".((string)$_smarty_tpl->tpl_vars['galley']->value->getId()));?>
							<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/galley_link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('parent'=>$_smarty_tpl->tpl_vars['article']->value,'publication'=>$_smarty_tpl->tpl_vars['publication']->value,'id'=>$_smarty_tpl->tpl_vars['id']->value,'labelledBy'=>((string)$_smarty_tpl->tpl_vars['id']->value)." article-".((string)$_smarty_tpl->tpl_vars['article']->value->getId()),'hasAccess'=>$_smarty_tpl->tpl_vars['hasArticleAccess']->value,'purchaseFee'=>$_smarty_tpl->tpl_vars['currentJournal']->value->getData('purchaseArticleFee'),'purchaseCurrency'=>$_smarty_tpl->tpl_vars['currentJournal']->value->getData('currency')), 0, true);
?>
						</li>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</ul>
			<?php }?>
		</div>

				<?php if ($_smarty_tpl->tpl_vars['articleAbstract']->value) {?>
			<div class="abstract_content" id="abstract-<?php echo $_smarty_tpl->tpl_vars['article']->value->getId();?>
" hidden>
				<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['articleAbstract']->value ));?>

			</div>
		<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['submissionPages']->value) {?>
			<div class="pages">
				<span class="label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.themes.sanguline.article.pages"),$_smarty_tpl ) );?>
:</span>
				<span class="value"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['submissionPages']->value ));?>
</span>
			</div>
		<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['showDatePublished']->value && $_smarty_tpl->tpl_vars['submissionDatePublished']->value) {?>
			<div class="published">
				<span class="label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submissions.published"),$_smarty_tpl ) );?>
:</span>
				<span class="value"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['submissionDatePublished']->value,$_smarty_tpl->tpl_vars['dateFormatShort']->value);?>
</span>
			</div>
		<?php }?>

				<?php $_smarty_tpl->_assignInScope('doiUrl', '');?>
		<?php if ($_smarty_tpl->tpl_vars['currentJournal']->value) {?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pubIdPlugins']->value, 'pubIdPlugin');
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pubIdPlugin']->value) {
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = false;
?>
				<?php if ($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType() == 'doi') {?>
					<?php $_smarty_tpl->_assignInScope('pubId', $_smarty_tpl->tpl_vars['article']->value->getStoredPubId('doi'));?>
					<?php if ($_smarty_tpl->tpl_vars['pubId']->value) {?>
						<?php $_smarty_tpl->_assignInScope('doiUrl', call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getResolvingURL($_smarty_tpl->tpl_vars['currentJournal']->value->getId(),$_smarty_tpl->tpl_vars['pubId']->value) )));?>
					<?php }?>
					<?php break 1;?>
				<?php }?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['doiUrl']->value) {?>
			<div class="doi">
				<span class="label">DOI:</span>
				<a href="<?php echo $_smarty_tpl->tpl_vars['doiUrl']->value;?>
" target="_blank" class="value"><?php echo $_smarty_tpl->tpl_vars['doiUrl']->value;?>
</a>
			</div>
		<?php }?>

				<?php $_smarty_tpl->_assignInScope('abstractViews', $_smarty_tpl->tpl_vars['article']->value->getViews());?>
		<?php $_smarty_tpl->_assignInScope('totalDownloads', 0);?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['article']->value->getGalleys(), 'statsGalley');
$_smarty_tpl->tpl_vars['statsGalley']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['statsGalley']->value) {
$_smarty_tpl->tpl_vars['statsGalley']->do_else = false;
?>
			<?php $_smarty_tpl->_assignInScope('totalDownloads', $_smarty_tpl->tpl_vars['totalDownloads']->value+$_smarty_tpl->tpl_vars['statsGalley']->value->getViews());?>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		<div class="article_stats">
			<span class="stat_item views">
				<span class="fa fa-eye" aria-hidden="true"></span>
				<span class="stat_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.themes.sanguline.article.views"),$_smarty_tpl ) );?>
:</span>
				<span class="stat_value"><?php echo smarty_modifier_number_format((($tmp = $_smarty_tpl->tpl_vars['abstractViews']->value ?? null)===null||$tmp==='' ? 0 ?? null : $tmp));?>
</span>
			</span>
			<span class="stat_item downloads">
				<span class="fa fa-download" aria-hidden="true"></span>
				<span class="stat_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.themes.sanguline.article.downloads"),$_smarty_tpl ) );?>
:</span>
				<span class="stat_value"><?php echo smarty_modifier_number_format((($tmp = $_smarty_tpl->tpl_vars['totalDownloads']->value ?? null)===null||$tmp==='' ? 0 ?? null : $tmp));?>
</span>
			</span>
		</div>

	<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Issue::Issue::Article"),$_smarty_tpl ) );?>

</div>
<?php }
}
