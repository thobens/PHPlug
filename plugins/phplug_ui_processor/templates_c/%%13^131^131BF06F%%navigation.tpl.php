<?php /* Smarty version 2.6.22, created on 2012-08-07 02:15:33
         compiled from C:/xampp/htdocs/trapadoo/PHPlug/plugins/trapadoo_page/resources/templates/navigation.tpl */ ?>
<ul class="list-floated list-navi">
	<?php $_from = $this->_tpl_vars['entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
		<?php if ($this->_tpl_vars['entry']['perspective'] == $this->_tpl_vars['active']): ?>
			<li><a class="current" href="index.php?perspective=<?php echo $this->_tpl_vars['entry']['perspective']; ?>
"><?php echo $this->_tpl_vars['entry']['title']; ?>
</a></li>
		<?php else: ?>
			<li><a  href="index.php?perspective=<?php echo $this->_tpl_vars['entry']['perspective']; ?>
"><?php echo $this->_tpl_vars['entry']['title']; ?>
</a></li>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
</ul>