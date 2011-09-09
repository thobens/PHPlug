<?php /* Smarty version 2.6.22, created on 2011-09-02 14:26:44
         compiled from C:/xampp/htdocs/PHPlug/plugins/phplug_ui/templates/layout/list.tpl */ ?>
<ul>
	<?php $_from = $this->_tpl_vars['composites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['composite']):
?>
	<li style="height:<?php echo $this->_tpl_vars['composite']['height']; ?>
;width:<?php echo $this->_tpl_vars['composite']['width']; ?>
;">
	<?php echo $this->_tpl_vars['composite']['content']; ?>

	</li>
	<?php endforeach; endif; unset($_from); ?>
</ul>