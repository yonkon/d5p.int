	<script type="text/javascript" src="/js/highslide/highslide-full.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/highslide/highslide.css" />
	{literal}
	<script type="text/javascript">
		hs.graphicsDir = '/js/highslide/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		hs.fadeInOut = true;
		//hs.dimmingOpacity = 0.75;
		// Add the controlbar
		hs.addSlideshow({
			//slideshowGroup: 'group1',
			interval: 2000,
			repeat: false,
			useControls: true,
			fixedControls: 'fit',
			overlayOptions: {
				opacity: .75,
				position: 'bottom center',
				hideOnMouseOut: true
			}
		});
	</script>
    {/literal}
