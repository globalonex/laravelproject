@extends('layouts.app')

@section('content')

    <cart :order-products='{{$ordersProduct}}'/>

@endsection