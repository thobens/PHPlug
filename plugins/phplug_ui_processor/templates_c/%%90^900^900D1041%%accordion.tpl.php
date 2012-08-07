<?php /* Smarty version 2.6.22, created on 2012-08-07 01:25:59
         compiled from C:/xampp/htdocs/trapadoo/PHPlug/plugins/phplug_ui_widgets_jquery/templates/accordion.tpl */ ?>
<div id="<?php echo $this->_tpl_vars['id']; ?>
">
	<?php $_from = $this->_tpl_vars['sections']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['section']):
?>
	<div>
		<h3><a href="#"><?php echo $this->_tpl_vars['section']->getTitle(); ?>
</a></h3>
		<div><?php echo $this->_tpl_vars['section']->getContent(); ?>
</div>
	</div>
	<?php endforeach; endif; unset($_from); ?>
</div>
<script type="text/javascript">
	$(document).ready(
			function() <?php echo '{'; ?>

				$("#<?php echo $this->_tpl_vars['id']; ?>
").accordion(<?php echo '{'; ?>
 header: "h3" <?php echo '}'; ?>
);
				<?php echo '}'; ?>

	);
</script>