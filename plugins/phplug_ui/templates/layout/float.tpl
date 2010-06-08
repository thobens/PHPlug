{foreach from=$composites item=composite}
<div style="height:{$composite.height};width:{$composite.width};float:left;">
{$composite.content}
</div>
{/foreach}