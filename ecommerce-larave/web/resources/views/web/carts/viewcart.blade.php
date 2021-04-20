@extends('web.layout')
@section('content')
<!-- cart Content -->
@php $r =   'web.carts.cart' . $final_theme['cart']; @endphp
@include($r)
@endsection
