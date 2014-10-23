$(function() {
	var 
		$slideshow = $('#slideshow'),
		$caption = $('div.caption'),
		STOP = 1, RUN = 2, PAUSE = 3;

	$slideshow.crossSlide({
		fade: 1
	}, [
		{
			src:  'http://localhost/mk/sand-castle.jpeg',
			alt:  'Sand Castle',
			from: '100% 80% 1x',
			to:   '100% 0% 1.5x',
			time: 3
		}, {
			src:  'http://localhost/mk/sunflower.jpeg',
			alt:  'Sunflower',
			from: 'top left',
			to:   'bottom right 1.2x',
			time: 2
		}, {
			src:  'http://localhost/mk/flip-flops.jpeg',
			alt:  'Flip Flops',
			from: '100% 80% 1.3x',
			to:   '80% 8% 1x',
			time: 2
		}, {
			src:  'http://localhost/mk/rubber-ring.jpeg',
			alt:  'Rubber Ring',
			from: '100% 50%',
			to:   '30% 50% 1.2x',
			time: 2
		}
	], function(idx, img, idxOut, imgOut) {
		if (idxOut == undefined) {
			$caption.text(img.alt).animate({ opacity: .7 })
		} else {
			$caption.animate({ opacity: 0 })
		}
	});
	$caption.show().css({ opacity: 0 })

	function state(state) {
		$pause.attr('disabled', state != RUN);
		$resume.attr('disabled', state != PAUSE);
		$freeze.attr('disabled', state == STOP);
		$stop.attr('disabled', state == STOP);
	}
	state(RUN);
	
});
