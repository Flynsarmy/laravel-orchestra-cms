jQuery(function onStoryCMSReady($) { 'use strict';
	var sluggify, events, title, slug;

	title  = $('#title');
	slug   = $('input[role="slug-editor"]:first');
	events = new Javie.Events();

	sluggify = function(string, allowSlashes) {
		if (_.isUndefined(string))
			return '';

		return '/' + string.toLowerCase()
			.replace(/[^\w\.]+/g, '-')
			.replace(/ +/g, '-')
			.replace(/^-/, '')
			.replace(/-$/, '');
	};

	events.listen('storycms.update: slug', function listenToSlugUpdate(string, forceUpdate) {
		string = sluggify(string);

		if (_.isUndefined(forceUpdate))
			forceUpdate = false;

		if (slug.data('listen') === true || forceUpdate)
			slug.val(string);
	});

	if (slug.val() === '') {
		slug.data('listen', true);
		events.fire('storycms.update: slug', [title.val(), true]);
	} else {
		slug.data('listen', false);
		events.fire('storycms.update: slug', [slug.val(), true]);
	}

	title.on('keyup', function onTitleKeyUp() {
		events.fire('storycms.update: slug', [title.val()]);
	});

	slug.on('blur', function onSlugBlurFocus() {
		events.fire('storycms.update: slug', [slug.val(), true]);
	});
});