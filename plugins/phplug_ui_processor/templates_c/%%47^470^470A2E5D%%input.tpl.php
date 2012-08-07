<?php /* Smarty version 2.6.22, created on 2012-08-07 01:25:59
         compiled from C:/xampp/htdocs/trapadoo/PHPlug/plugins/phplug_ui_widgets_jquery/templates/form/controls/input.tpl */ ?>
<input type="<?php echo $this->_tpl_vars['type']; ?>
" value="<?php echo $this->_tpl_vars['value']; ?>
" name="<?php echo $this->_tpl_vars['name']; ?>
" id="<?php echo $this->_tpl_vars['id']; ?>
" />
<script type="text/javascript">
	$(document).ready(function()<?php echo '{'; ?>

		<?php if ($this->_tpl_vars['type'] == 'submit'): ?>
			$("#<?php echo $this->_tpl_vars['id']; ?>
").button();
		<?php endif; ?>
		<?php $_from = $this->_tpl_vars['events']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['event']):
?>
			<?php $_from = $this->_tpl_vars['event']->getActions(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['action']):
?>
				$("#<?php echo $this->_tpl_vars['id']; ?>
").bind(<?php echo '{'; ?>

					"click": function()<?php echo '{'; ?>

							<?php echo $this->_tpl_vars['action']->getJS(); ?>

						<?php echo '}'; ?>

				<?php echo '}'; ?>
);
			<?php endforeach; endif; unset($_from); ?>
		<?php endforeach; endif; unset($_from); ?>
	<?php echo '}'; ?>
);
</script>