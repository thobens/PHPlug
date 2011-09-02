<div id="{$id}">
	{foreach from=$sections item=section}
	<div>
		<h3><a href="#">{$section->getTitle()}</a></h3>
		<div>{$section->getContent()}</div>
	</div>
	{/foreach}
</div>
<script type="text/javascript">
	$(document).ready(
			function() {literal}{{/literal}
				$("#{$id}").accordion({literal}{{/literal} header: "h3" {literal}}{/literal});
				{literal}}{/literal}
	);
</script>