/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';
	$('#mess').puigrowl();
            addMessage = function (msg) {
                $('#mess').puigrowl('show', msg);
            };
    // Initialize the jQuery File Upload widget:
    var id = window.location.href.split('id=')[1];
    $('#fileupload').fileupload({
        url: 'upload/server/php/?id='+id,
            confirmDeletion: function(e,data) {
            var imageName=data.files[0].url.split('?file=')[1].split('&id=')[0];
            var doDel = confirm('Bạn có chắc muốn xóa?');
            if (doDel) {
                $.ajax({
                    type: "GET",
                    url: 'upload/server/php/checkImage.php?imageCheck='+imageName+'&idProduct='+window.location.href.split('?id=')[1],
                    dataType: "text",
                    success: function (response) {
							if(response=='0'){
								e.doDelete();
								addMessage([{
                                                        severity: 'info',
                                                        summary: '',
                                                        detail: 'Xóa hình ảnh thành công'
                                                    }]);
							}else{
								addMessage([{
                                                        severity: 'error',
                                                        summary: '',
                                                        detail: 'Hình này được dùng cập nhật cho tính năng nên không được xóa'
                                                    }]);
							}
                    }
                });
            }
        }
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 999000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {
                    result: result
                });
        });
    }

});
