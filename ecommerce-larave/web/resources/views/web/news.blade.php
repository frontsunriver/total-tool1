@extends('web.layout')
@section('content')
<!-- Site Content -->
@php $r =   'web.news.news' . $final_theme['blog']; @endphp
@include($r)
@endsection
