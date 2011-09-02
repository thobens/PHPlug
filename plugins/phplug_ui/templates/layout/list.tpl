<ul>
	{foreach from=$composites item=composite}
	<li style="height:{$composite.height};width:{$composite.width};">
	{$composite.content}
	</li>
	{/foreach}
</ul>