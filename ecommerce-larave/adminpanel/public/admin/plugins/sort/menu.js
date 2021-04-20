jQuery(function($) {

	/* highlight current menu group
	------------------------------------------------------------------------- */
	$('#menu-group li[id="group-' + current_group_id + '"]').addClass('current');

	/* global ajax setup
	------------------------------------------------------------------------- */
	$.ajaxSetup({
		type: 'GET',
		datatype: 'json',
		timeout: 20000
	});
	$(document).ajaxStart(function() {
		$('#loading').show();
	});
	$(document).ajaxStop(function() {
		$('#loading').hide();
	});

	/* modal box
	------------------------------------------------------------------------- */
	gbox = {
		defaults: {
			autohide: false,
			buttons: {
				'Close': function() {
					gbox.hide();
				}
			}
		},
		init: function() {
			var winHeight = $(window).height();
			var winWidth = $(window).width();
			var box =
				'<div id="gbox">' +
					'<div id="gbox_content"></div>' +
				'</div>' +
				'<div id="gbox_bg"></div>';

			$('body').append(box);

			$('#gbox').css({
				top: '15%',
				left: winWidth / 2 - $('#gbox').width() / 2
			});

			$('#gbox_close, #gbox_bg').click(gbox.hide);
		},
		show: function(options) {
			var options = $.extend({}, this.defaults, options);
			var options_temp = this.defaults;
			switch (options.type) {
				case 'ajax':
					options_temp.content = '<div id="gbox_loading">Loading...<div>';
					gbox._show(options_temp);
					$.ajax({
						type: 'GET',
						global: false,
						datatype: 'html',
						url: options.url,
						success: function(data) {
							options.content = data;
							gbox._show(options);
						}
					});
					break;
				default:
					this._show(options);
					break;
			}
		},
		_show: function(options) {
			$('#gbox_footer').remove();
			if (options.buttons) {
				$('#gbox').append('<div id="gbox_footer"></div>');
				$.each(options.buttons, function(k, v) {
					buttonclass = '';
					if (k == 'Save' || k == 'Yes' || k == 'OK') {
						buttonclass = 'primary';
					}
					$('<button></button>').addClass(buttonclass).text(k).click(v).appendTo('#gbox_footer');
				});
			}

			$('#gbox, #gbox_bg').fadeIn();
			$('#gbox_content').html(options.content);
			$('#gbox_content input:first').focus();
			if (options.autohide) {
				setTimeout(function() {
					gbox.hide();
				}, options.autohide);
			}
		},
		hide: function() {
			$('#gbox').fadeOut(function() {
				$('#gbox_content').html('');
				$('#gbox_footer').remove();
			});
			$('#gbox_bg').fadeOut();
		}
	};
	gbox.init();

	/* same as site_url() in php
	------------------------------------------------------------------------- */
	function site_url(url) {
		return _BASE_URL + 'index.php?act=' + url;
	}

	/* nested sortables
	------------------------------------------------------------------------- */
	var menu_serialized;
	$('#easymm').nestedSortable({
		listType: 'ul',
		handle: 'div',
		items: 'li',
		placeholder: 'ns-helper',
		opacity: .8,
		handle: '.ns-title',
		toleranceElement: '> div',
		forcePlaceholderSize: true,
		tabSize: 15,
		update: function() {
			menu_serialized = $('#easymm').nestedSortable('serialize');
			$('#btn-save-menu').attr('disabled', false);
			}
	});

	/* add menu item
	------------------------------------------------------------------------- */
	// $('#form-add-menu').submit(function() {
	// 	if ($('#menu-title').val() == '') {
	// 		$('#menu-title').focus();
	// 	} else {
	// 		$.ajax({
	// 			type: 'POST',
	// 			url: $(this).attr('action'),
	// 			data: $(this).serialize(),
	// 			error: function() {
	// 				gbox.show({
	// 					content: 'Add menu item error. Please try again.',
	// 					autohide: 1000
	// 				});
	// 			},
	// 			success: function(data) {
	// 				switch (data.status) {
	// 					case 1:
	// 						$('#form-add-menu')[0].reset();
	// 						$('#easymm')
	// 							.append(data.li);
	// 						break;
	// 					case 2:
	// 						gbox.show({
	// 							content: data.msg,
	// 							autohide: 1000
	// 						});
	// 						break;
	// 					case 3:
	// 						$('#menu-title').val('').focus();
	// 						break;
	// 				}
	// 			}
	// 		});
	// 	}
	// 	return false;
	// });

	// $('body').on('keydown', '#gbox input', function(e) {
	// 	if (e.which == 13) {
	// 		$('#gbox_footer .primary').trigger('click');
	// 		return false;
	// 	}
	// });

	/* add group
	------------------------------------------------------------------------- */
	// $('#add-group a').click(function() {
	// 	gbox.show({
	// 		type: 'ajax',
	// 		url: $(this).attr('href'),
	// 		buttons: {
	// 			'Save': function() {
	// 				var group_title = $('#menu-group-title').val();
	// 				if (group_title == '') {
	// 					$('#menu-group-title').focus();
	// 				} else {
	// 					//$('#gbox_ok').attr('disabled', true);
	// 					$.ajax({
	// 						type: 'POST',
	// 						url: site_url('menu_group.add'),
	// 						data: 'title=' + group_title,
	// 						error: function() {
	// 							//$('#gbox_ok').attr('disabled', false);
	// 						},
	// 						success: function(data) {
	// 							//$('#gbox_ok').attr('disabled', false);
	// 							switch (data.status) {
	// 								case 1:
	// 									gbox.hide();
	// 									$('#menu-group').append('<li><a href="' + site_url('menu&group_id=' + data.id) + '">' + group_title + '</a></li>');
	// 									break;
	// 								case 2:
	// 									$('<span class="error"></span>')
	// 										.text(data.msg)
	// 										.prependTo('#gbox_footer')
	// 										.delay(1000)
	// 										.fadeOut(500, function() {
	// 											$(this).remove();
	// 										});
	// 									break;
	// 								case 3:
	// 									$('#menu-group-title').val('').focus();
	// 									break;
	// 							}
	// 						}
	// 					});
	// 				}
	// 			},
	// 			'Cancel': gbox.hide
	// 		}
	// 	});
	// 	return false;
	// });

	/* update menu / save order
	------------------------------------------------------------------------- */
	$('#btn-save-menu').attr('disabled', true);
	$('#form-menu').submit(function() {
		$('#sorted').hide();
		$('#btn-save-menu').attr('disabled', true);

		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: menu_serialized,
			error: function() {
				$('#btn-save-menu').attr('disabled', false);
				gbox.show({
					content: '<h2>Error</h2>Save menu error. Please try again.',
					autohide: 1000
				});
			},
			success: function(data) {
				$('#sorted').show();
				setTimeout(() => {
					$('#sorted').hide();
				}, 2000);
				gbox.show({
					content: '<h2>Success</h2>Menu has been saved',
					autohide: 1000
				});
			}
		});
		return false;
	});




});