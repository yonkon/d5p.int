$(document).ready(function() {
	$('.enter_block_call').click(function(e) {

		if ($('.enter_block').css('display') != 'block') {
			$('.enter_block').fadeIn('slow');

			var yourClick = true;

	        $(document).bind('click.myEvent', function (e) {

	          if (!yourClick && $(e.target).closest('.enter_block').length == 0) {
	          // if ( $(e.target).closest('.enter_block').length == 0) {
	            $('.enter_block').fadeOut('fast');
	            $(document).unbind('click.myEvent');
	          }
	          yourClick = false;
	        });
			
		}


		e.preventDefault();
	});
	$(document).not('.enter_block_call').click(function() {
		$('.enter_block').fadeOut('fast');
	});

		$(document).ready(function() {
			
			$("#slides").slidesjs({
				width:546,
				height:196,
				navigation: {
						active: false,
						effect: "fade"
					},
				pagination: {
						active: true,
						effect: "fade"
					},
				effect: {
				  
				  fade: {
					speed: 600,
					crossfade: true
				  }
				},
				  play:{
				  	active: false,
				  	effect: "fade",
				  	interval: 3000,

				  	auto: true,
				  	swap: false
				  
				  }
			});
		});
		
});
