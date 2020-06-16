$(document)
		.ready(
				function() {
					var uid = $('#5879bc7147722').attr('uid');
					var poster = $('#5879bc7147722').attr('poster');
					var title = $('#5879bc7147722').attr('title');
					projekktor(
							'#5879bc7147722',
							{
								poster : poster,
								title : title,
								playerFlashMP4 : 'assets/projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf',
								playerFlashMP3 : 'assets/projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf',
								width : 750,
								height : 422,
								autoplay: false,
								playlist : [ {
									0 : {
										src : "stream/" + uid,
										type : "video/mp4"
									}
								} ]
							}, function(player) {
							});

				});
