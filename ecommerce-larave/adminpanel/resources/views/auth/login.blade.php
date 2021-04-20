@extends('web.layout')
@section('content')
@php $r =   'auth.logins.login' . $final_theme['login']; @endphp
@include($r)
@endsection
