<?php
/* Smarty version 4.3.1, created on 2026-11-08 15:31:22
  from 'app:frontendobjectsarticle_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6af095ca955db1_78040649',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'addd65021fadf964339ab08cd1aa93ba59b14e9c' => 
    array (
      0 => 'app:frontendobjectsarticle_details.tpl',
      1 => 1778098472,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
    'app:frontend/objects/galley_link.tpl' => 2,
  ),
),false)) {
function content_6af095ca955db1_78040649 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'D:\\Projects\\ojs-3.3.0-24\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
 <?php if (!$_smarty_tpl->tpl_vars['heading']->value) {?>
 	<?php $_smarty_tpl->_assignInScope('heading', "h3");?>
 <?php }?>
<article class="obj_article_details">

		<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('status') !== (defined('STATUS_PUBLISHED') ? constant('STATUS_PUBLISHED') : null)) {?>
	<div class="cmp_notification notice">
		<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "submissionUrl", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"workflow",'op'=>"access",'path'=>$_smarty_tpl->tpl_vars['article']->value->getId()),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.viewingPreview",'url'=>$_smarty_tpl->tpl_vars['submissionUrl']->value),$_smarty_tpl ) );?>

	</div>
		<?php } elseif ($_smarty_tpl->tpl_vars['currentPublication']->value->getId() !== $_smarty_tpl->tpl_vars['publication']->value->getId()) {?>
		<div class="cmp_notification notice">
			<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "latestVersionUrl", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['article']->value->getBestId()),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.outdatedVersion",'datePublished'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['publication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value),'urlRecentVersion'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['latestVersionUrl']->value ))),$_smarty_tpl ) );?>

		</div>
	<?php }?>

	<h1 class="page_title">
		<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedTitle() ));?>

	</h1>

	<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('subtitle')) {?>
		<h2 class="subtitle">
			<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('subtitle') ));?>

		</h2>
	<?php }?>

	<div class="row">
		<div class="main_entry">

			<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('authors')) {?>
				<section class="item authors">
					<h2 class="pkp_screen_reader"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"article.authors"),$_smarty_tpl ) );?>
</h2>
					<ul class="authors">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getData('authors'), 'author');
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
?>
						<li>
							<span class="name">
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));?>

							</span>
							<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation')) {?>
								<span class="affiliation">
									<span class="fa fa-building" aria-hidden="true"></span> <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation') ));?>

									<?php if ($_smarty_tpl->tpl_vars['author']->value->getData('rorId')) {?>
										<a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getData('rorId') ));?>
"><?php echo $_smarty_tpl->tpl_vars['rorIdIcon']->value;?>
</a>
									<?php }?>
								</span>
							<?php }?>
						<?php $_smarty_tpl->_assignInScope('authorCountry', $_smarty_tpl->tpl_vars['author']->value->getCountryLocalized());?>
						<?php if ($_smarty_tpl->tpl_vars['authorCountry']->value) {?>
							<span class="country">
								<span class="fa fa-globe" aria-hidden="true"></span>
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['authorCountry']->value ));?>

							</span>
						<?php }?>
							<?php $_smarty_tpl->_assignInScope('authorUserGroup', null);?>
							<?php if (!empty($_smarty_tpl->tpl_vars['userGroupsById']->value[$_smarty_tpl->tpl_vars['author']->value->getData('userGroupId')])) {?>
								<?php $_smarty_tpl->_assignInScope('authorUserGroup', $_smarty_tpl->tpl_vars['userGroupsById']->value[$_smarty_tpl->tpl_vars['author']->value->getData('userGroupId')]);?>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['authorUserGroup']->value && $_smarty_tpl->tpl_vars['authorUserGroup']->value->getShowTitle()) {?>
								<span class="userGroup">
									<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['authorUserGroup']->value->getLocalizedName() ));?>

								</span>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['author']->value->getData('orcid')) {?>
								<span class="orcid">
									<?php if ($_smarty_tpl->tpl_vars['author']->value->getData('orcidAccessToken')) {?>
										<?php echo $_smarty_tpl->tpl_vars['orcidIcon']->value;?>

									<?php }?>
									<a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getData('orcid') ));?>
" target="_blank">
										<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getData('orcid') ));?>

									</a>
								</span>
							<?php }?>
						</li>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</section>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['currentJournal']->value) {?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pubIdPlugins']->value, 'pubIdPlugin');
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pubIdPlugin']->value) {
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = false;
?>
					<?php if ($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType() != 'doi') {?>
						<?php continue 1;?>
					<?php }?>
					<?php $_smarty_tpl->_assignInScope('pubId', $_smarty_tpl->tpl_vars['article']->value->getStoredPubId($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType()));?>
					<?php if ($_smarty_tpl->tpl_vars['pubId']->value) {?>
						<?php $_smarty_tpl->_assignInScope('doiUrl', call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getResolvingURL($_smarty_tpl->tpl_vars['currentJournal']->value->getId(),$_smarty_tpl->tpl_vars['pubId']->value) )));?>
						<section class="item doi">
							<h2 class="label">
								<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'translatedDOI', null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.pubIds.doi.readerDisplayName"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"semicolon",'label'=>$_smarty_tpl->tpl_vars['translatedDOI']->value),$_smarty_tpl ) );?>

							</h2>
							<span class="value">
								<a href="<?php echo $_smarty_tpl->tpl_vars['doiUrl']->value;?>
">
									<?php echo $_smarty_tpl->tpl_vars['doiUrl']->value;?>

								</a>
							</span>
						</section>
					<?php }?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('abstract')) {?>
				<section class="item abstract">
					<h2 class="label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"article.abstract"),$_smarty_tpl ) );?>
</h2>
					<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('abstract') ));?>

				</section>
			<?php }?>

						<?php if (!empty($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('keywords'))) {?>
			<section class="item keywords">
				<h2 class="label">
					<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'translatedKeywords', null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"article.subject"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"semicolon",'label'=>$_smarty_tpl->tpl_vars['translatedKeywords']->value),$_smarty_tpl ) );?>

				</h2>
				<span class="value">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('keywords'), 'keyword', false, NULL, 'keywords', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
$_smarty_tpl->tpl_vars['keyword']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['keyword']->value) {
$_smarty_tpl->tpl_vars['keyword']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['total'];
?>
						<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['keyword']->value ));
if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_keywords']->value['last'] : null)) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.commaListSeparator"),$_smarty_tpl ) );
}?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				</span>
			</section>
			<?php }?>

			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Article::Main"),$_smarty_tpl ) );?>


						<?php if ($_smarty_tpl->tpl_vars['activeTheme']->value && $_smarty_tpl->tpl_vars['activeTheme']->value->getOption('displayStats') != 'none' && $_smarty_tpl->tpl_vars['activeTheme']->value->supportsUsageStats()) {?>
				<section class="item downloads_chart">
					<h2 class="label">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.themes.sanguline.displayStats.downloads"),$_smarty_tpl ) );?>

					</h2>
					<div class="value">
						<canvas class="usageStatsGraph" data-object-type="Submission" data-object-id="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['article']->value->getId() ));?>
"></canvas>
						<div class="usageStatsUnavailable" data-object-type="Submission" data-object-id="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['article']->value->getId() ));?>
">
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.themes.sanguline.displayStats.noStats"),$_smarty_tpl ) );?>

						</div>
					</div>
				</section>
			<?php }?>

						<?php $_smarty_tpl->_assignInScope('hasBiographies', 0);?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getData('authors'), 'author');
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
?>
				<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('biography')) {?>
					<?php $_smarty_tpl->_assignInScope('hasBiographies', $_smarty_tpl->tpl_vars['hasBiographies']->value+1);?>
				<?php }?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<?php if ($_smarty_tpl->tpl_vars['hasBiographies']->value) {?>
				<section class="item author_bios">
					<h2 class="label">
						<?php if ($_smarty_tpl->tpl_vars['hasBiographies']->value > 1) {?>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.authorBiographies"),$_smarty_tpl ) );?>

						<?php } else { ?>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.authorBiography"),$_smarty_tpl ) );?>

						<?php }?>
					</h2>
					<ul class="authors">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['publication']->value->getData('authors'), 'author');
$_smarty_tpl->tpl_vars['author']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['author']->value) {
$_smarty_tpl->tpl_vars['author']->do_else = false;
?>
						<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('biography')) {?>
							<li class="sub_item">
								<div class="label">
									<?php if ($_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation')) {?>
										<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "authorName", null);
echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
										<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "authorAffiliation", null);?> <span class="fa fa-building" aria-hidden="true"></span> <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getLocalizedData('affiliation') ));?>
 <?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
										<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.authorWithAffiliation",'name'=>$_smarty_tpl->tpl_vars['authorName']->value,'affiliation'=>$_smarty_tpl->tpl_vars['authorAffiliation']->value),$_smarty_tpl ) );?>

									<?php } else { ?>
										<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getFullName() ));?>

									<?php }?>
								</div>
								<div class="value">
									<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['author']->value->getLocalizedData('biography') ));?>

								</div>
							</li>
						<?php }?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</section>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['parsedCitations']->value || $_smarty_tpl->tpl_vars['publication']->value->getData('citationsRaw')) {?>
				<section class="item references">
					<h2 class="label">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.citations"),$_smarty_tpl ) );?>

					</h2>
					<div class="value">
						<?php if ($_smarty_tpl->tpl_vars['parsedCitations']->value) {?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['parsedCitations']->value, 'parsedCitation');
$_smarty_tpl->tpl_vars['parsedCitation']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['parsedCitation']->value) {
$_smarty_tpl->tpl_vars['parsedCitation']->do_else = false;
?>
								<p><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['parsedCitation']->value->getCitationWithLinks() ));?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Article::Details::Reference",'citation'=>$_smarty_tpl->tpl_vars['parsedCitation']->value),$_smarty_tpl ) );?>
</p>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						<?php } else { ?>
							<?php echo nl2br((string) call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getData('citationsRaw') )), (bool) 1);?>

						<?php }?>
					</div>
				</section>
			<?php }?>

		</div><!-- .main_entry -->

		<div class="entry_details">

						<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage') || ($_smarty_tpl->tpl_vars['issue']->value && $_smarty_tpl->tpl_vars['issue']->value->getLocalizedCoverImage())) {?>
				<div class="item cover_image">
					<div class="sub_item">
						<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage')) {?>
							<?php $_smarty_tpl->_assignInScope('coverImage', $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('coverImage'));?>
							<img
								src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedCoverImageUrl($_smarty_tpl->tpl_vars['article']->value->getData('contextId')) ));?>
"
								alt="<?php echo (($tmp = call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['coverImage']->value['altText'] )) ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
							>
						<?php } else { ?>
							<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"issue",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['issue']->value->getBestIssueId()),$_smarty_tpl ) );?>
">
								<img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['issue']->value->getLocalizedCoverImageUrl() ));?>
" alt="<?php echo (($tmp = call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['issue']->value->getLocalizedCoverImageAltText() )) ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
">
							</a>
						<?php }?>
					</div>
				</div>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['primaryGalleys']->value) {?>
				<div class="item galleys">
					<h2 class="pkp_screen_reader">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.downloads"),$_smarty_tpl ) );?>

					</h2>
					<ul class="value galleys_links">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['primaryGalleys']->value, 'galley');
$_smarty_tpl->tpl_vars['galley']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['galley']->value) {
$_smarty_tpl->tpl_vars['galley']->do_else = false;
?>
							<li>
								<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/galley_link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('parent'=>$_smarty_tpl->tpl_vars['article']->value,'publication'=>$_smarty_tpl->tpl_vars['publication']->value,'galley'=>$_smarty_tpl->tpl_vars['galley']->value,'purchaseFee'=>$_smarty_tpl->tpl_vars['currentJournal']->value->getData('purchaseArticleFee'),'purchaseCurrency'=>$_smarty_tpl->tpl_vars['currentJournal']->value->getData('currency')), 0, true);
?>
							</li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['supplementaryGalleys']->value) {?>
				<div class="item galleys">
					<h3 class="pkp_screen_reader">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.additionalFiles"),$_smarty_tpl ) );?>

					</h3>
					<ul class="value supplementary_galleys_links">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['supplementaryGalleys']->value, 'galley');
$_smarty_tpl->tpl_vars['galley']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['galley']->value) {
$_smarty_tpl->tpl_vars['galley']->do_else = false;
?>
							<li>
								<?php $_smarty_tpl->_subTemplateRender("app:frontend/objects/galley_link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('parent'=>$_smarty_tpl->tpl_vars['article']->value,'publication'=>$_smarty_tpl->tpl_vars['publication']->value,'galley'=>$_smarty_tpl->tpl_vars['galley']->value,'isSupplementary'=>"1"), 0, true);
?>
							</li>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</ul>
				</div>
			<?php }?>

			<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('datePublished')) {?>
			<div class="item published">
				<section class="sub_item">
					<h2 class="label">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submissions.published"),$_smarty_tpl ) );?>

					</h2>
					<div class="value">
												<?php if ($_smarty_tpl->tpl_vars['firstPublication']->value->getId() === $_smarty_tpl->tpl_vars['publication']->value->getId()) {?>
							<span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['firstPublication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value);?>
</span>
												<?php } else { ?>
							<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.updatedOn",'datePublished'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['firstPublication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value),'dateUpdated'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['publication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value)),$_smarty_tpl ) );?>
</span>
						<?php }?>
					</div>
				</section>
				<?php if (count($_smarty_tpl->tpl_vars['article']->value->getPublishedPublications()) > 1) {?>
					<section class="sub_item versions">
						<h2 class="label">
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.versions"),$_smarty_tpl ) );?>

						</h2>
						<ul class="value">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array_reverse($_smarty_tpl->tpl_vars['article']->value->getPublishedPublications()), 'iPublication');
$_smarty_tpl->tpl_vars['iPublication']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['iPublication']->value) {
$_smarty_tpl->tpl_vars['iPublication']->do_else = false;
?>
								<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "name", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.versionIdentity",'datePublished'=>smarty_modifier_date_format($_smarty_tpl->tpl_vars['iPublication']->value->getData('datePublished'),$_smarty_tpl->tpl_vars['dateFormatShort']->value),'version'=>$_smarty_tpl->tpl_vars['iPublication']->value->getData('version')),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
								<li>
									<?php if ($_smarty_tpl->tpl_vars['iPublication']->value->getId() === $_smarty_tpl->tpl_vars['publication']->value->getId()) {?>
										<?php echo $_smarty_tpl->tpl_vars['name']->value;?>

									<?php } elseif ($_smarty_tpl->tpl_vars['iPublication']->value->getId() === $_smarty_tpl->tpl_vars['currentPublication']->value->getId()) {?>
										<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['article']->value->getBestId()),$_smarty_tpl ) );?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
									<?php } else { ?>
										<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"article",'op'=>"view",'path'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'to_array' ][ 0 ], array( $_smarty_tpl->tpl_vars['article']->value->getBestId(),"version",$_smarty_tpl->tpl_vars['iPublication']->value->getId() ))),$_smarty_tpl ) );?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a>
									<?php }?>
								</li>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</ul>
					</section>
				<?php }?>
			</div>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('dataAvailability')) {?>
				<section class="item dataAvailability" id="data-availability-statement">
					<h2 class="label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.dataAvailability"),$_smarty_tpl ) );?>
</h2>
					<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('dataAvailability') ));?>

				</section>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['issue']->value || $_smarty_tpl->tpl_vars['section']->value || $_smarty_tpl->tpl_vars['categories']->value) {?>
				<div class="item issue">

					<?php if ($_smarty_tpl->tpl_vars['issue']->value) {?>
						<section class="sub_item">
							<h2 class="label">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"issue.issue"),$_smarty_tpl ) );?>

							</h2>
							<div class="value">
								<a class="title" href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"issue",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['issue']->value->getBestIssueId()),$_smarty_tpl ) );?>
">
									<?php echo $_smarty_tpl->tpl_vars['issue']->value->getIssueIdentification();?>

								</a>
							</div>
						</section>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['section']->value) {?>
						<section class="sub_item">
							<h2 class="label">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"section.section"),$_smarty_tpl ) );?>

							</h2>
							<div class="value">
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['section']->value->getLocalizedTitle() ));?>

							</div>
						</section>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['categories']->value) {?>
						<section class="sub_item">
							<h2 class="label">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"category.category"),$_smarty_tpl ) );?>

							</h2>
							<div class="value">
								<ul class="categories">
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
?>
										<li><a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'page'=>"catalog",'op'=>"category",'path'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value->getPath() ))),$_smarty_tpl ) );?>
"><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value->getLocalizedTitle() ));?>
</a></li>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</ul>
							</div>
						</section>
					<?php }?>
				</div>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['currentJournal']->value) {?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pubIdPlugins']->value, 'pubIdPlugin');
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['pubIdPlugin']->value) {
$_smarty_tpl->tpl_vars['pubIdPlugin']->do_else = false;
?>
					<?php if ($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType() == 'doi') {?>
						<?php continue 1;?>
					<?php }?>
					<?php $_smarty_tpl->_assignInScope('pubId', $_smarty_tpl->tpl_vars['article']->value->getStoredPubId($_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType()));?>
					<?php if ($_smarty_tpl->tpl_vars['pubId']->value) {?>
						<?php $_smarty_tpl->_assignInScope('resolvedPubIdUrl', call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getResolvingURL($_smarty_tpl->tpl_vars['currentJournal']->value->getId(),$_smarty_tpl->tpl_vars['pubId']->value) )));?>
						<section class="item pubid">
							<h2 class="label">
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdDisplayType() ));?>

							</h2>
							<div class="value">
								<?php if ($_smarty_tpl->tpl_vars['resolvedPubIdUrl']->value) {?>
									<a id="pub-id::<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubIdPlugin']->value->getPubIdType() ));?>
" href="<?php echo $_smarty_tpl->tpl_vars['resolvedPubIdUrl']->value;?>
">
										<?php echo $_smarty_tpl->tpl_vars['resolvedPubIdUrl']->value;?>

									</a>
								<?php } else { ?>
									<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['pubId']->value ));?>

								<?php }?>
							</div>
						</section>
					<?php }?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<?php }?>

						<?php if ($_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('licenseTerms') || $_smarty_tpl->tpl_vars['publication']->value->getData('licenseUrl')) {?>
				<div class="item copyright">
					<h2 class="label">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.license"),$_smarty_tpl ) );?>

					</h2>
					<?php if ($_smarty_tpl->tpl_vars['publication']->value->getData('licenseUrl')) {?>
						<?php if ($_smarty_tpl->tpl_vars['ccLicenseBadge']->value) {?>
							<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder')) {?>
								<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.copyrightStatement",'copyrightHolder'=>$_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder'),'copyrightYear'=>$_smarty_tpl->tpl_vars['publication']->value->getData('copyrightYear')),$_smarty_tpl ) );?>
</p>
							<?php }?>
							<?php echo $_smarty_tpl->tpl_vars['ccLicenseBadge']->value;?>

						<?php } else { ?>
							<a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['publication']->value->getData('licenseUrl') ));?>
" class="copyright">
								<?php if ($_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder')) {?>
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.copyrightStatement",'copyrightHolder'=>$_smarty_tpl->tpl_vars['publication']->value->getLocalizedData('copyrightHolder'),'copyrightYear'=>$_smarty_tpl->tpl_vars['publication']->value->getData('copyrightYear')),$_smarty_tpl ) );?>

								<?php } else { ?>
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"submission.license"),$_smarty_tpl ) );?>

								<?php }?>
							</a>
						<?php }?>
					<?php }?>
					<?php echo $_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('licenseTerms');?>

				</div>
			<?php }?>

			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Article::Details"),$_smarty_tpl ) );?>


		</div><!-- .entry_details -->
	</div><!-- .row -->

</article>
<?php }
}
