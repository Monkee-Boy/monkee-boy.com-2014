{include file="inc_header.tpl" page_title="Links" menu="links"}
{head}
<script language="JavaScript" type="text/javascript" src="/scripts/jquery/jTPS/jTPS.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/jquery/jTPS/jTPS.css">
<script type="text/javascript">
	$(function(){ldelim}
		$('.dataTable').jTPS({ldelim}
			perPages:[10,15,20],
			scrollStep: 1
		{rdelim});
	{rdelim});
</script>
{/head}
<div class="clear"></div>
<table class="dataTable">
	<thead>
		<tr>
			<th sort="title">Name</th>
			<th>Link</th>
			<th sort="active">Active</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$aLinks item=aLink}
			<tr>
				<td>{$aLink.name}</td>
				<td class="small center"><a href="{$aLink.link}" title="{$aLink.link}" target="_blank"><img src="/images/admin/icons/link.png"></a></td>
				<td class="small center">
					{if $aLink.active == 1}
						<span class="helpTip" title="Active"><img src="/images/admin/icons/accept.png"></span>
					{else}
						<span class="helpTip" title="In-Active"><img src="/images/admin/icons/cancel.png"></span>
					{/if}
				</td>
				<td class="small center border-end">
					<a href="/admin/links/edit/{$aLink.id}/" title="Edit Link">
						<img src="/images/admin/icons/pencil.png">
					</a>
					<a href="/admin/links/delete/{$aLink.id}/"
					 onclick="return confirm_('Are you aLink you would like to delete this link?');"
					 title="Delete Link">
						<img src="/images/admin/icons/bin_closed.png">
					</a>
				</td>
			</tr>
		{/foreach}
	</tbody>
	<tfoot class="nav">
		<tr>
			<td colspan="5">
				<div class="pagination"></div>
				<div class="paginationTitle">Page</div>
				<div class="selectPerPage"></div>
				<div class="status"></div>
			</td>
		</tr>
	</tfoot>
</table>
{include file="inc_footer.tpl"}