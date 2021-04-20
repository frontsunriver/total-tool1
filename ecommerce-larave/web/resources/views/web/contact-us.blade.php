@extends('web.layout')
@section('content')
@php $r =   'web.contacts.contact' . $final_theme['contact']; @endphp
@include($r)
@endsection
