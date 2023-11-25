<script>

// Initialize the page
$(document).ready(function() {
    let $token = $('meta[name="csrf-token"]').attr('content');
    let list_target_route = $('#table-data').attr('data-list_target_route'); 
    if (list_target_route) fetchData(list_target_route);

        $(document).on('input','.category-checkbox, .warehouse-checkbox, .factory-checkbox, .customer_type-checkbox, .expenditure_type-checkbox, .branch-checkbox, .search', function() {
            fetchData(list_target_route);
        });

        $(document).on('change','.range_date, #paginated-number', function() {
            fetchData(list_target_route);
        });

        $(document).on('input','.search-sidebar', function() {
           let target = $(this).attr('data-target');
            let saerch = $(this).val();
            let type = $(this).attr('data-type');
            fetchSideBarData(saerch,target,type);
        });

        $(document).on('click','.cancel_btn', function() {
            fetchData(list_target_route);
        });

        

    // Event listener for Add/Edit button click
    $(document).on('click','.edit-item-btn', function() {
        let id = $(this).closest('tr').attr('data-id'); 
        let url = $(this).attr('data-url') ;
        let name = $(this).attr('data-name') ;
        let target = '#table-data' ;

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
        let url = $(this).attr('data-url') ;
        let name = $(this).attr('data-name') ;
        let target = '#table-data' ;
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
                                    fetchData(data.list_target_route);
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
        let url = $(this).attr('data-url') ;
        let name = $(this).attr('data-name') ;

        Swal.fire({
                title: 'Are you sure you want to delete '+name+' ?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete action here
                    DeleteRecord(url,$token);
                }
            })
      
    });

     $(document).on('click', 'a.page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.ajax({
            url: url, // Replace with your Laravel route for fetching data
            type: 'GET',
            success: function(response) {
                    $('#table-data').html('').html(response.data);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            
        });


});


    // Fetch data and populate the table
  function fetchData(list_target_route) {
    let data = {};
    const search = $('.search').val();
    if (search) {
        data.search = search;
    }

    const paginated_number = $('#paginated-number').val();
    if (paginated_number) {
        data.paginated_number = paginated_number;
    }

    const from_date = $('#fromDate').val();
    const to_date = $('#toDate').val();
    if (from_date) {
        data.from_date = from_date;

    }if (to_date) {
        data.to_date = to_date;
    }


    $.ajax({
        url: list_target_route, // Replace with your Laravel route for fetching data
        data:data,
        type: 'GET',
        success: function(response) {
            $('#table-data').html('').html(response.data);
            $('#other-data').html('').html(response.other_data);
            $("#exportGroup .dropdown-menu a").each(function() {
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
function DeleteRecord(url,token) {
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
                    fetchData(data.list_target_route)
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