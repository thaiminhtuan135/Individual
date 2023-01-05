@extends('include.layouts.admin')
@section('content')
    <create-company :data="{{json_encode([
        'urlStore' => route('company.store'),

])}}">
    </create-company>
@endsection
