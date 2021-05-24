@extends('layouts.main')

@section('title', 'Dashboard')


@section('content')
    <div class="row content w-100 min-h-100 flex justify-content-center align-items-center">
        <div class="col-xl-8 my-4">
            <user-settings :tokens="{{ json_encode($api_tokens) }}"></user-settings>
        </div>
    </div>
@endsection
