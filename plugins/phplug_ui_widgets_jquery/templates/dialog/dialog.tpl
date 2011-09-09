<div class="Dialog" id="{$dialog->getId()}" title="{$dialog->getTitle()}">
	{assign var=content value=$dialog->getComposite()}
	{$content->draw()}
</div>
<script type="text/javascript">
	$(document).ready(function(){literal}{{/literal}
			$("#{$dialog->getId()}").dialog({literal}{{/literal}
			autoOpen: false,
			width: "{$dialog->getWidth()}",
			height: "{$dialog->getHeight()}",
			modal: {$dialog->isModal()},
			buttons: {literal}{{/literal}
				"Ok": function() {literal}{{/literal} 
					$(this).dialog("close"); 
				{literal}}{/literal}, 
				"Cancel": function() {literal}{{/literal} 
					$(this).dialog("close"); 
				{literal}}{/literal} 
			{literal}}{/literal}
		{literal}}{/literal});
	{literal}}{/literal});
</script>