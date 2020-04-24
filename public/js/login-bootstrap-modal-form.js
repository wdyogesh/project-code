/*!
 * Laravel-Bootstrap-Modal-Form (https://github.com/JerseyMilker/Laravel-Bootstrap-Modal-Form)
 * Copyright 2015 Jesse Leite - MIT License
 *
 * Bromance:
 * Adam Wathan has nice boots. Thank you for BootForms magic.
 * Matt Higgins has nice beard. Thank you for JS wizardry.
 */

$(document).on('submit', '.bootstrap-modal-form', function(submission){

    // Prepare reset.
    function resetModalFormErrors() {
        $('.form-group').removeClass('has-error');
        $('.form-group').find('.help-block').remove();
    }

    // Intercept submit.

        submission.preventDefault();

        // Set vars.
        var form   = $(this),
            url    = form.attr('action'),
            submit = form.find('[type=submit]');

        // Check for file inputs.
        if (form.find('[type=file]').length) {

            // If found, prepare submission via FormData object.
            var input       = form.serializeArray(),
                data        = new FormData(),
                contentType = false;

            // Append input to FormData object.
            $.each(input, function(index, input) {
                data.append(input.name, input.value);
            });

            // Append files to FormData object.
            $.each(form.find('[type=file]'), function(index, input) {
                if (input.files.length == 1) {
                    data.append(input.name, input.files[0]);
                } else if (input.files.length > 1) {
                    data.append(input.name, input.files);
                }
            });
        }

        // If no file input found, do not use FormData object (better browser compatibility).
        else {
            var data        = form.serialize(),
                contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        }

        // Please wait.
        if (submit.is('button')) {
            var submitOriginal = submit.html();
            submit.html('Please wait...');
            submit.attr("disabled", true);
        } else if (submit.is('input')) {
            var submitOriginal = submit.val();
            submit.val('Please wait...');
        }

        // Request.
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            contentType: contentType,
            processData: false

        // Response.
        }).always(function(response, status) {
            // Reset errors.
            resetModalFormErrors();

            // Check for errors.
            if (response.status == 301) {
                var errors = $.parseJSON(response.responseText);
                // Iterate through errors object.
                $.each(errors, function(field, message) {
                    //console.error(field+': '+message);
                    var formGroup = $('[name='+field+']', form).closest('.form-group');
                    formGroup.addClass('has-error').append('<p class="help-block">'+message+'</p>');
                });

                // Reset submit.
                if (submit.is('button')) {
                    submit.html(submitOriginal);
                    submit.attr("disabled", false);
                } else if (submit.is('input')) {
                    submit.val(submitOriginal);
                }

            // If successful, redirect.
            }else if (response.status == 500) {
                // alert('Something went wrong');
                location.reload();
                submit.val(submitOriginal);
            }
            else if (response.status == 404) {
                // alert('Something went wrong');
                location.reload();
                submit.val(submitOriginal);
            }
             else if(response.status == 200){
                // var loc = window.location;
                if(response.redirect_url == undefined){
                    $(response.label_success_message).html(response.success);
                    submit.val(response.label_submit);

                    $('form').find('textarea,:text').each( function(){
                        $(this).val('');
                    });
                }else{
                    window.location = response.redirect_url;
                    ('#sucMsgDeleteDiv').show();
                }
                //location.reload(); //use this for bootstrap modal
                //alert('hai');
            }else{
                // alert('default');
            }
        });


    // Reset errors when opening modal.
    $('.bootstrap-modal-form-open').click(function() {
        resetModalFormErrors();
    });

});
