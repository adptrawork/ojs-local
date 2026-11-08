<?php
/* Smarty version 4.3.1, created on 2026-11-08 15:25:35
  from 'app:frontendobjectsannouncements_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6af0946f7fc131_85139289',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c0c5609a49a791a7db28b44f97e1567b1570aead' => 
    array (
      0 => 'app:frontendobjectsannouncements_list.tpl',
      1 => 1778098472,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6af0946f7fc131_85139289 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'D:\\Projects\\ojs-3.3.0-24\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.count.php','function'=>'smarty_modifier_count',),1=>array('file'=>'D:\\Projects\\ojs-3.3.0-24\\lib\\pkp\\lib\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>

<?php if ($_smarty_tpl->tpl_vars['numAnnouncements']->value && smarty_modifier_count($_smarty_tpl->tpl_vars['announcements']->value)) {?>
<section class="cmp_announcements highlight_first sanguline_announcement_slider">
	<a id="homepageAnnouncements"></a>
	
	<div class="slider_header">
		<h2 class="slider_title">
			<span class="fa fa-bullhorn" aria-hidden="true"></span>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"announcement.announcements"),$_smarty_tpl ) );?>

		</h2>
		<?php if (smarty_modifier_count($_smarty_tpl->tpl_vars['announcements']->value) > 1) {?>
		<div class="slider_controls">
			<button type="button" class="slider_prev" aria-label="Previous">
				<span class="fa fa-chevron-left" aria-hidden="true"></span>
			</button>
			<button type="button" class="slider_next" aria-label="Next">
				<span class="fa fa-chevron-right" aria-hidden="true"></span>
			</button>
		</div>
		<?php }?>
	</div>
	
	<div class="slider_container">
		<div class="slider_track">
			<?php $_smarty_tpl->_assignInScope('slideIndex', 0);?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['announcements']->value, 'announcement', false, NULL, 'announcements', array (
  'iteration' => true,
));
$_smarty_tpl->tpl_vars['announcement']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['announcement']->value) {
$_smarty_tpl->tpl_vars['announcement']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration']++;
?>
				<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_announcements']->value['iteration'] : null) > $_smarty_tpl->tpl_vars['numAnnouncements']->value) {?>
					<?php break 1;?>
				<?php }?>
				<div class="slider_slide<?php if ($_smarty_tpl->tpl_vars['slideIndex']->value == 0) {?> active<?php }?>" data-slide="<?php echo $_smarty_tpl->tpl_vars['slideIndex']->value;?>
">
					<article class="announcement_card">
						<?php $_smarty_tpl->_assignInScope('datePosted', $_smarty_tpl->tpl_vars['announcement']->value->getDatePosted());?>
						<div class="announcement_date">
							<span class="date_day"><?php echo smarty_modifier_date_format(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strtotime' ][ 0 ], array( $_smarty_tpl->tpl_vars['datePosted']->value )),"d");?>
</span>
							<span class="date_month"><?php echo smarty_modifier_date_format(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strtotime' ][ 0 ], array( $_smarty_tpl->tpl_vars['datePosted']->value )),"M");?>
</span>
							<span class="date_year"><?php echo smarty_modifier_date_format(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strtotime' ][ 0 ], array( $_smarty_tpl->tpl_vars['datePosted']->value )),"Y");?>
</span>
						</div>
						<div class="announcement_content">
							<h3 class="announcement_title">
								<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'page'=>"announcement",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['announcement']->value->getId()),$_smarty_tpl ) );?>
">
									<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['announcement']->value->getLocalizedTitle() ));?>

								</a>
							</h3>
							<div class="announcement_summary">
								<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'strip_unsafe_html' ][ 0 ], array( $_smarty_tpl->tpl_vars['announcement']->value->getLocalizedDescriptionShort() ));?>

							</div>
							<a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('router'=>(defined('ROUTE_PAGE') ? constant('ROUTE_PAGE') : null),'page'=>"announcement",'op'=>"view",'path'=>$_smarty_tpl->tpl_vars['announcement']->value->getId()),$_smarty_tpl ) );?>
" class="announcement_read_more">
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.readMore"),$_smarty_tpl ) );?>

								<span class="fa fa-arrow-right" aria-hidden="true"></span>
							</a>
						</div>
					</article>
				</div>
				<?php $_smarty_tpl->_assignInScope('slideIndex', $_smarty_tpl->tpl_vars['slideIndex']->value+1);?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</div>
	</div>
	
	<?php if (smarty_modifier_count($_smarty_tpl->tpl_vars['announcements']->value) > 1 && $_smarty_tpl->tpl_vars['numAnnouncements']->value > 1) {?>
	<div class="slider_dots">
		<?php $_smarty_tpl->_assignInScope('dotIndex', 0);?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['announcements']->value, 'announcement', false, NULL, 'dots', array (
  'iteration' => true,
));
$_smarty_tpl->tpl_vars['announcement']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['announcement']->value) {
$_smarty_tpl->tpl_vars['announcement']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_dots']->value['iteration']++;
?>
			<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_dots']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_dots']->value['iteration'] : null) > $_smarty_tpl->tpl_vars['numAnnouncements']->value) {?>
				<?php break 1;?>
			<?php }?>
			<button type="button" class="slider_dot<?php if ($_smarty_tpl->tpl_vars['dotIndex']->value == 0) {?> active<?php }?>" data-slide="<?php echo $_smarty_tpl->tpl_vars['dotIndex']->value;?>
" aria-label="Go to slide <?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_dots']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_dots']->value['iteration'] : null);?>
"></button>
			<?php $_smarty_tpl->_assignInScope('dotIndex', $_smarty_tpl->tpl_vars['dotIndex']->value+1);?>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</div>
	<?php }?>
</section>
<?php }
}
}
