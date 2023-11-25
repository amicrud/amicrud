<script>
    // Fetch data and populate the table
function fetchData() {
    $.ajax({
        url: '/customers', // Replace with your Laravel route for fetching data
        type: 'GET',
        success: function(response) {
            // Process the response and populate the table dynamically
            // You can use JavaScript templating libraries like Handlebars or Underscore.js for easier templating
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

// Save new customer or update existing customer
function saveCustomer() {
    $.ajax({
        url: '/customers', // Replace with your Laravel route for saving/updating customer
        type: 'POST',
        data: {
            // Gather the data from the modal form fields
        },
        success: function(response) {
            // Process the response and update the table dynamically
            // You can also update the table row directly without refreshing the page
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

// Delete a customer
function deleteCustomer(customerId) {
    $.ajax({
        url: '/customers/' + customerId, // Replace with your Laravel route for deleting customer
        type: 'DELETE',
        success: function(response) {
            // Process the response and remove the table row dynamically
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

// Event listener for Add/Edit button click
$(document).on('click', '.add-btn, .edit-item-btn', function() {
    var customerId = $(this).closest('tr').find('.id').text(); // Get the customer ID for editing
    if (customerId) {
        // Edit mode: Populate the modal with customer data by making an AJAX call to fetch the specific customer details
        $.ajax({
            url: '/customers/' + customerId, // Replace with your Laravel route for fetching specific customer details
            type: 'GET',
            success: function(response) {
                // Process the response and populate the modal form fields
                // Show the modal
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    } else {
        // Add mode: Clear the modal form fields
        // Show the modal
    }
});

// Event listener for Save button click inside the modal
$(document).on('click', '#save-btn', function() {
    saveCustomer();
});

// Event listener for Remove button click inside the modal
$(document).on('click', '#remove-btn', function() {
    var customerId = $(this).closest('.modal').find('.id').text(); // Get the customer ID for deleting
    deleteCustomer(customerId);
});

// Event listener for Check All checkbox
$(document).on('change', '#checkAll', function() {
    if ($(this).is(':checked')) {
        $('.form-check-input[name="chk_child"]').prop('checked', true);
    } else {
        $('.form-check-input[name="chk_child"]').prop('checked', false);
    }
});

// Event listener for Delete Multiple button click
function deleteMultiple() {
    var selectedCustomers = [];
    $('.form-check-input[name="chk_child"]:checked').each(function() {
        var customerId = $(this).closest('tr').find('.id').text(); // Get the selected customer IDs
        selectedCustomers.push(customerId);
    });

    if (selectedCustomers.length > 0) {
        // Make an AJAX call to delete multiple customers by sending the selected customer IDs as an array
        $.ajax({
            url: '/customers/delete-multiple', // Replace with your Laravel route for deleting multiple customers
            type: 'DELETE',
            data: {
                customers: selectedCustomers
            },
            success: function(response) {
                // Process the response and remove the table rows dynamically
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
}

// Initialize the page
$(document).ready(function() {
    fetchData();
});

</script>