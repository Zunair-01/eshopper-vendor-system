<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/customer/customerMasterlayout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/customer/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/cart.css') }}">
    @livewireStyles
</head>
<body>
    @include('customer.cus-layouts.header')
    <div class="container">
        @include('customer.cus-layouts.sidebar')
        <main class="main-content">
            @include('customer.chat')
            @yield('content')
            @yield('scripts')
        </main>
    </div>
    {{--  @include('customer.cus-layouts.footer')  --}}


    @livewireScripts
</body>
</html>
