<?php /* Smarty version 2.6.22, created on 2012-08-07 01:25:59
         compiled from C:/xampp/htdocs/trapadoo/PHPlug/plugins/phplug_ui/templates/workbench/default.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $this->_tpl_vars['applicationTitle']; ?>
</title>
		<style type="text/css">
			div <?php echo '{'; ?>

				display:block;
			<?php echo '}'; ?>

		</style>
		<?php $_from = $this->_tpl_vars['scripts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['script']):
?>
			<script type="text/javascript" src="<?php echo $this->_tpl_vars['script']; ?>
"></script>
		<?php endforeach; endif; unset($_from); ?>
		<?php $_from = $this->_tpl_vars['styles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['style']):
?>
			<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['style']; ?>
" />
		<?php endforeach; endif; unset($_from); ?>
	</head>
	<body>
		<div id="banner">
			<img src="<?php echo $this->_tpl_vars['banner']; ?>
" alt="banner" />
		</div>
		<div id="Workbench">
			<?php echo $this->_tpl_vars['Workbench']; ?>

		</div>
	</body>
</html>