<?php /* Smarty version 2.6.22, created on 2010-06-09 01:07:12
         compiled from /media/Files/projects/php/ch.thobens.phplug/PHPlug/plugins/phplug_ui_widgets/templates/form/controls/select.tpl */ ?>
<select name="<?php echo $this->_tpl_vars['name']; ?>
">
<?php $_from = $this->_tpl_vars['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['option']):
?>
	<?php if ($this->_tpl_vars['value'] == $this->_tpl_vars['option']->value): ?>
		<option value="<?php echo $this->_tpl_vars['option']->value; ?>
" selected="selected"><?php echo $this->_tpl_vars['option']->name; ?>
</option>
	<?php else: ?>
		<option value="<?php echo $this->_tpl_vars['option']->value; ?>
"><?php echo $this->_tpl_vars['option']->name; ?>
</option>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</select>