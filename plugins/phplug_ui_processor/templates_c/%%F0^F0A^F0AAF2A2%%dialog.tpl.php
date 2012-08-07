<?php /* Smarty version 2.6.22, created on 2012-08-07 01:25:59
         compiled from C:/xampp/htdocs/trapadoo/PHPlug/plugins/phplug_ui_widgets_jquery/templates/dialog/dialog.tpl */ ?>
<div class="Dialog" id="<?php echo $this->_tpl_vars['dialog']->getId(); ?>
" title="<?php echo $this->_tpl_vars['dialog']->getTitle(); ?>
">
	<?php $this->assign('content', $this->_tpl_vars['dialog']->getComposite()); ?>
	<?php echo $this->_tpl_vars['content']->draw(); ?>

</div>
<script type="text/javascript">
	$(document).ready(function()<?php echo '{'; ?>

			$("#<?php echo $this->_tpl_vars['dialog']->getId(); ?>
").dialog(<?php echo '{'; ?>

			autoOpen: false,
			width: "<?php echo $this->_tpl_vars['dialog']->getWidth(); ?>
",
			height: "<?php echo $this->_tpl_vars['dialog']->getHeight(); ?>
",
			modal: <?php echo $this->_tpl_vars['dialog']->isModal(); ?>
,
			buttons: <?php echo '{'; ?>

				"Ok": function() <?php echo '{'; ?>
 
					$(this).dialog("close"); 
				<?php echo '}'; ?>
, 
				"Cancel": function() <?php echo '{'; ?>
 
					$(this).dialog("close"); 
				<?php echo '}'; ?>
 
			<?php echo '}'; ?>

		<?php echo '}'; ?>
);
	<?php echo '}'; ?>
);
</script>