<input type="{$type}" value="{$value}" name="{$name}" id="{$id}" />
<script type="text/javascript">
	$(document).ready(function(){literal}{{/literal}
		{if $type eq 'submit'}
			$("#{$id}").button();
		{/if}
		{foreach from=$events item=event}
			{foreach from=$event->getActions() item=action}
				$("#{$id}").bind({literal}{{/literal}
					"click": function(){literal}{{/literal}
							{$action->getJS()}
						{literal}}{/literal}
				{literal}}{/literal});
			{/foreach}
		{/foreach}
	{literal}}{/literal});
</script>