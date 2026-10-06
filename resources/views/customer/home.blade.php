@extends('customerMasterlayout')

@section('title', 'Customer | Home')

@section('content')

<h1 class="page-heading">Our Products >> <span id="selected-category">All</span></h1>

<div class="products-container">

</div>

@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('js/customer/home.js') }}"></script>
@endsection
