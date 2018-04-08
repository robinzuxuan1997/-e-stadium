<div id="dash_pbp_ascdesc">
<table width="1000">
<tr>
<td>
	<table align="center">
	<tr>
	<td width="150">
	<input type="radio" name="ascdesc" value="Ascending" onClick="setAsc();" /> Oldest Play First
	</td>
	<td width="150">
	<input type="radio" name="ascdesc" value="Descending" onClick="setDesc();"  checked /> Newest Play First
	</td>
	</tr>
	</table>
</td>
</tr>
</table>
<script type="text/javascript">

var ascdesc = 1;

function setAsc()
{
	if (ascdesc != 0)
	{
		ascdesc = 0;
		console.log("ascdesc set to 0");
		swReset('beg2');swStart('beg2','+');doPageUpdate();
	}
}

function setDesc()
{
	if (ascdesc != 1)
	{
		ascdesc = 1;
		console.log("ascdesc set to 1");
		swReset('beg2');swStart('beg2','+');doPageUpdate();
	}
}

</script>
</div>
<div id="dash_playbyplay"></div>
