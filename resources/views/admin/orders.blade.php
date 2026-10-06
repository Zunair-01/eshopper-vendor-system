@extends('app')

@section('title')
Orders
@endsection

@section('content')
<div class="container">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>SR No.</th>
                <th>Order ID</th>
                <th>Order Items</th>
                <th>Customer Name</th>
                <th>Grand Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="ordersTableBody">
            <!-- Fetched data will be injected here -->
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/admin/orders.js') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/orders.css') }}">
@endsection
