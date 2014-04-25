{if $blocknewsfaq_shbl == "right"}

	<div class="block blockmanufacturer" id="manufacturers_block_left">
		<h4 align="center">
		<a href="{$base_dir}modules/blocknews/items.php">
			{l s='Last News' mod='blocknews'}
		</a>
		</h4>
		<div class="block_content block-items-data">
		{if count($blocknewsitemsblock) > 0}
	    <ul>
	    {foreach from=$blocknewsitemsblock item=items name=myLoop1}
	    	{foreach from=$items.data item=item name=myLoop}
	    	<li class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
	    	
		    	<table width="100%">
		    				<tr>
		    				{if strlen($item.img)>0}
		    					<td align="center">
		    						<a href="{$base_dir}modules/blocknews/item.php?item_id={$item.id}" 
		    		  				title="{$item.title}">
		    						<img src="{$base_dir}upload/blocknews/{$item.img}" title="{$item.title}" style="height:45px" />
		    						</a>
		    					</td>
		    				{/if}
		    					<td>
		    						<table width="100%">
		    							<tr>
		    								<td align="left">
		    									<a href="{$base_dir}modules/blocknews/item.php?item_id={$item.id}" 
			    		  						   title="{$item.title}"><b>{$item.title}</b></a>
		    								</td>
		    							</tr>
		    							<tr>
		    								<td align="left">{$item.time_add|date_format}</td>
		    							</tr>
		    						</table>
			    					
		    					</td>
		    				</tr>
		    		</table>
	    	</li>
	    		{/foreach}
	    	{/foreach}
	    </ul>
	    <p>
			<a class="button_large" title="{l s='View all news' mod='blocknews'}" 
			href="{$module_dir}items.php">{l s='View all news' mod='blocknews'}</a>
		</p>
	    
	    {else}
		<div style="padding:10px">
			{l s='News not found.' mod='blocknews'}
		</div>
		{/if}
		</div>
	</div>
{/if}