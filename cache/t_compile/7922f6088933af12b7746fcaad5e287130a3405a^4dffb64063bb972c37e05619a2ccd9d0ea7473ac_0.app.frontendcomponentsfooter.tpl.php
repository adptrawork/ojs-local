<?php
/* Smarty version 4.3.1, created on 2026-11-08 14:08:20
  from 'app:frontendcomponentsfooter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.1',
  'unifunc' => 'content_6af08254b69486_49492177',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4dffb64063bb972c37e05619a2ccd9d0ea7473ac' => 
    array (
      0 => 'app:frontendcomponentsfooter.tpl',
      1 => 1778098472,
      2 => 'app',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6af08254b69486_49492177 (Smarty_Internal_Template $_smarty_tpl) {
?>
	</div><!-- pkp_structure_main -->

		<?php if (empty($_smarty_tpl->tpl_vars['isFullWidth']->value)) {?>
		<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "sidebarCode", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Common::Sidebar"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
		<?php if ($_smarty_tpl->tpl_vars['sidebarCode']->value) {?>
			<div class="pkp_structure_sidebar left" role="complementary">
								<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "sidebarMenu", null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['load_menu'][0], array( array('name'=>"sidebar",'id'=>"navigationSidebar",'ulClass'=>"pkp_nav_list"),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
				<?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'trim' ][ 0 ], array( $_smarty_tpl->tpl_vars['sidebarMenu']->value )) != '') {?>
					<div class="pkp_block block_sidebar_nav">
						<h3 class="pkp_block_title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"plugins.themes.sanguline.sidebar.additionalMenu"),$_smarty_tpl ) );?>
</h3>
						<?php echo $_smarty_tpl->tpl_vars['sidebarMenu']->value;?>

					</div>
				<?php }?>
				<?php echo $_smarty_tpl->tpl_vars['sidebarCode']->value;?>

			</div><!-- pkp_sidebar.left -->
		<?php }?>
	<?php }?>
</div><!-- pkp_structure_content -->

<div class="pkp_structure_footer_wrapper" role="contentinfo">
	<a id="pkp_content_footer"></a>

	<div class="pkp_structure_footer">

		<?php if ($_smarty_tpl->tpl_vars['pageFooter']->value) {?>
			<div class="pkp_footer_content">
				<?php echo $_smarty_tpl->tpl_vars['pageFooter']->value;?>

			</div>
		<?php }?>

				<div class="sanguline_theme_credit" data-sanguline="protected" style="text-align:center;padding:1rem;font-size:0.85rem;opacity:0.9;">
			<span class="theme_credit_text">Sanguline Theme by</span>
			<a href="https://sanguilmu.com/" target="_blank" rel="noopener" class="theme_credit_link" style="color:inherit;text-decoration:underline;">Sangu Ilmu</a>
		</div>
	</div>
</div><!-- pkp_structure_footer_wrapper -->

</div><!-- pkp_structure_page -->

<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['load_script'][0], array( array('context'=>"frontend"),$_smarty_tpl ) );?>


<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['call_hook'][0], array( array('name'=>"Templates::Common::Footer::PageFooter"),$_smarty_tpl ) );?>

</body>
</html>
<?php }
}
