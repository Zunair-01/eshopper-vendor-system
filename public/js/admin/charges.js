$(document).ready(function () {
    // Handle Add Charges
    function showSuccessMessage(message) {
        toastr.success(message, 'Success', {
            positionClass: 'toast-top-right',
            timeOut: 3000, // 3 seconds
        });
    }

    // Show error message
    function showErrorMessage(message) {
        toastr.error(message, 'Success', {
            positionClass: 'toast-top-right',
            timeOut: 3000, // 3 seconds
        });
    }
    $('.add').click(function () {
        $('#dataModal').modal('show');
    });

    $('.btn').click(function () {
        $('#dataModal').modal('hide');
    });
    $('.closeedit').click(function () {
        $('#editModal').modal('hide');
    });

    $('#saveChargesBtn').click(function () {
        const tax = $('#tax').val();
        const discount = $('#discount').val();
        const deliveryCharges = $('#deliveryCharges').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/charges', // Your route to handle the POST request
            method: 'POST',
            data: {
                tax: tax,
                discount: discount,
                deliveryCharges: deliveryCharges,
            },
            success: function (response) {
                showSuccessMessage("Charges added succesfully")
                $('#dataModal').modal('hide'); // Hide the modal
                $('#chargesForm')[0].reset(); // Reset the form
                loadCharges();

            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    // Handle Edit Button Click
    let productId; // Declare productId variable outside to make it accessible

    $(document).on('click', '.edit', function () {
        $('#editModal').modal('show'); // Show the edit modal
        const tax = $(this).data('tax');
        const discount = $(this).data('discount');
        const delivery = $(this).data('delivery');
        productId = $(this).data('id'); // Set productId when clicking edit button

        // Set the values in the edit modal
        $('#editTax').val(tax); // Set tax value
        $('#editDiscount').val(discount); // Set discount value
        $('#editDeliveryCharges').val(delivery); // Set delivery charges value
        $('#edit_product_id').val(productId); // Set hidden input for product ID
    });

    // Handle the update on button click
    $('#updateChargesBtn').click(function () {
        const updatedTax = $('#editTax').val();
        const updatedDiscount = $('#editDiscount').val();
        const updatedDeliveryCharges = $('#editDeliveryCharges').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/charges/' + productId, // Route for updating charges
            method: 'PUT', // Use PUT for updates
            data: {
                tax: updatedTax,
                discount: updatedDiscount,
                deliveryCharges: updatedDeliveryCharges,
            },
            success: function (response) {
                showSuccessMessage("Charges updated succesfully")
                $('#editModal').modal('hide'); // Hide the modal
                $('#editChargesForm')[0].reset(); // Reset the form
                loadCharges(); // Reload charges
            },
            error: function (xhr) {
                console.log(xhr.responseText); // Handle error
            }
        });
    });

    // Function to load charges dynamically
    function loadCharges() {
        $.ajax({
            url: '/get', // Update with the correct route for fetching charges in JSON
            method: 'GET',
            success: function (response) {
                $('#chargesTableBody').empty();
                $.each(response, function (index, charge) {
                    $('#chargesTableBody').append(`
                        <tr>
                            <td>$${charge.tax}</td>
                            <td>$${charge.discount}</td>
                            <td>$${charge.delivery_charges}</td>
                            <td>
                                <button class="btn btn-light edit" data-toggle="modal" data-target="#editModal"
                                        data-tax="${charge.tax}" data-discount="${charge.discount}" data-delivery="${charge.delivery_charges}"
                                        data-id="${charge.id}"> <!-- Ensure product ID is included here -->
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    loadCharges(); // Initial load of charges
});
