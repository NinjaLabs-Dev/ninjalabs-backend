@extends('layouts.main')

@section('title', 'Server Stats')


@section('content')
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col-lg-12">
                <servers-table :servers="{{ json_encode($servers) }}"></servers-table>
            </div>
        </div>
    </div>
@endsection
