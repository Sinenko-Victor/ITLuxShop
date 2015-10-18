/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    //config.filebrowserUploadUrl = '/lib/ckeditor_4.4.5/upload.php';
    
    config.filebrowserBrowseUrl = '/lib/kcfinder-3.12/browse.php?type=files';
    config.filebrowserImageBrowseUrl = '/lib/kcfinder-3.12/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = '/lib/kcfinder-3.12/browse.php?type=flash';
    config.filebrowserUploadUrl = '/lib/kcfinder-3.12/upload.php?type=files';
    config.filebrowserImageUploadUrl = '/lib/kcfinder-3.12/upload.php?type=images';
    config.filebrowserFlashUploadUrl= '/lib/kcfinder-3.12/upload.php?type=flash';
    
    
};

