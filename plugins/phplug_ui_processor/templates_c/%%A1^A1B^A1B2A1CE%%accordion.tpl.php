<?php /* Smarty version 2.6.22, created on 2011-08-31 15:12:46
         compiled from C:/xampp/htdocs/PHPlug/plugins/phplug_ui_widgets_jquery/templates/form/controls/accordion.tpl */ ?>
<div id="accordion">
	<div>
		<h3><a href="#">First</a></h3>
		<div>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</div>
	</div>
	<div>
		<h3><a href="#">Second</a></h3>
		<div>Phasellus mattis tincidunt nibh.</div>
	</div>
	<div>

		<h3><a href="#">Third</a></h3>
		<div>Nam dui erat, auctor a, dignissim quis.</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(
			function() <?php echo '{'; ?>

				$("#accordion").accordion(<?php echo '{'; ?>
 header: "h3" <?php echo '}'; ?>
);
				<?php echo '}'; ?>

	);
</script>