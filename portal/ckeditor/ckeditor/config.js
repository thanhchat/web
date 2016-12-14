/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
var str="http://localhost:7070/portal/ckeditor";
//var str="http://www.lunshop.tk/portal/ckeditor";
//var str="http://lunshop.net/portal/ckeditor";
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.skin = 'office2013';
	config.toolbar = [
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton'] },
	{items: [ 'Bold', 'Italic', 'Underline', 'Strike'] },{name:'smile',items:['Smiley', 'SpecialChar' ]},
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
	{ name: 'insert', items: [ 'Image','Table', 'HorizontalRule'] },{ name: 'links', items: [ 'Link', 'Unlink' ] },{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	{ name: 'colors', items: [ 'TextColor', 'BGColor' ,'Source'] }
];

	//config.width = 780;
	//config.height = '200px';
// Toolbar groups configuration.
/*config.toolbarGroups = [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'forms' },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
	{ name: 'links' },
	{ name: 'insert' },
	'/',
	{ name: 'styles' },
	{ name: 'colors' },
	{ name: 'tools' },
	{ name: 'others' }
];*/
	config.filebrowserBrowseUrl = str+'/ckfinder/ckfinder.html';
            //config.filebrowserImageBrowseUrl = str+'/ckfinder/ckfinder.html?type=Images';
            //config.filebrowserFlashBrowseUrl = str+'/ckfinder/ckfinder.html?type=Flash';
            //config.filebrowserUploadUrl = str+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
            //config.filebrowserImageUploadUrl = str+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
            //config.filebrowserFlashUploadUrl = str+'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
            config.filebrowserWindowWidth = 700;
            config.filebrowserWindowHeight = 600
};
