(function ($) {
	$('div.field-pinnable div.map')
		.live('initialize', function() {
			var $map = $(this);
			var $pin = $('<div />')
				.addClass('pin')
				.hide();
			
			$pin.appendTo($map);
		})
		
		.live('change', function() {
			var $map = $(this);
			var $pin = $('div.pin', this);
			var position_x = $map.attr('data-position-x');
			var position_y = $map.attr('data-position-y');
			
			if (!position_x || !position_y) return;
			
			$pin.show()
				.css({
					'top': position_y + '%',
					'left': position_x + '%'
				});
		})
		
		.live('finalize', function() {
			var $map = $(this);
			
			$('input:first', this)
				.val($map.attr('data-position-x'));
			$('input:last', this)
				.val($map.attr('data-position-y'));
		})
		
		.live('click', function(event) {
			var $map = $(this);
			
			$map.attr({
					'data-position-x':	event.layerX / $map.width() * 100,
					'data-position-y':	event.layerY / $map.height() * 100
				})
				.trigger('change');
		});
	
	$(document)
		.bind('ready', function() {
			$('div.field-pinnable div.map')
				.trigger('initialize')
				.trigger('change');
		})
		
		.bind('submit', function() {
			$('div.field-pinnable div.map')
				.trigger('finalize');
		});
})(jQuery);