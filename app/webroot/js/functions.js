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
	$('.lightbox').lightBox({
		imageLoading: '/img/lightbox-ico-loading.gif',
		imageBtnPrev: '/img/lightbox-btn-prev.gif',
		imageBtnNext: '/img/lightbox-btn-next.gif',
		imageBtnClose: '/img/lightbox-btn-close.gif',
		imageBlank: '/img/lightbox-blank.gif'
	});
});