jQuery.fn.loading = function () {
	this.after('<div class="loading-container"><img class="loading-image"  src="/images/loading.gif"></div>');
	return this;
}

jQuery.fn.loadingEnd = function () {
	$('.loading-container').remove();
	return this;
}

