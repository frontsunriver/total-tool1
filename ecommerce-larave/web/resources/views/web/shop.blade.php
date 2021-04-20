@extends('web.layout')
@section('content')
 @php $r =   'web.shop-pages.shop' . $final_theme['shop']; @endphp
 @include($r)
 @include('web.common.scripts.addToCompare')
@endsection
