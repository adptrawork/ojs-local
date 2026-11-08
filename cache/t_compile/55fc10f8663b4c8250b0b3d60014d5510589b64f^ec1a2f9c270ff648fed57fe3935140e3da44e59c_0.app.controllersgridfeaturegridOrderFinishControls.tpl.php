<?php
/* Smarty version 4.3.1, created on 2026-11-08 15:23:20
  from 'app:controllersgridfeaturegridOrderFinishControls.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6af093e8da5af5_79726657',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ec1a2f9c270ff648fed57fe3935140e3da44e59c' => 
    array (
      0 => 'app:controllersgridfeaturegridOrderFinishControls.tpl',
      1 => 1793493770,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6af093e8da5af5_79726657 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="grid_controls order_finish_controls">
	<a href="#" id="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'concat' ][ 0 ], array( $_smarty_tpl->tpl_vars['gridId']->value ));?>
-saveButton" class="saveButton">
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"common.done"),$_smarty_tpl ) );?>

	</a>
	<a href="#" id="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'concat' ][ 0 ], array( $_smarty_tpl->tpl_vars['gridId']->value ));?>
-cancel" class="cancelFormButton">
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"grid.action.cancelOrdering"),$_smarty_tpl ) );?>

	</a>
</div>
<?php }
}
