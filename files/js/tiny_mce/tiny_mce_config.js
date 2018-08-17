tinyMCE.init({
	theme : 'advanced',
	mode : 'textareas',
	plugins: 'table,insertimages',
	theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,separator,bullist,numlist,separator,undo,redo,separator,link,unlink,separator,justifyleft,justifycenter,justifyright,justifyfull,code,image',
	theme_advanced_buttons2 : '',
	theme_advanced_buttons3 : '',
	theme_advanced_toolbar_location : 'top',
	extended_valid_elements : "iframe[src|width|height|frameborder|id|style|scrolling|name|marginwidth|marginheight],script[src|type]" //request by gadir 28-02-2013
});
