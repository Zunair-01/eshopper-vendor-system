<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="{{ asset('css/customer/payment.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF token for Laravel -->
</head>

<body>

    <div class="payment-container">
        <!-- Order Summary Section -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <p>Order ID: <span id="orderId"></span></p>
            <p>Total Items: <span id="totalItems"></span></p>
            <p>Subtotal: $<span id="subtotalAmount"></span></p>
            <p><strong>Grand Total: $<span id="grandTotalAmount"></span></strong></p>
        </div>

        <!-- Payment Form Section -->
        <div class="payment-form">
            <h2>Payment Form</h2>
            <form id="paymentForm">
                <input type="hidden" id="orderIdHidden" name="orderId" value="">

                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="fullName" required>

                <label for="contact">Contact:</label>
                <input type="number" id="contact" name="contact" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod" name="paymentMethod" required>
                    <option value="" disabled selected>Select a payment method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cash_on_delivery">Cash on Delivery</option>
                </select>

                <div id="paymentDetails" style="display:none;">
                    <h3>Online Payment Details</h3>

                    <label for="cardNumber">Card Number:</label>
                    <input type="text" id="cardNumber" name="cardNumber">

                    <label for="expiryDate">Expiry Date (MM/YY):</label>
                    <input type="text" id="expiryDate" name="expiryDate">

                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv">
                </div>

                <button type="submit">Submit Payment</button>
            </form>

            <div id="orderSuccessMessage" style="display:none;">
                <h3>Payment Successfully Submitted!</h3>
                <p id="confirmationMessage"></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch order details from the database using AJAX
            $.ajax({
                url: '/get-order',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Assuming the response contains the order details
                    $('#orderId').text(response.orderId);
                    $('#totalItems').text(response.totalItems);
                    $('#subtotalAmount').text(response.subtotal);
                    $('#grandTotalAmount').text(response.grandTotal);

                    // Set hidden order ID input value
                    $('#orderIdHidden').val(response.orderId);
                },
                error: function (error) {
                    console.log('Error fetching order data:', error);
                }
            });

            // Toggle payment details visibility based on selected payment method
            $('#paymentMethod').change(function () {
                const selectedMethod = $(this).val();
                const paymentDetails = $('#paymentDetails');
                if (selectedMethod === 'credit_card' || selectedMethod === 'paypal' || selectedMethod === 'bank_transfer') {
                    paymentDetails.show();
                } else {
                    paymentDetails.hide();
                }
            });

            // Handle form submission via AJAX
            $('#paymentForm').submit(function (e) {
                e.preventDefault(); // Prevent page reload

                const formData = {
                    orderId: $('#orderIdHidden').val(),
                    fullName: $('#fullName').val(),
                    contact: $('#contact').val(),
                    address: $('#address').val(),
                    paymentMethod: $('#paymentMethod').val(),
                    cardNumber: $('#cardNumber').val() || null,
                    expiryDate: $('#expiryDate').val() || null,
                    cvv: $('#cvv').val() || null
                };

                // Submit payment data via AJAX
                $.ajax({
                    url: '/store-payment',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function (response) {
                        window.location.href = '/cus-home';

                    },
                    error: function (error) {
                        console.error('Error submitting payment:', error);
                    }
                });

                // Reset form after submission
                this.reset();
                $('#paymentDetails').hide();
            });
        });
    </script>
</body>

</html>
