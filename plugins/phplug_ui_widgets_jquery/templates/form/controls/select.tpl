<select name="{$name}">
{foreach from=$options item=option}
	{if $value == $option->value}
		<option value="{$option->value}" selected="selected">{$option->name}</option>
	{else}
		<option value="{$option->value}">{$option->name}</option>
	{/if}
{/foreach}
</select>