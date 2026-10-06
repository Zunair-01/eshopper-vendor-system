@extends('app')

@section('content')
<livewire:admin-chat/>
@endsection

@section('title')
Chats
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/chat.css') }}">
@endsection
