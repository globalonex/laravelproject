
@extends('layouts.app')

@section('content')
    
            <product-list-component
                :products='{{$products}}'
                :orders-products='{{$ordersProducts}}'/>
            
            
        
@endsection