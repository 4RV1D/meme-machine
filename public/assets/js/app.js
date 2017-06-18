$(document).ready(function() {
	var win = $(window);

	// Each time the user scrolls
	win.scroll(function() {
		// End of the document reached?
		if ($(document).height() - win.height() == win.scrollTop()) {
			$('#loading').show();

			$.ajax({
				url: 'http://localhost/meme-machine/api/123',
				dataType: 'json',
				success: function(json) {
					$('#posts').append(json);
					$('#loading').hide();
				}
			});
		}
	});
});
