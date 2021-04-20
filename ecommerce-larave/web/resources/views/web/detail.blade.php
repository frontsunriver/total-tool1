@extends('web.layout')
@section('content')
@php $r =   'web.details.detail' . $final_theme['detail']; @endphp
@include($r)
@include('web.common.scripts.addToCompare')
@endsection
