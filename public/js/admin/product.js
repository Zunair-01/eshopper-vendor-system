$(document).ready(function () {
    getdata();
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
    function getdata() {
        $.ajax({
            url: '/show', // Your backend URL
            type: 'GET',
            dataType: "json",
            success: function (response) {
                document.querySelector('tbody').innerHTML = "";
                if (response.status === true) {
                    //console.log(response)
                    var tbody = document.querySelector('tbody');
                    response.data.forEach(function (product) {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${product.id}</td>
                            <td>${product.name}</td>
                            <td>$${product.price}</td>
                            <td>${product.category}</td>
                            <td>${product.description}</td>
                            <td><img src="/images/${product.image}" style="width:50px;height:50px" alt="Product Image"/></td>
                            <td>
                                <button type="button" value="${product.id}" class="btn btn-light edit_users">
                                    <i class="fas fa-edit" style="color: gray;"></i>
                                </button>
                                <button type="button" value="${product.id}" class="btn btn-light delete_users">
                                    <i class="fas fa-trash" style="color: gray;"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            },
            error: function (response) {
                console.log(response);
                if (response.responseJSON && response.responseJSON.message) {
                    alert(response.responseJSON.message);
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    }

    $('#productForm').on('submit', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData(this);
        $.ajax({
            url: '/store',
            type: 'POST',
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                $('#productForm')[0].reset();
                showSuccessMessage(response.message);
                getdata();
            },
            error: function (response) {
                console.log(response);
                if (response.responseJSON && response.responseJSON.message) {
                    showErrorMessage(response.responseJSON.message);
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    // Edit button click handler
    $(document).on('click', '.edit_users', function () {
         // Show the modal
         $('#editProductModal').modal('show');
        var productId = $(this).val();


        $.ajax({
            url: `/edit/${productId}`,
            type: 'GET',
            success: function (response) {
                console.log(response.data.image)
                // Populate modal form fields with product data

                $('#edit_product_id').val(response.data.id);
                $('#edit_name').val(response.data.name);
                $('#edit_price').val(response.data.price);
                $('#edit_category').val(response.data.category);
                $('#edit_description').val(response.data.description);
                $('#edit_image_preview').attr('src', '/images/' + response.data.image);

            },
            error: function (response) {
                console.error(response);
                alert('An error occurred while fetching product data.');
            }
        });
    });

    // Update product form submit handler

  // Set CSRF token globally for AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#editProductForm').on('submit', function (e) {
    e.preventDefault();
    var productId = $('#edit_product_id').val();
    var formData = new FormData(this);
    formData.append('_method', 'PUT');
    $.ajax({
        url: `/update/${productId}`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if(response.status === true){
                $('#editProductModal').modal('hide');
                showSuccessMessage(response.message);
                getdata();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText); // Log the error response for debugging
            alert('Error updating product: ' + xhr.responseText); // Display detailed error
        }
    });
});




$(document).on('click', '.delete_users', function () {
    productIdToDelete = $(this).val(); // Get product ID
    $('#deleteProductModal').modal('show'); // Show the confirmation modal
});
$(document).on('click', '.cancelButton', function () {
    $('#deleteProductModal').modal('hide'); // Show the confirmation modal
});
$(document).on('click', '.cancelButton', function () {
    $('#editProductModal').modal('hide'); // Show the confirmation modal
});

$('#confirmDeleteButton').on('click', function () {
    if (productIdToDelete) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `/delete/${productIdToDelete}`, // Your delete route
            type: 'DELETE',
            success: function (response) {
                $('#deleteProductModal').modal('hide'); // Hide the modal after successful delete
                showErrorMessage(response.message);
                getdata();
            },
            error: function (response) {
                console.error(response);
                if (response.responseJSON && response.responseJSON.message) {
                    alert(response.responseJSON.message);
                } else {
                    alert('An error occurred while deleting the product. Please try again.');
                }
            }
        });
    }
});

});
