function filter_table(curr) {
	$("a.filter_link").removeClass('activ');
	curr.addClass('activ');
	var data = curr.attr('href');
	$(".boxMod table").find("tr.body").hide();
	$(".boxMod table").find("tr.r" + data.replace(".","\\.")).show();
	
}
$(function(){
	$("a.filter_link").click( function () {
		filter_table($(this));
		return false;
	});
	
	/*
	$(".boxMod table").tablesorter({
		0 : {sorter: false},
		1 : {sorter: false},
		2 : {sorter: false},
		3 : {sorter: false},
		sortList: [[4,0]]
	});
	*/
	if (window.GLightbox) {
		GLightbox({
			selector: '.lightbox, [data-lightbox], [rel^="lightbox"]',
			touchNavigation: true,
			zoomable: true,
			loop: false
		});
	}
});
// Тултипы наличия и времени доставки (.tooltip-places): показываем над элементом,
// прижимаем к краю экрана, если сбоку не хватает места, и переворачиваем вниз,
// если не хватает места сверху. position: fixed не даёт обрезать тултип контейнерам с overflow.
function position_tooltip(wrap) {
	var tip = $(wrap).children('.tooltiptext')[0];
	if (!tip) {
		return;
	}
	var margin = 8, gap = 8;
	tip.classList.add('is-floating');
	tip.classList.remove('is-below');
	tip.style.left = '0px';
	tip.style.top = '0px';
	var anchor = wrap.getBoundingClientRect(), rect = tip.getBoundingClientRect();
	var vw = document.documentElement.clientWidth, vh = window.innerHeight;
	var left = anchor.left + anchor.width / 2 - rect.width / 2;
	left = Math.max(margin, Math.min(left, vw - margin - rect.width));
	var top = anchor.top - rect.height - gap;
	if (top < margin && anchor.bottom + gap + rect.height <= vh - margin) {
		top = anchor.bottom + gap;
		tip.classList.add('is-below');
	}
	var arrow = anchor.left + anchor.width / 2 - left;
	arrow = Math.max(14, Math.min(arrow, rect.width - 14));
	tip.style.left = left + 'px';
	tip.style.top = top + 'px';
	tip.style.setProperty('--arrow-x', arrow + 'px');
}
$(document)
	.on('mouseenter', '.tooltip-places', function () {
		if ($(this).children('.tooltiptext').length) {
			$(this).addClass('is-open');
			position_tooltip(this);
		}
	})
	.on('mouseleave', '.tooltip-places', function () {
		$(this).removeClass('is-open');
	})
	.on('click', '.tooltip-places', function (e) {
		// на тач-устройствах открываем по нажатию
		if (!window.matchMedia || !window.matchMedia('(hover: none)').matches || !$(this).children('.tooltiptext').length) {
			return;
		}
		var open = $(this).hasClass('is-open');
		$('.tooltip-places.is-open').removeClass('is-open');
		if (!open) {
			$(this).addClass('is-open');
			position_tooltip(this);
		}
		e.stopPropagation();
	})
	.on('click', function () {
		$('.tooltip-places.is-open').removeClass('is-open');
	});
$(window).on('scroll resize', function () {
	$('.tooltip-places.is-open').each(function () {
		position_tooltip(this);
	});
});

// Поиск по спискам подбора по авто (марки, модели)
$(document).on('input', '.sel-search', function () {
	var q = $.trim($(this).val()).toLowerCase(), $grid = $($(this).data('target')), shown = 0;
	$grid.children('[data-title]').each(function () {
		var match = q === '' || String($(this).data('title')).indexOf(q) !== -1;
		$(this).toggle(match);
		if (match) {
			shown++;
		}
	});
	$grid.nextAll('.sel__empty').first().prop('hidden', shown > 0);
});
