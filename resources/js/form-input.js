
let deletedItems = [];
let token = $('meta[name="csrf-token"]').attr('content');

$(function(){
    'use strict';
    $('form.amicrud input, form.amicrud textarea, form.amicrud select, form.amicrud.delete_btn, form.amicrud.save_btn, form.amicrud.edit_btn, form.amicrud.cancel_btn').prop('disabled', true);
    $('form.amicrud input[name="_token"], form.amicrud input[name="_method"], form.amicrud input[type="search"], form.amicrud .ignore, form.amicrud input[name="_token"]').prop('disabled',false);
    $('#search_form input, form.amicrud input#id').prop('disabled', false) ;
});

  $("#mini-search").on("keyup", function() {
    var val = $(this).val().toLowerCase();
    $("#mini-datatable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1)
    });
  });

$(document).ready(function() {

$(document).on('click', '.cancel_btn', function(e){
    let $form = $(this).closest('form') ;
    $form.find('input, textarea, select, .delete_btn, .save_btn').each(function(){$(this).prop('disabled',true)});
    $('#search_form input, input[type="search"], input[class="show-inactive"], form input[name="_token"]').prop('disabled', false);
    $form.find('.new_btn').show();
    $form.find('.edit_btn').show();
    $form.find('.new_btn').prop('disabled',false);
    $form.find('.edit_btn').prop('disabled',false);
    $form.find('.summernote').each(function(){$(this).summernote('disable')});
    $(this).hide();
});


$(document).on('click', '.new_btn', function(e){
    let $form = $(this).closest('form');
    $form.find('.delete_btn').prop('disabled',true);
    $form.find('.cancel_btn').show();
    $form.find('.edit_btn').hide();
    $form.find('.cancel_btn, .save_btn').each(function(){$(this).prop('disabled',false)});
    dissableForm($form,false,true);
    $('#search_form input, input[type="search"]').prop('disabled', false) ;
    $(this).hide();
});

$(document).on('click', '.edit_btn', function(e){
    let $form = $(this).closest('form');
    $form.find('.save_btn').each(function(){$(this).prop('disabled',false)});
    $form.find('.new_btn').hide();
    $form.find('.cancel_btn').show();
    $form.find('.cancel_btn').prop('disabled',false);
    $(this).hide();
    dissableForm($form,false);
});


$(document).on('click', '.edit-details', function(){
    let url = $(this).attr('data-url') ;
    let target = $(this).attr('data-target') ;
    EditItem(url, target);
});

$(document).on('click', '.delete-details', function(){
    let url = $(this).attr('data-url') ;
    let name = $(this).attr('data-name') ;
    DeleteItem(name, url)

});


/**
 *  Handle form submissions.
 */
$(document).on('click', '.save_btn', function(e){
    e.preventDefault();
    const btn = $(this);
    btn.prop('disabled', true);
    let form=btn.closest('form');
    let data = new FormData(form[0]);
    let url = form.attr("action");
    let method = form.attr("method");
        if (confirm("Are you sure you want to save this record?")) {
            btn.append('<span class="spin-loader"> <i class="fa fa-spinner fa-spin"></i> please wait...</span>');
            $.ajax({
                type: method,
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                error: function(xhr, status, error) {
                    btn.prop('disabled', false);
                    $('.spin-loader').fadeOut();
            
                    /////////////////////////////////////////////
                    let errors = xhr.responseJSON.errors;
                    let firstError = Object.values(errors)[0];
                    $('.process-response').html('').html('<code>'+firstError+'</code>');
                    setTimeout(function() {
                        $('.process-response').html('');
                    },3000);
                    //////////////////////////////////////////////
                },
                success: function (data) {
                    btn.prop('disabled', false);
                    $('.spin-loader').fadeOut();
                    $('.process-response').html('').html(data.message);
                        if (data.list_target&&data.list_target_url) {
                            ListItems(data.list_target_url, data.list_target)
                        }
                        if(data.reload)
                        {
                            setTimeout(function() {
                            window.location.reload();
                            },2000);
                        }
                },
            });
        }
    });
});






function dissableForm(form,disable,clear=false) {
    form.find('input, textarea, select').each(function(){
        let name = $(this).attr('name');
        let type = $(this).attr('type') ;
        let status = $(this).attr('data-ignore');
        if(name === '_token' || name === '_method' || status != null){
        }else{
            if (clear) {$(this).val(''); }
            $(this).prop('disabled',disable);
        }
        if(type === 'checkbox' || type === 'radio'){
            $(this).prop('disabled',disable);
        }
    });
}





function EditItem(url, target)
{
    $.ajax({
        type: "GET",
        url: url,
        timeout:60000,
        datatype: "json",
        cache: false,
        beforeSend: function( xhr ) {
            $(target).html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        },
       error: function(xhr, status, error) {
            $(target).html('');
        },
        success: function (data) {
            $(target).html("");
            $(target).html(data);
            const $form = $(target).find('form');
            dissableForm($form,true);
            $form.find('.new_btn').hide();
            $form.find('.cancel_btn').show();
            $form.find('.edit_btn').prop('disabled', false);
            $form.find('.save_btn').prop('disabled', true);
            $(target).find('.dropify').each(function(){$(this).dropify()});
            $(target).find('.summernote').each(function(){$(this).summernote('disable')});
            // $('.select2').select2();
        },
    });
}


function ListItems(url, target)
{
    $.ajax({
        type: "GET",
        url: url,
        timeout:60000,
        datatype: "json",
        cache: false,
        beforeSend: function( xhr ) {
            $(target).html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        },
       error: function(xhr, status, error) {
            $(target).html('');
        },
        success: function (data) {
            $(target).html("");
            $(target).html(data);
        },
    });
}




function DeleteItem(name, url)
{
        if (confirm("This is an irrevisable action that will delete "+name.toUpperCase()+" Are you sure you want to delete "+ name.toUpperCase())) {
            $.ajax({
                type: "DELETE",
                url: url,
                data: ({_token:token}),
                timeout:60000,
                datatype: "json",
                cache: false,
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    btn.prop('disabled', false);
                    $('.spin-loader').fadeOut();
            
                    /////////////////////////////////////////////
                    let errors = xhr.responseJSON.errors;
                    let firstError = Object.values(errors)[0];
                    $('.process-response').html('').html(firstError, 'error');
                    //////////////////////////////////////////////
                },
                success: function (data) {
                    $('.success-response').html('').html(data.message);
                    if (data.list_target&&data.list_target_url) {
                        ListItems(data.list_target_url, data.list_target)
                    }
                    setTimeout(function() {
                        $('.success-response').html('');
                    }, 5000);
                    if(data.Reload)
                    {
                        setTimeout(function() {
                        window.location.reload();
                        },2000);
                    }
                },
            });
        }
}




function SaveItem()
{
    let form=$(this).closest('form');
    let data = new FormData(form[0]);
    let url = form.attr("action");
    let method = form.attr("method");

    $.ajax({
        type: method,
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        error: function(xhr, status, error) {
            btn.prop('disabled', false);
            $('.spin-loader').fadeOut();
            
            /////////////////////////////////////////////
            let errors = xhr.responseJSON.errors;
            let firstError = Object.values(errors)[0];
            $('.process-response').html('').html(firstError, 'error');
            //////////////////////////////////////////////
           
        },
        success: function (data) {
            $('.process-response').html('').html(data.message);

            if(data.Reload)
            {
                setTimeout(function() {
                window.location.reload();
                },2000);
            }
        },
    });
}