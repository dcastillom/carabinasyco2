function go_page_news(page,item_id){
	
	$('#list_reviews').css('opacity',0.5);
	$.post(baseDir + 'modules/blocknews/ajax.php', {
		action:'pagenav',
		page : page,
		item_id : item_id
	}, 
	function (data) {
		if (data.status == 'success') {
		
		$('#list_reviews').css('opacity',1);
		
		$('#list_reviews').html('');
		$('#list_reviews').prepend(data.params.content);
		
		$('#page_nav').html('');
		$('#page_nav').prepend(data.params.page_nav);
		
		
		
	    } else {
			$('#list_reviews').css('opacity',1);
			alert(data.message);
		}
		
	}, 'json');

}