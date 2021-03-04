@extends('layouts.main')

@section('title', 'Show Control')


@section('content')
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col-lg-4">
                <show-image-creator></show-image-creator>
            </div>
            <div class="col-lg-8">
                <show-images-table></show-images-table>
            </div>
        </div>
    </div>
@endsection
