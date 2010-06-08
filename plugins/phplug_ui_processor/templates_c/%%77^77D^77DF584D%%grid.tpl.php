<?php /* Smarty version 2.6.22, created on 2010-06-08 21:11:31
         compiled from /media/Files/projects/php/ch.thobens.phplug/phplug/plugins/phplug_ui/templates/layout/grid.tpl */ ?>
<table style="width:100%;">
	<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
		<tr>
			<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['col']):
?>
				<td colspan="<?php echo $this->_tpl_vars['col']['width']; ?>
" rowspan="<?php echo $this->_tpl_vars['col']['height']; ?>
">
					<?php echo $this->_tpl_vars['col']['content']; ?>

				</td>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>