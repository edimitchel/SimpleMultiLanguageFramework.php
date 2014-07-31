;
(function() {
	var root_path = getRootPath();
	$('nav a, #logo a').click(function(evt) {
		var url = $(this).attr('href');
		url = getRootPath()+url.substring(url.indexOf('/')+1,url.length);
		var el = $(this);
		(function() {
			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'json',
				data: {
					langOri: $('html').attr('usr-lang'),
					ajax: true
				}
			})
				.done(function(data) {
					if (el.parent('#logo').length == 1)
						data.home = true;

					window.history.pushState(data, "", url);
					window.onpopstate(window.history);
				})
				.fail(function() {})
				.always(function() {});

		})();
		evt.preventDefault();

		$('body').addClass('small-header');
	})

	$('#langSwitcher .lang').click(function(){
		var el = $(this);
		var lang = el.attr('data-lang');
		(function() {
			$.ajax({
				url: root_path+"inc/changeLang.php",
				type: 'GET',
				dataType: 'json',
				data: {
					langToChange: lang
				}
			})
				.done(function(data) {
					if(data.ok && data.lang == lang)
						window.location.reload();
				})
				.fail(function() {})
				.always(function() {});

		})();
	})

	var sectionContent = $("#content");
	window.onpopstate = function(h) {
		if (h.state) {
			var title = h.state.title;
			var content = $(h.state.content);
			var idpage = h.state.idpage;
			var home = h.state.home;

			if (!home) {
				$('body').addClass('small-header');
				$('#logo').removeClass('active');
				$('#mn-' + idpage).addClass('active').siblings().removeClass('active');
			} else {
				$('body').removeClass('small-header');
				$('nav li').removeClass('active');
				$('#logo').addClass('active');
			}

			if(h.state.lang != h.state.usrlang)
				$('html').attr('lang',h.state.lang).attr('usr-lang',h.state.usrlang);

			if(h.state.menu){
				console.log("coucou")
				$('#logo a').html(h.state.menu[0]);
				for(i in h.state.menu){
					console.log(i);
					if(i != h.state.menu[0])
						$('#mn-' + i+' a').text(h.state.menu[i]);
				}
			}
			document.title = title;

			sectionContent.addClass('hide-page');
			setTimeout(function() {
				$('#content .page-content').remove();
				$('#content').append(content);
				sectionContent.addClass('beforeshow');

				setTimeout(function() {
					sectionContent.removeClass('hide-page beforeshow');
				}, 200);
			}, 400);
		}
	};

	/*$(window).scroll(function() {
		if ($(this).scrollTop() > 50 && $("#logo.active").length == 0)
			$(document.body).addClass('small-header');
		else
			$(document.body).removeClass('small-header');

	});*/

	var currentShow = false;
	var element = $('#logo');
	function clinDoeil(reloop) {
		if (!currentShow) {
			window.setTimeout(function() {
				if (!currentShow) element.addClass('blink');
				window.setTimeout(function() {
					if (!currentShow) {
						element.removeClass('blink')
						clinDoeil(element);
					}
				}, Math.random() * 500);
			}, 300 + Math.random() * 5000);
		} else if (currentShow != false) {
			if (!reloop) {
				clinDoeil(currentShow, true);
			} else {
				element = currentShow;
				window.setTimeout(function() {
					element.addClass('blink');
					window.setTimeout(function() {
						element.removeClass('blink')
						clinDoeil(element);
					}, Math.random() * 500);
				}, 300 + Math.random() * 5000);
				element.parent().parent().not(element).find('.image').addClass('blink');
			}
		}
	}
	clinDoeil();

	function getRootPath(){
		var path = window.location.toString();
		if(window.location.toString()[window.location.toString().length] != "/"){
			var menuIds = []
			$('nav li').each(function(i,el){
				menuIds.push(el.getAttribute('id').substring(el.getAttribute('id').indexOf('-')+1,el.getAttribute('id').length));
			});
			var pageSplit = window.location.toString().split('/');
			for(var j = pageSplit.length-1; j >= 0; j--){
				var ind = $.inArray(pageSplit[j], menuIds);
				if(ind >= 0){
					path = "";
					for(var i = 0; i < j ; i++)
						path += pageSplit[i]+'/';
					break;
				}
			}
		}
		return path;
	}
})(this);