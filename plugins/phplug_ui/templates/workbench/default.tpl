<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>{$applicationTitle}</title>
		<style type="text/css">
			div {literal}{{/literal}
				display:block;
			{literal}}{/literal}
		</style>
		{foreach from=$scripts item=script}
			<script type="text/javascript" src="{$script}"></script>
		{/foreach}
		{foreach from=$styles item=style}
			<link rel="stylesheet" type="text/css" href="{$style}" />
		{/foreach}
	</head>
	<body>
		<div id="banner">
			<img src="{$banner}" alt="banner" />
		</div>
		<div id="Workbench">
			{$Workbench}
		</div>
	</body>
</html>