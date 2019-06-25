jQuery(function($) {
	
   $(function() {
		$('#nav li a').click(function(event) {
			alert('We are here');
			var $anchor = $(this);
			$('#nav li').removeClass("current");
			$anchor.parents('li').addClass("current");
			/* event.preventDefault(); */
			alert('We are done here');
			
			});
		}); 
	
});