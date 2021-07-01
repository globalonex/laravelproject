@extends('layouts.app')

@section('content')
    <profile :orders="{{$orders}}"/>
@endsection