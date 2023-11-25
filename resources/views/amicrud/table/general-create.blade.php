@extends($page_layout)
@section('title', form_labels($crud_name))
@section('page-title') {{form_labels($crud_name)}} @endsection
@section('breadcrumb')
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 justify-content-center">
                  <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add, Edit &amp; Remove {{form_labels($crud_name)}}</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="customerList">
                                    <!-- Add/Edit Buttons -->
                                    <div class="row g-4 mb-3">
                                        <div class="col-sm-auto">
                                            <div>
                                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" data-name="{{Str::singular($crud_name)}}" data-url="{{sign_url(route($form_edit_route,'null'))}}"><i class="ri-add-line align-bottom me-1"></i> Add</button>
                                                 <!-- Vertical Variation -->
                                                 <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                    <div class="btn-group" id="exportGroup" role="group">
                                                        <button id="exportBtnGroup" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Export
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="exportBtnGroup">
                                                            <li><a class="dropdown-item" href="#" target="_blank" data-export-type="pdf"><i class="mdi mdi-file-pdf-box"></i>PDF</a></li>
                                                            <li><a class="dropdown-item" href="#" target="_blank" data-export-type="excel"><i class="mdi mdi-microsoft-excel"></i>Excel</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                    
                                            </div>
                                        </div>
                                        @if(!isset($search))
                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="search-box ms-2">
                                                    <input type="text" class="form-control search" placeholder="Search...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Table -->
                                    <div id="table-data" data-list_target_route="{{sign_url(route($list_target_route))}}">
                                    </div>
                    </div>
                </div><!-- end card -->
            </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

@include('amicrud::amicrud.table.modal')

@endsection
@section("js")
   
<script>

// Initialize the page
$(document).ready(function() {
    let $token = $('meta[name="csrf-token"]').attr('content');
    let list_target_route = $('#table-data').attr('data-list_target_route'); 
    if (list_target_route) fetchData(null,list_target_route);
    
       $('.search').on('input', function() {
            var query = $(this).val();
            fetchData(query,list_target_route);
        });

    // Event listener for Add/Edit button click
    $(document).on('click','.edit-item-btn', function() {
        let flow_type_id = $.urlParam('flow_type_id');

        let id = $(this).closest('tr').attr('data-id'); 
        let url = $(this).attr('data-url') ;

        if (flow_type_id) {
            url = url+'?flow_type_id='+flow_type_id;
        }

        let name = $(this).attr('data-name') ;
        let target = '#showModal .modal-body' ;
        $('#EditModalLabel').html('Edit '+name);
        $('#showModal .modal-content a#open-new-page').attr('href',url).attr('target','_blank');
 
        if (id) {
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
                    $(target).html("").html(data);
                    const $form = $(target).find('form');
                    $(target).find('.dropify').each(function(){$(this).dropify()});
                    $(target).find('.summernote').each(function(){$(this).summernote('disable')});
                    // $('.select2').select2();
                },
            });
        }
    });

    $(document).on('click', '.add-btn', function() {
        let flow_type_id = $.urlParam('flow_type_id');

        let url = $(this).attr('data-url') ;
        if (flow_type_id) {
            url = url+'?flow_type_id='+flow_type_id;
        }

        let name = $(this).attr('data-name') ;
        let target = '#showModal .modal-body' ;
        $('#EditModalLabel').html('Add '+name);
        $('#showModal .modal-content a#open-new-page').attr('href',url).attr('target','_blank');
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
                    $(target).html("").html(data);
                    const $form = $(target).find('form');
                    $(target).find('.dropify').each(function(){$(this).dropify()});
                    $(target).find('.summernote').each(function(){$(this).summernote('disable')});
                },
            });
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
            let modal = '#showModal' ;
                // if (confirm("Are you sure you want to save this record?")) {
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
                            if (errors) {
                            for (control in errors) {
                                $('.error-response.' + control).html('<code>'+errors[control][0]+'</code>');
                            }
                            setTimeout(function() {
                            $('.error-response').html('');
                            },3000);
                            }
                            else{
                            // $.notify(html_to_text(error), 'error');
                            Swal.fire({
                                title: html_to_text(error),
                                icon: 'error', // success, error, warning, info, or question
                                confirmButtonText: 'Close',
                              });
                            }
                            //////////////////////////////////////////////
                        },
                        success: function (data) {
                            btn.prop('disabled', false);
                            $('.spin-loader').fadeOut();

                            // $.notify(html_to_text(data.message), 'success');
                            Swal.fire({
                                title: html_to_text(data.message),
                                icon: data.status, // success, error, warning, info, or question
                                confirmButtonText: 'Close',
                              });
                            $(modal).modal('hide');
                                if (data.list_target&&data.list_target_route) {
                                    fetchData(null,data.list_target_route);
                                }
                                if(data.reload)
                                {
                                    setTimeout(function() {
                                    window.location.reload();
                                    },2000);
                                }
                        },
                    });
                // }
            });

    // Event listener for Remove button click inside the modal
    $(document).on('click', '.remove-item-btn', function() {
        $('#deleteRecordModal').modal('show');
        let url = $(this).attr('data-url') ;
        let name = $(this).attr('data-name') ;
        let modal = '#deleteRecordModal .modal-body' ;

        $(modal).html('').html('<div class="mt-2 text-center"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5"><h4>Are you Sure ?</h4><p class="text-muted mx-4 mb-0 text_message">This is an irrevisable action that will delete '+name.toUpperCase()+'</p></div></div><div class="d-flex gap-2 justify-content-center mt-4 mb-2"><button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button><button type="button" class="btn w-sm btn-danger delete-record" data-url="'+url+'" >Yes, Delete It!</button></div>'
        );
      
    });



    $(document).on('click', '.delete-record', function() {
        let url = $(this).attr('data-url') ;
         deleteCustomer(url,$token);
         $('#deleteRecordModal').modal('hide');
    });

     $(document).on('click', 'a.page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.ajax({
            url: url, // Replace with your Laravel route for fetching data
            type: 'GET',
            success: function(response) {
                    $('#table-data').html('').html(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            
        });

});


    $.urlParam = function(name) {
        let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        } else {
            return decodeURIComponent(results[1]) || 0;
        }
    };

    // Fetch data and populate the table
  function fetchData(search=null,list_target_route) {
    let flow_type_id = $.urlParam('flow_type_id');

    if (search) {
        if (flow_type_id) {
            list_target_route = list_target_route+'?search='+search+'&flow_type_id='+flow_type_id;
        }else{
            list_target_route = list_target_route+'?search='+search;
        }
       
    }else{
        if (flow_type_id) {
            list_target_route = list_target_route+'?flow_type_id='+flow_type_id;
        }
    }
    

    $.ajax({
        url: list_target_route, // Replace with your Laravel route for fetching data
        type: 'GET',
        success: function(response) {
            $('#table-data').html('').html(response.data);
            $("#exportGroup ul.dropdown-menu li a").each(function() {
                let exportType = $(this).data('export-type');
                // Update href based on export type
                $(this).attr("href", response.export_url + '&export-type=' + exportType);
            });
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
      });
    }


// Delete a customer
function deleteCustomer(url,token) {
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
                // $.notify(html_to_text(data.message), 'success');
                Swal.fire({
                title: html_to_text(data.message),
                icon: data.status, // success, error, warning, info, or question
                confirmButtonText: 'Close',
                });
                if (data.list_target&&data.list_target_route) {
                    fetchData(null,data.list_target_route)
                }
            },
        });
    }

    function html_to_text(message) {
        var $tempElement = $('<div/>'); // Create a temporary div element
        $tempElement.html(message); // Set the HTML content
        $tempElement.find('button.close').remove();
        return $tempElement.text(); 
    }

</script>
@endsection
