$(document).ready(function () {
    'use strict';
    var form, name, email, message, newCommentBlockSample, newCommentBlock;


    $('#comment-preview').on('click', function () {
        form = $('#form-container').find('form');

        name = form.find('input#name').val();
        email = form.find('input#email').val();
        message = form.find('textarea#message').val();



        if (name != '' && email != '' && message != '') {
            newCommentBlockSample = $('#comments-wrapper').data('prototype');

            newCommentBlock = newCommentBlockSample
                .replace('__AUTHOR__', name)
                .replace('__COMMENT_TEXT__', message);

            $('#comments-container').append(newCommentBlock);
        }
    });
});