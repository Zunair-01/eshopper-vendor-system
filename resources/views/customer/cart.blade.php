<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/customer/cart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/customer/home.js') }}"></script>
    <title>Cart Screen</title>
</head>
<body>
    <div class="container">
        <h1>Cart Screen</h1>
        <div class="cart-items">
            <!-- Cart items will be dynamically populated here -->
        </div>

        <div class="total-details">
            <div>
                <span id="subtotal-amount" class="subtotal-amount"></span><br>
                <small><span id="tax" class="tax-amount">Tax: $0.00</span></small><br>
                <small><span id ="delivery"class="delivery-amount">Delivery Charges: $0.00</span></small><br>
                <small><span  id="discount"class="discount-amount">Discount: $0.00</span></small><br>
            </div>
            <div class="grand-total total-container">
                <span id="grand-total-amount">Grand Total: $0.00</span>
                <button class="checkout-button">Checkout</button>
            </div>
        </div>
    </div>
</body>
</html>
