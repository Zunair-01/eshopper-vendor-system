@extends('app')

@section('page-title', 'Admin Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Total Customers Box -->
            <div class="col-md-4">
                <div class="info-box total-customers">
                    <h3><i class="fas fa-users"></i> Total Customers</h3>
                    <p id="total-customers" class="data-number">Loading...</p> <!-- Placeholder for dynamic data -->
                </div>
            </div>

            <!-- Total Orders Box -->
            <div class="col-md-4">
                <div class="info-box total-orders">
                    <h3><i class="fas fa-shopping-cart"></i> Total Orders</h3>
                    <p id="total-orders" class="data-number">Loading...</p> <!-- Placeholder for dynamic data -->
                </div>
            </div>

            <!-- Total Sales Box -->
            <div class="col-md-4">
                <div class="info-box total-sales">
                    <h3><i class="fas fa-dollar-sign"></i> Total Sales</h3>
                    <p id="total-sales" class="data-number">Loading...</p> <!-- Placeholder for dynamic data -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome CDN -->

    <script>
        $(document).ready(function() {
            // Perform AJAX request using jQuery
            $.ajax({
                url: '{{url('home-data') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // Update the DOM with the fetched data
                    $('#total-customers').text(data.totalCustomers);
                    $('#total-orders').text(data.totalOrders);
                    $('#total-sales').text('$' + parseFloat(data.totalSales).toFixed(2));
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/home.css') }}">
@endsection
