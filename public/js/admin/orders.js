$(document).ready(function() {
    $.ajax({
        url: '/orders',  // This should match the route in web.php
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),  // Include the CSRF token
            'Accept': 'application/json'  // Ensure you expect a JSON response
        },
        success: function (response) {
            if (response.success) {
                // Clear the table body
                $('#ordersTableBody').empty();

                // Loop through each order and append it to the table
                response.data.forEach(function(order, index) {
                    // Determine the button based on order status
                    let statusButton = '';
                    if (order.status === 'Completed') {
                        statusButton = `<button class="btn btn-success">Complete</button>`;
                    } else if (order.status === 'pending') {
                        statusButton = `<button class="btn btn-warning">Pending</button>`;
                    }

                    $('#ordersTableBody').append(`
                        <tr>
                            <td>${index + 1}</td>  <!-- SR No. -->
                            <td>${order.order_id}</td>  <!-- Order ID -->
                            <td>${order.order_items_count}</td>  <!-- Order Items Count -->
                            <td>${order.customer_name}</td>  <!-- Customer Name -->
                            <td>${order.grand_total}</td>  <!-- Grand Total -->
                            <td>${statusButton}</td>  <!-- Status as button -->
                        </tr>
                    `);
                });
            } else {
                console.error(response.message); // Log any error messages
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);  // Log any error message
        }
    });
});
