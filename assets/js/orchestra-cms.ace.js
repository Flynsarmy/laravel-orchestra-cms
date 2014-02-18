jQuery(document).ready(function($) {
	var options = {
		showInvisibles: true,
		highlightActiveLine: true,
		showGutter: true,
		showPrintMargin: true,
		highlightSelectedWord: false,
		hScrollBarAlwaysVisible: false,
		useSoftTabs: true,
		tabSize: 4,
		wrapMode: 'off',
		readOnly: false,
		theme: 'textmate',
		folding: 'manual'
	};

	$('pre[data-editor=ace]').each(function() {
		var parent_elem = $($(this).data('parent'));
		var editor = ace.edit( $(this).attr('id') );
		var session = editor.getSession();
		editor.setTheme("ace/theme/" + options.theme);
		session.setMode("ace/mode/"+$(this).data('lang'));
		session.setValue( parent_elem.val() );

		editor.setShowInvisibles( options.showInvisibles );
		editor.setHighlightActiveLine( options.highlightActiveLine );
		editor.renderer.setShowGutter( options.showGutter );
		editor.renderer.setShowPrintMargin( options.showPrintMargin );
		editor.setHighlightSelectedWord( options.highlightSelectedWord );
		editor.renderer.setHScrollBarAlwaysVisible( options.hScrollBarAlwaysVisible );
		editor.setReadOnly( options.readOnly );
		session.setUseSoftTabs( options.useSoftTabs );
		session.setTabSize( options.tabSize );
		session.setFoldStyle( options.folding );

		switch (options.wrapMode) {
			case "off":
				session.setUseWrapMode(false);
				editor.renderer.setPrintMarginColumn(80);
				break;
			case "80":
				session.setUseWrapMode(true);
				session.setWrapLimitRange(80, 80);
				editor.renderer.setPrintMarginColumn(80);
			break;
				case "free":
				session.setUseWrapMode(true);
				session.setWrapLimitRange(null, null);
				editor.renderer.setPrintMarginColumn(80);
				break;
		}

		// Set content on form submit
		$(this).closest('form').submit(function() {
			parent_elem.val( session.getValue() );
		});
	});
});