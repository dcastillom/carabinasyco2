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