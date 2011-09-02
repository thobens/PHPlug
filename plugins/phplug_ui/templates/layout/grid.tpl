<table style="width:100%;">
	{foreach from=$rows item=row}
		<tr>
			{foreach from=$row item=col}
				<td colspan="{$col.width}" rowspan="{$col.height}">
					{$col.content}
				</td>
			{/foreach}
		</tr>
	{/foreach}
</table>