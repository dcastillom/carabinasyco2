
{capture name=path}
{$meta_title}
{/capture}

{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{$meta_title}</h2>


<div style="margin-top:10px;border:1px solid #CCCCCC;padding:5px">
{if $count_all > 0}

<div class="toolbar-top">
			
	<div class="sortTools" id="show" style="margin-bottom: 10px;">
		<ul class="actions">
			<li class="frst">
					<strong>{l s='Items' mod='blocknews'}  ( <span id="count_items_top" style="color: #333;">{$count_all}</span> )</strong>
			</li>
		</ul>
	</div>

</div>


<div id="list_reviews" class="productsBox1">
{foreach from=$posts item=post name=myLoop}
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="productsTable compareTableNew">
		<tbody>
			<tr class="line1">
			<td class="info">
			
			<table width="100%">
				<tr>
				{if strlen($post.img)>0}
					<td style="background:none;border-bottom:none">
						<a href="{$base_dir}modules/blocknews/item.php?item_id={$post.id}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
							<img src="{$base_dir}upload/blocknews/{$post.img}" title="{$post.title|escape:'htmlall':'UTF-8'}" 
							    style="width:100px"/>
						</a>
					</td>
				{/if}
					<td style="background:none;border-bottom:none;{if strlen($post.img)==0} width:100%{else} width:80%{/if}">
						<h3>
								<a href="{$base_dir}modules/blocknews/item.php?item_id={$post.id}" 
								   title="{$post.title|escape:'htmlall':'UTF-8'}"
								  >
									{$post.title|escape:'htmlall':'UTF-8'}
								</a>
							</h3>
					</td>
				</tr>
			</table>
			
			<p class="commentbody_center">
				{$post.content|substr:0:140}
				{if strlen($post.content)>140}...{/if}
				<a href="{$base_dir}modules/blocknews/item.php?item_id={$post.id}" 
					   title="{$post.title|escape:'htmlall':'UTF-8'}">
						{l s='more' mod='blocknews'}
				</a>
				
				<br><br>
				
				<span class="foot_center">{$post.time_add}</span>
				<br>
				</p>
			</td>
			</tr>
		</tbody>
	</table>
{/foreach}
</div>


<div class="toolbar-bottom">
			
	<div class="sortTools" id="show">
		
		<ul style="margin-left: 38%;">
			<li style="border: medium none; padding: 0pt;">	
			
			<table class="toolbar">
			<tbody>
			<tr class="pager">
				<td id="page_nav" class="pages">
					{$paging}
				</td>
			</tr>
			</tbody>
	</table>
</li>
		</ul>
		
			</div>

		</div>
{else}
	<div style="padding:10px;text-align:center;font-weight:bold">
	{l s='There are not news yet' mod='blocknews'}
	</div>
{/if}

</div>
