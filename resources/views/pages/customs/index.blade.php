@extends('layouts.main')

@section('title', 'Show Control')


@section('content')
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col-lg-4">
                <custom-url-creator :images="{{ $images }}"></custom-url-creator>
            </div>
            <div class="col-lg-8">
                <custom-url-table></custom-url-table>
            </div>
        </div>
    </div>
@endsection
