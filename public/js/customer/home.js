$(document).ready(function () {
    let allProducts = []; // Store fetched products
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
    // Fetch categories and all products initially
    getCategories();
    getProducts('all'); // Display all products on page load

    // Function to fetch categories
    function getCategories() {
        $.ajax({
            url: '/showCategories', // Backend URL to fetch categories
            type: 'GET',
            dataType: "json",
            success: function (response) {
                $('.category-list').empty(); // Clear existing categories
                if (response.status === true) {
                    // Add "All" category with total product count
                    $('.category-list').append(`
                        <li><a href="#all" data-category="all">All (${response.totalProducts})</a></li>
                    `);

                    // Add each category with product count
                    response.categories.forEach(function (category) {
                        $('.category-list').append(`
                            <li><a href="#${category.category}" data-category="${category.category}">
                                ${category.category} (${category.count})
                            </a></li>
                        `);
                    });

                    // Attach click event to category links
                    $('.category-list a').on('click', function (e) {
                        e.preventDefault();
                        var selectedCategory = $(this).data('category');
                        var categoryName = $(this).text().split(' (')[0]; // Extract category name
                        updateHeading(categoryName); // Update heading with selected category
                        getProducts(selectedCategory); // Fetch and display products
                    });
                }
            },
            error: function (response) {
                console.log(response);
                alert('An error occurred while fetching categories.');
            }
        });
    }

    // Update heading with selected category name
    function updateHeading(categoryName) {
        $('#selected-category').text(categoryName);
    }

    // Fetch products based on selected category
    function getProducts(category) {
        $.ajax({
            url: `/showProductsByCategory/${category}`, // Backend URL to fetch products
            type: 'GET',
            dataType: "json",
            success: function (response) {
                $('.products-container').empty(); // Clear existing products
                if (response.status === true) {
                    allProducts = response.products; // Store fetched products for search/filtering
                    displayProducts(allProducts); // Display products
                }
            },
            error: function (response) {
                console.log(response);
                alert('An error occurred while fetching products.');
            }
        });
    }

    // Display products function
    function displayProducts(products) {
        $('.products-container').empty(); // Clear previous products
        if (products.length === 0) {
            $('.products-container').append('<p>No products found.</p>'); // Show message if no products found
        } else {
            products.forEach(function (product) {
                var productCard = `
                    <div class="product-card">
                        <img src="/images/${product.image}" alt="${product.name}" class="product-image" />
                        <h2 class="product-name">${product.name}</h2>
                        <p class="product-description">${product.description}</p>
                        <p class="product-price">$${product.price}</p>
                        <a href="#" class="add-to-cart-btn" data-id="${product.id}">Add to Cart</a>
                    </div>
                `;
                $('.products-container').append(productCard); // Append new product card
            });
        }
    }

    // Search functionality on keyup
    $('.search-input').on('keyup', function () {
        const query = $(this).val().toLowerCase(); // Get search input value and convert to lowercase
        if (query.length > 0) {
            const filteredProducts = allProducts.filter(product => product.name.toLowerCase().includes(query));
            displayProducts(filteredProducts); // Display filtered products
        } else {
            displayProducts(allProducts); // Display all products when search input is cleared
        }
    });



    // cart functions
    $(document).on('click', '.add-to-cart-btn', function (e) {
        e.preventDefault();
        const productId = $(this).data('id');
        console.log(productId)
        $.ajax({
            url: '/addToCart',  // Endpoint for adding to cart
            type: 'POST',
            data: {
                product_id: productId,
                quantity: 1,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'unauthenticated') {
                    // If user is not logged in, redirect to the login page
                    window.location.href = 'auth/login';
                } else if (response.status === 'success') {
                    showSuccessMessage('Item added to cart successfully.')
                    fetchCartCount();
                }
            },
            error: function (response) {
                console.log('Error status:', response.status);  // Log the status code
                console.log(response.responseText);  // Log the actual response text for more details
                alert('An error occurred. Status: ' + response.status);
            }
        });
    });


    function showCart() {
        $.ajax({
            url: '/cus-fetched',  // Endpoint to get cart items
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'unauthenticated') {
                    window.location.href = 'auth/login';
                } else if (response.status === 'empty') {
                    $('.cart-items').html('<p>Your cart is empty.</p>');
                } else if (response.status === 'success') {
                    displayCartItems(response.cartItems); // Recalculate total inside this function
                    fetchCartCount();
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    }
    var tax = 0;
    var delivery = 0;
    var discount = 0;
    function displayCartItems(cartItems) {
        const cartItemsContainer = $('.cart-items');
        cartItemsContainer.empty(); // Clear existing items
        let subtotal = 0; // Subtotal before tax, delivery, and discount

        cartItems.forEach(item => {
            const cartItemHtml = `
                <div class="cart-item" data-id="${item.id}">
                    <img src="/images/${item.product.image}" style="width:150px;height:100px" class="product-image" />
                    <div class="item-details">
                        <h3>Product Name:  ${item.product.name}</h3>
                        <p class="quantity">Quantity: ${item.quantity}</p>
                        <span class="price">Price: $${item.product.price}</span>
                    </div>
                    <button class="remove-item">Remove</button>
                </div>
            `;
            cartItemsContainer.append(cartItemHtml);

            // Calculate subtotal
            subtotal += item.product.price * item.quantity;
        });

        // After the cart items are displayed, recalculate subtotal, discount, tax, and grand total
        const discountAmount = subtotal * (discount / 100);
        const taxAmount = subtotal * tax;
        const grandTotal = subtotal + taxAmount + delivery - discountAmount;

        // Update the totals in the UI
        $('#subtotal-amount').text(`Subtotal: $${subtotal.toFixed(2)}`);
        $('#tax').text(`Tax: $${taxAmount.toFixed(2)}`);
        $('#delivery').text(`Delivery: $${delivery.toFixed(2)}`);
        $('#discount').text(`Discount: -$${discountAmount.toFixed(2)}`);
        $('#grand-total-amount').text(`Grand Total: $${grandTotal.toFixed(2)}`);
    }

    // Function to remove an item from the cart
    $(document).on('click', '.remove-item', function () {
        const cartItemId = $(this).closest('.cart-item').data('id');

        $.ajax({
            url: '/remove-cart-item/' + cartItemId, // Adjust this URL to match your route
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === 'success') {
                    showErrorMessage('Item remove to cart successfully')
                    showCart();
                    fetchCartCount();

                } else {
                    alert('Failed to remove item from cart.');
                }
            },
            error: function () {
                alert('An error occurred while removing the item.');
            }
        });
    });

    function fetchCartCount() {
        $.ajax({
            url: '/cart/count', // Define a route to get the cart item count
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    $('#cart-count').text(response.count); // Update the cart count in the badge
                }
            },
            error: function() {
                console.error('Could not fetch cart count');
            }
        });
    }
    fetchCartCount();
    showCart();

    $(document).on('click', '.checkout-button', function (e) {
        e.preventDefault();
        const subtotalText = $('#subtotal-amount').text(); // Get text from the element
        const grandTotalText = $('#grand-total-amount').text(); // Get text from the element
        const subtotal = parseFloat(subtotalText.replace(/[^0-9.-]+/g, "")); // Remove any non-numeric characters
        const grandTotal = parseFloat(grandTotalText.replace(/[^0-9.-]+/g, "")); // Remove any non-numeric characters

        // Sending data through AJAX to create the order
        $.ajax({
            url: '/create-order',
            type: 'POST',
            data: {
                subtotal: subtotal,
                grandTotal: grandTotal // Grand total
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
            },
            success: function (response) {
                if (response.status === 'unauthenticated') {
                    // If user is not logged in, redirect to the login page
                    window.location.href = '/auth/login';
                } else if (response.status === 'success') {
                    showSuccessMessage('Order placed successfully please enter info to confirm order')
                    // Optionally, redirect the user to an order summary page
                    window.location.href = '/payments';
                } else {
                    alert('An error occurred while placing the order.');
                }
            },
            error: function (response) {
                console.log('Error status:', response.status);  // Log the status code
                console.log(response.responseText);  // Log the actual response text for more details
                alert('An error occurred. Status: ' + response.status);
            }
        });
    });



    function loadCharges() {
        $.ajax({
            url: '/get', // Update with the correct route for fetching charges in JSON
            method: 'GET',
            success: function (response) {
                if (response.length > 0) {
                    const charges = response[0];

                    // Update global variables
                    tax = parseFloat(charges.tax); // Access tax
                    delivery = parseFloat(charges.delivery_charges); // Access delivery charges
                    discount = parseFloat(charges.discount); // Access discount

                    showCart();
                } else {
                    console.log('No charges data available.');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    // Call loadCharges on page load to initialize global variables
    loadCharges();
});
